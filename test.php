<?php

require_once 'inc/config.php';

header('Content-Type: text/plain');

$db = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
$obj = new RangeTest($db);

$tests = array(
    array(1, mktime(0, 0, 0, 1, 18, 2012), mktime(0, 0, 0, 1, 26, 2012)),
    array(3, mktime(0, 0, 0, 1, 19, 2012), mktime(7, 0, 0, 1, 23, 2012)),
    array(3, mktime(18, 0, 0, 1, 26, 2012), mktime(0, 0, 0, 1, 29, 2012)),
);

printf("Item         Start               Ende          Verfuegbar\n");
printf("-----+-------------------+-------------------+-----------\n");
foreach($tests AS $test) {
    list($item, $start, $end) = $test;
    printf("%4d   %s   %s   %10d\n", $item, date('d.m.y H:i:s', $start), date('d.m.y H:i:s', $end), $obj->availableInRange($item, $start, $end));
}


class RangeTest {
    private $db;

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
        $stmt = $this->db->prepare('SELECT `amount_available` FROM `items` WHERE `id` = ?');
        $stmt->bind_param('i', $item);
        $stmt->execute();
        $stmt->bind_result($amount);
        if(!$stmt->fetch()) return null;
        $stmt->close();
        // $amount contains items total amount

        // get all requests in range and add up overlapping ones
        $requests = $this->getRequestsInRange($item, $start, $end);
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
        $stmt = $this->db->prepare('
            SELECT `id`, UNIX_TIMESTAMP(`date_from`), UNIX_TIMESTAMP(`date_until`), `amount`
            FROM `requests`
            WHERE `itemID` = ?
                AND (
                    (`date_from` BETWEEN ? AND ? OR `date_until` BETWEEN ? AND ?)
                    OR
                    (
                        (`date_from` <= ? AND `date_until` > ?)
                        OR
                        (`date_until` >= ? AND `date_from` < ?)
                    )
                )
            ORDER BY `date_from` ASC
        ');

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
