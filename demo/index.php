<?php

namespace rain1;

use rain1\ConditionBuilder\ConditionBuilder;
use rain1\ConditionBuilder\Expression\MySQL\Date\Date;
use rain1\ConditionBuilder\Operator\IsBetween;
use rain1\ConditionBuilder\Operator\IsEqual;

require __DIR__ . '/../autoload.php';

function buildQueryFilterUser($filters) {

	$defaults = [
		'id'                     => null,
		'banned'                 => null,
		'last_login_range_start' => null,
		'last_login_range_end'   => null,
		'email'                  => null,
	];
	$filters  = $filters + $defaults;

	$condition = new ConditionBuilder(ConditionBuilder::MODE_AND);

	$condition->append(
		new IsEqual('id', $filters['id']),
		new IsEqual('last_login', Date::now()),
		new IsEqual('email', $filters['email']),
		new IsEqual('banned', is_null($filters['banned']) ? null : (int)$filters['banned']),
		new IsBetween("last_login", $filters["last_login_range_start"], $filters["last_login_range_end"])
	);

	$query = "SELECT * FROM user WHERE $condition";

	return [
		'query'  => $query,
		'vaules' => $condition(),
		'debug'  => "SELECT * FROM user WHERE " . $condition->__debugInfo()['desired'],
	];

}

header("Content-type: text/plain");

//echo file_get_contents(__FILE__);

$queryInfos = buildQueryFilterUser(['id' => [1, 2], 'email' => "donald@me.com"]);
print_r($queryInfos);
//$smt =  $pdo->prepare($queryInfos['query']);
//$smt->execute($queryInfos['values']);