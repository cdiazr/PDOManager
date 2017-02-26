# PDOManager v1.1.0
Manage PDO statements easly thanks to this PDO wrapper with prepared statements.

Table of Contents
**[Prerequisites](#prerequisites)**
**[Installation](#installation)**
**[Initialization](#initialization)**
**[Test Connection](#test-connection)** 
**[Insert Query](#insert-query)** 
**[Update Query](#update-query)**
**[Count](#count)**
**[Select Query](#select-query)**
**[Where Conditions](#where-conditions)**
**[Join Method](#join-method)**

### Prerequisites
To make it run, you will need php pdo extensions enabled. The extension will depend of type of database you are going to use. PDOManager can work with many types of database such us MySQL, SQL Server, PostgreSQL, Oracle, SQL Lite, ODBC, Cubrid, SyBase, Firebird and IBM. But this class was thinked to use with the most used ones as MySQL, SQL Server, PostgreSQL adn SQL Lite.

### Installation
To utilize this class, first import PDOManager.php into your project, and require it.

```php
require_once 'path/to/PDOManager.php';
```

### Initialization
There's no difference as you are doing it until now. Simply pass the connection data when you instance the class.

```php
$db = new PDOManager('hostname', 'username', 'password', 'db_name', 'driver', 'port');
```
Last two parameters are optionals. If you don't send any driver, by default the connection will be done with MySQL driver.

### Test Connection
If you want to test your connection first, before to start coding.

```php
$db->testConnection();
// This function returns true or false 
```

### Insert Query

```php
$array = [ 
    'field1' => 'value1', 
    'field2' => 'value2', 
    ... 
]; 

$db->insert('table', $array); 
```

### Update Query

```php
$array = [ 
    'field1' => 'value1', 
    'field2' => 'value2', 
    ... 
]; 

$db->where('field', $value); 
$db->update('table', $array);  
```
### Count
```php
$db->getCount('table', 'field');
```

### Select Query
A simple select statement

```php
// This one will contain an array of all rows
$data = $db->get('table');
```
or select with custom columns set.

```php
$cols = array('field1', 'field2', 'field3');
$data = $db->get('table', $cols);
```
### Where Conditions
We can use as many WHERE conditions as we need

```php
$db->where('field1', $value1);
$db->where('field2', $value2);

$db->get('table');
// Gives: SELECT * FROM table WHERE field1 = 'value1' AND field2 = 'value2'
```

Using OR statment (always after WHERE statment)
```php
$db->where('field1', $value1);
$db->orWhere('field1', $value2);

$db->get('table');
// Gives: SELECT * FROM table WHERE field1 = 'value1' OR field1 = 'value2'
```
Notice those both statments should be together always on that order.

### SubQuerys
Now you can include subqueries into the main one just when you need load some value as a column into the main SELECT query.
You can use as many subselect into main query as you need, just you need to construct each subQuery as a group before to call other where, orwhere, join, groupby, orderby or any other to add into main SELECT with get() method.
```php
# ------ Group SELECT column 2 ---------
$column = ['field2']; 
$this->where('field1', 'table1.field');
$subQuery = $this->subQueryAsColumn('table2', $column, 'columnName');
# -------------------------------

$select = ['field1', $subQuery, 'field3' ];
$this->get('table1', $select);
// Gives: 
// SELECT field1, (SELECT field2 FROM table2 WHERE field1 = table1.field) as columnName, field3 FROM table1
```

## Methods

### Join Method
We can use as many JOIN methods as we need. Type of join can be INNER, LEFT, RIGHT or FULL
```php
$db->join('table2', 'table1'. 'field1', 'field2', 'join type');
$db->get('table1');
// Gives: SELECT * FROM table1 INNER/LEFT/RIGHT/FULL JOIN table2 ON table2.field2 = table1.field1
```

### GroupBy Method

```php
$db->groupBy('field');
$db->get('table');
// Gives: SELECT * FROM table GROUP BY field
```

### OrderBy Method
Descendent order is setting up by default.
```php
$db->orderBy('field');
$db->get('table');
// Gives: SELECT * FROM table ORDER BY field DESC
```

If you want to get Ascedent order
```php
$db->orderBy('field', 'A');
$db->get('table');
// Gives: SELECT * FROM table ORDER BY field ASC
```

## Contributing
Please read [CONTRIBUTING.md][contributingFile] for details on our code of conduct, and the process for submitting pull requests to us.

## Authors
* **[Carlos Diaz][mailto]** - *Initial work* - [PDOManager][guithub]

See also the list of [contributors][contributors] who participated in this project.

[contributingFile]: https://gist.github.com/PurpleBooth/b24679402957c63ec426
[mailto]: mailto:cdiazr82@hotmail.com
[guithub]: https://github.com/cdiazr/PDOManager
[contributors]: https://github.com/cdiazr/PDOManager/graphs/contributors
