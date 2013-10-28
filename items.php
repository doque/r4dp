<?

include 'global.php';



$db->query('SELECT * FROM `items` ORDER BY `name` DESC');
$items = array();

while ($row = $db->fetchAssoc()) {
	$items[$row['id']] = $row;
}

$success = false;

if (isset($_POST['sent'])) {
	foreach ($_POST['item'] as $id => $available) {
		if (in_array($id, array_keys($items)) && $available != $items[$id]['available']) {	$db->query('UPDATE `items` SET `available` = %d WHERE `id` = %d', $available, $id);
			// change in items array which is used in tpl
			$items[$id]['available'] = $available;
		}
	}
	$success = true;
}



$tpl->assign('items', $items);
$tpl->assign('success', $success);

$tpl->display('items.tpl');

?>