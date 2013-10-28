<?php

class RangeTest {
    private $db;
    public $ignoreApproved = true;

    public function __construct(&$db) {
        assert($db instanceof mysqli);
        $this->db = $db;
    }

    /**
     * find out how many pieces of an item are available during a certain period of time (total amount - lended out)
     *
     * @param int $item the item id to check
     * @param int $start unix timestamp of period start
     * @param int $end unix timestamp of period end
     * @return mixed NULL in case of error, otherwise number of available pieces (may be negative if overbooked)
     */
    public function availableInRange($item, $start, $end) {
        assert($end > $start);

        // get item amount
        $stmt = $this->db->prepare('SELECT `available` FROM `items` WHERE `id` = ?') or die($this->db->error);
        $stmt->bind_param('i', $item);
        $stmt->execute();
        $stmt->bind_result($amount);
        if(!$stmt->fetch()) return null;
        $stmt->close();
        // $amount contains items total amount

        // get all requests in range and add up overlapping ones
        $requests = $this->getRequestsInRange($item, $start, $end);

        #var_dump($requests);

        if(!count($requests)) return $amount;
        foreach($requests AS $i => $current) {
            foreach($requests AS $j => $compare) {
                if($i == $j) continue;
                if($current['start'] < $compare['end'] && $current['end'] > $compare['start']) { // overlapping
                    $requests[$j]['amount'] += $current['amount'];
                }
            }
        }
        // get highest amount (that is lended out at the same time within that period)
        $max = null;
        foreach($requests AS $key => $req) {
            if($max === null || $req['amount'] > $requests[$max]['amount']) {
                $max = $key;
            }
        }


        return $amount - $requests[$max]['amount'];
    }

    /**
     * returns all relevant information about requests that are booked for a certain item in a certain period of time
     *
     * @param int $item the item id to check
     * @param int $start unix timestamp of period start
     * @param int $end unix timestamp of period end
     * @return array all requests in that period as assoc array
     */
    public function getRequestsInRange($item, $start, $end) {


        $addWhere = '';
        if($this->ignoreApproved === false) {
            $addWhere .= 'AND `status` = "approved"';
        }
        
        $stmt = $this->db->prepare('
            SELECT `id`, UNIX_TIMESTAMP(`date_from`), UNIX_TIMESTAMP(`date_until`), `amount`
            FROM `requests` AS `r`
            INNER JOIN `requestitems` AS `ri` ON `ri`.`requestid` = `r`.`id` AND `ri`.`itemid` = ?
            WHERE (
                (`date_from` BETWEEN ? AND ? OR `date_until` BETWEEN ? AND ?)
                    OR
                    (
                        (`date_from` <= ? AND `date_until` > ?)
                        OR
                        (`date_until` >= ? AND `date_from` < ?)
                    )
                )
            ORDER BY `date_from` ASC
        ') or die($this->db->error);

        $s = $this->timeToString($start);
        $e = $this->timeToString($end);

        
        $stmt->bind_param('issssssss', $item, $s, $e, $s, $e, $s, $s, $e, $e);
        $stmt->execute();
        $stmt->bind_result($id, $start, $end, $amount);


        $requests = array();
        while($stmt->fetch()) {
            $requests[] = array(
                'id'     => $id,
                'start'  => $start,
                'end'    => $end,
                'amount' => $amount,
            );
        }
        $stmt->close();
        return $requests;
    }

    /**
     * converts unix timestamp to mysql datetime format
     *
     * @param int $timestamp the unix timestamp to convert
     * @return string mysql datetime format
     */
    public static function timeToString($timestamp) {
        return strftime('%Y-%m-%d %H:%M:%S', $timestamp);
    }
}
