[![Build Status](https://app.travis-ci.com/LucaRainone/condition-builder.svg?branch=master)](https://travis-ci.org/LucaRainone/conditionbuilder)
[![Coverage Status](https://coveralls.io/repos/github/LucaRainone/conditionbuilder/badge.svg?branch=master)](https://coveralls.io/github/LucaRainone/conditionbuilder?branch=master)

This package allows you to build query conditions for PDO-like interfaces.

This is NOT an ORM: it's a condition builder. Let see the example:

## Usage

```php
<?php

require_once "vendor/autoload.php";

use rain1\ConditionBuilder\ConditionBuilder;
use rain1\ConditionBuilder\Operator\IsEqual;
use rain1\ConditionBuilder\Operator\IsLess;

$condition = new ConditionBuilder(ConditionBuilder::MODE_AND);

$condition->append(
	new IsEqual("id", 3), // id = ? AND
	new IsLess("priority", 100), // priority < ? AND
	new IsEqual("myCol", [1,2,3]), // myCol IN (?,?,?)
	new IsEqual("anotherCol", null), // it will be ignored because null value
	(new ConditionBuilder(ConditionBuilder::MODE_OR))
		->append(
			new IsEqual("col1", 3), // col1 = ? OR
			new IsEqual("someflag", 0) // someflag = ?
		)
);

$query =  "SELECT * FROM myTable WHERE $condition";

echo $query."\n";
print_r($condition()); // shortcut of $condition->values() it returns an array with all values

//$res = $pdo->prepare($query)->execute($condition->values());

```

This will produce the following output:

```

SELECT * FROM myTable WHERE (id = ? AND priority < ? AND myCol IN (?,?,?) AND (col1 = ? OR someflag = ?))
Array
(
    [0] => 3
    [1] => 100
    [2] => 1
    [3] => 2
    [4] => 3
    [5] => 3
    [6] => 0
)

```

## Where is the magic?

Well, let suppose we want to write a function that filter rows in a MySQL table. Generally, if we don't want use some magic
framework or ORM, we have to do a lot of `if` conditions and we have to concatenate the query and push params values.

That's the ConditionBuilder internal job.

```php
<?php
function filterUser(array $filters = []) : array
{
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
        new IsEqual('email', $filters['email']),
        new IsEqual('banned', $filters['banned']),
        new IsBetween("last_login", $filters["last_login_range_start"], $filters["last_login_range_end"])
    );
    
    return YourMysqlLibrary::query("SELECT * FROM user WHERE $condition", $condition());
}

$rows = filterUser([
    'id' => [1,2,3]
]); // users with id 1,2 or 3 

$rows = filterUser([
    'last_login_range_start' => date("Y-m-d 00:00:00", "yesterday"),
    'banned' => 0
]); // users not banned and logged yesterday or today

$rows = filterUser([
    'last_login_range_start' => "2021-01-01",
    'last_login_range_end' => "2021-01-31",
    'banned' => 1
]); // users actually banned and last seen in Jan 2021

$rows = filterUser([
    'email' => "user@example.org"
]); // user with specified email
// and so on

```

So you can easily build a lot of searches with a minimal function.

Of course, it is a simple condition helper, so your query can be more complex. You can use more than one 
ConditionBuilder and you can append them to another.

## Beaware

If the ConditionBuilder is empty (it means all filters are null), the result will be:

- `(TRUE)`, if the mode is ConditionBuilder::MODE_AND
- `(FALSE)`, if the mode is ConditionBuilder::MODE_OR

So be carefull especially if you use it with `DELETE` statements.