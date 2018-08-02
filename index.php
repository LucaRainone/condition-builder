<?php

namespace raind1;

use rain1\ConditionBuilder\ConditionBuilder;
use rain1\ConditionBuilder\Expression\Expression;
use rain1\ConditionBuilder\Expression\MySQL\Date\Date;
use rain1\ConditionBuilder\Expression\MySQL\Date\DateAdd;
use rain1\ConditionBuilder\Operator\IsBetween;
use rain1\ConditionBuilder\Operator\IsEqual;
use rain1\ConditionBuilder\Operator\IsGreater;

require __DIR__ . '/vendor/autoload.php';

$pdo = new \PDO('mysql:host=127.0.0.1;port=3306;dbname=test', "root", "root");

function filterUsers(\PDO $pdo, $filters) {

    $defaults = [
       'id' => null,
       'banned' => null,
       'last_login_range_start' => null,
       'last_login_range_end' => null,
       'email' => null
    ];
    $filters = $filters + $defaults;

    $condition = new ConditionBuilder(ConditionBuilder::MODE_AND);

    $condition->append(
        new IsEqual('id', $filters['id']),
        new IsEqual('last_login', Date::now()),
        new IsEqual('email', $filters['email']),
        new IsEqual('banned', is_null($filters['banned'])? null : (int)$filters['banned']),
        new IsBetween("last_login", $filters["last_login_range_start"],$filters["last_login_range_end"])
    );

    $condition2 = new ConditionBuilder(ConditionBuilder::MODE_AND);
    $condition2->append(
       new IsGreater("last_login",new DateAdd(Date::now(), 4, DateAdd::UNIT_MONTH))
    );

    var_dump($condition2->build());
    die();

    var_dump($condition);
    $stmt = $pdo->prepare("SELECT * FROM user WHERE $condition");

    $result = $stmt->execute($condition());

    if(!$result)
        throw new \Exception("Error query " . print_r($stmt->errorInfo(), true));

    return $stmt->fetchAll();
}

//$users = filterUsers($pdo, ['id'=>[1,2], 'banned' => 1]);
//$users = filterUsers($pdo, ['email' => "pippo@pluto.it"]);
$users = filterUsers($pdo, ['last_login_range_end' => new Expression("NOW()")]);
var_dump($users);