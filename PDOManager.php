<?php
/**
 * @description This class manage sql queries using PDO connector, so
 *              this is working with MySQL, SQL Server, SQL Lite, Cubrid
 *              Sybase, Firebird, IBM, ODBC, Postgrade databases and so on.
 *
 * @author Carlos Diaz <cdiazr82@hotmail.com>
 * @date September 2013
 */

class PDOManager
{
    protected $db_driver;
    protected $db_host;
    protected $db_user;
    protected $db_pass;
    protected $db_name;
    protected $db_port;

    protected $dsn;

    public $conn;
    public $query;

    public $where;
    public $orWhere;
    public $orderBy;
    public $groupBy;
    public $join;

    public $lastQueries;

    const INSERT = "INSERT INTO ";
    const UPDATE = "UPDATE ";
    const VALUES = " VALUES ";
    const SET = " SET ";

    const SELECT = "SELECT ";
    const FROM = " FROM ";
    const WHERE = " WHERE ";
    const ORWHERE = " OR ";
    const ANDWHERE = " AND ";
    const ORDERBY = " ORDER BY ";
    const GROUPBY = " GROUP BY ";
    const JOIN = " JOIN ";
    const ON = " ON ";
    const COUNT = " COUNT";

    /**
     * @return mixed
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * @param mixed $dsn
     */
    public function setDsn($driver, $host, $dbName)
    {
        $this->dsn = strtolower($driver) . ':host=' . $host . ';dbname=' . $dbName;
    }

    /**
     * @param mixed $where
     */
    public function setWhere($where = null)
    {
        $this->where = is_null($where)? '' : $where;
    }

    /**
     * @param mixed $orWhere
     */
    public function setOrWhere($orWhere = null)
    {
        $this->orWhere = is_null($orWhere)? '' : $orWhere;
    }

    /**
     * @param mixed $where
     */
    public function setJoin($join = null)
    {
        $this->join = is_null($join)? '' : $join;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query = null)
    {
        $this->query = is_null($query)? '' : $query;
    }

    /**
     * @param mixed $where
     */
    public function setLastQueries($lastQueries = null)
    {
        $this->lastQueries = "<br" . $lastQueries;
    }

    /**
     * @param mixed $orderBy
     */
    public function setOrderBy($orderBy = null)
    {
        $this->orderBy = is_null($orderBy)? '' : $orderBy;
    }

    /**
     * @param mixed $groupBy
     */
    public function setGroupBy($groupBy = null)
    {
        $this->groupBy = is_null($groupBy)? '' : $groupBy;
    }

    /**
     * @param Host $host
     * @param Username $user
     * @param Password $pass
     * @param DatabaseName $name
     * @param Driver null $driver
     * @param Port null $port
     */
    function __construct($host, $user, $pass, $name, $driver = null, $port = null)
    {
        $this->db_driver = is_null($driver)? 'mysql' : $driver;
        $this->db_host = $host;
        $this->db_user = $user;
        $this->db_pass = $pass;
        $this->db_name = $name;

        if(!is_null($port))
            $this->port = $port;
    }

    /**
     *  Connect to database
     *
     * @return \PDO
     */
    public function connect()
    {
        $this->setDsn($this->db_driver, $this->db_host, $this->db_name);

        return new \PDO($this->getDsn(), $this->db_user, $this->db_pass);
    }

    /**
     * Test connection
     *
     * @return bool
     */
    public function testConnection() {
        $c = $this->connect();

        try {
            # Set the PDO error mode to exception
            $c->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch(\PDOException $e) {
            $message = "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    /**
     * This return record rows per table
     *
     * @param TableName $t string
     * @param Field (null) $f string
     *
     * @return int
     * @throws Exception
     */
    public function getCount($t, $f = null)
    {
        if (empty($t))
            throw new Exception;

        if(!is_null($f))
            $count = self::COUNT . "(" . $f . ") ";

        $query = self::SELECT . $count . self::FROM . $t . $this->where . $this->orderBy;

        $result = self::execQuery($query);

        return $result;
    }

    /**
     * @param TableName(string) $t
     * @param ColumnsName(string) $c
     * @param NumRows(null) $n
     * @param Boolean $debug
     *
     * @return array()
     * @throws Exception
     */
    public function get($t, $c = null, $debug = null)
    {
        if (empty($t))
            throw new Exception;

        if(is_null($c) || empty($c))
            $c = '*';

        $columns = is_array($c) ? implode(', ', $c) : $c;

        $query = self::SELECT . $columns . self::FROM . $t . $this->join . $this->where . $this->orderBy;

        if($debug == 1) {
            $this->setLastQueries($query.PHP_EOL);
            $this->lastQueries($query);
        }

        return self::execQuery($query);
    }

    /**
     * @param TableName $t
     * @param Array $data
     * @param Boolean null $debug
     *
     * @return array|string
     */
    public function insert($t, $data, $debug = null)
    {
        $data = $this->getExtractDataArray($data);
        $query = self::INSERT . $t . '(' . $data['fields'] . ')' . self::VALUES . '(' . $data['params'] . ')';

        if($debug == 1) {
            $this->setLastQueries($query.PHP_EOL);
            $this->lastQueries($query);
        }

        return self::execQuery($query, $data['values']);
    }

    /**
     * @param TableName $t
     * @param Array $data
     * @param Boolean null $debug
     *
     * @return array|string
     * @throws Exception
     */
    public function update($t, $data, $debug = null)
    {
        if(empty($this->where) || is_null($this->where))
            throw new Exception('"WHERE" statement should be set up to update the record/s');

        $i = 1;
        $set = '';
        $fields = count($data);
        foreach ($data as $key => $value) {
            if(is_string($value))
                $value = "'" . $value . "'";

            $set .= $i !== count($data)? $key . ' = ' . $value .', ' : $key . '=' . $value;
            $i++;
        }

        $query = self::UPDATE . $t . self::SET . $set . $this->where;

        if($debug == 1) {
            $this->setLastQueries($query.PHP_EOL);
            $this->lastQueries($query);
        }

        return self::execQuery($query);
    }

    /**
     * @param Field $f
     * @param Value $v
     * @param TypeOfSearch $t
     *
     * @return string
     */
    public function where($f, $v, $t = null)
    {
        $v = (is_string($v)) ? "'" . $v . "'" : $v;

        if ($t == 'S') {       // Start with
            $v = $v . '%';
        } elseif ($t == 'C') { // Contains
            $v = '%' . $v . '%';
        } elseif ($t == 'E') { // End with
            $v = '%' . $v;
        }

        $o = ($t == 'S' || $t == 'C' || $t == 'E') ? ' LIKE ' :' = ';

        return $this->where .= (empty($this->where))? self::WHERE . $f . $o . $v : self::ANDWHERE . $f . $o . $v;
    }

    /**
     * @param Field $f
     * @param Value $v
     * @param TypeOfSearch $t
     *
     * @return string
     */
    public funcion orWhere($f, $v, $t = null)
    {
        $v = (is_string($v)) ? "'" . $v . "'" : $v;

        if ($t == 'S') {       // Start with
            $v = $v . '%';
        } elseif ($t == 'C') { // Contains
            $v = '%' . $v . '%';
        } elseif ($t == 'E') { // End with
            $v = '%' . $v;
        }

        $o = ($t == 'S' || $t == 'C' || $t == 'E') ? ' LIKE ' :' = ';

        return $this->orWhere .= self::ORWHERE . $f . $o . $v;
    }

    /**
     * @param $f
     * @param null $t
     * @return string
     *
     * @info By default, descendent order is already set up,
     *       if you want to order ascending, you should specifiy
     *       "A" as a second parameter
     */
    public function orderBy($f, $t = null)
    {
        $order = ($t == 'A')? ' ' . 'ASC' : ' ' . 'DESC';
        return $this->orderBy .= self::ORDERBY . $f . $order;
    }

    /**
     * @param Field $field
     * @return string
     */
    public function orderBy($field)
    {
        return $this->groupBy .= self::GROUPBY . $f;
    }

    /**
     * @param Table1 $t1
     * @param Table2 $t2
     * @param Field1 $f1
     * @param Field2 $f2
     * @param null $type ('INNER', 'LEFT', 'RIGHT', 'FULL')
     *
     * @info For more useful information about types of joins, visit http://www.sql-join.com/sql-join-types/
     */
    public function join($t1, $t2, $f1, $f2, $type = null)
    {
        if(!is_null($type))
            $type . " ";

        $this->join =  " " . $type . self::JOIN . $t1 . self::ON . $t1 . '.' . $f1 . " = " . $t2 . '.' . $f2;
    }

    /**
     * This function is useful if you want to display results from queries
     * @param $var
     */
    public function dd($var) {
        echo "<pre>";
        print_r($var);
        die;
    }

    /**
     * If you want to debut your query, this class will show you up in the monitor all queries already processed
     * @param null $query
     */
    public function lastQueries($query = null) {
        echo "<pre>";

        if(is_null($query))
            print_r($this->lastQueries);
        else
            print_r($query);
    }

    /**
     * This execute PDO queries
     *
     * @param $query
     * @return array|string
     */
    private function execQuery($query, array $array = null)
    {
        $this->lastQueries .= $query.PHP_EOL;

        $this->conn = $this->connect();

        // Preparing statement for LIMIT method
        $isLimitIn = preg_match('/LIMIT/', $query);
        if($isLimitIn) {
            $this->conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        }
                
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare($query);
            $stmt->execute($array);

            $this->conn->commit();

            $this->cleanQuery();

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC))
                $rows[] = $row;

            return $rows;
        } catch(\PDOException $e) {
            $this->rollback();
            return "Error: " . $e->getMessage();
        }
    }

    private function cleanQuery()
    {
        $this->setWhere();
        $this->setOrWhere();
        $this->setOrderBy();
        $this->setQuery();
        $this->setJoin();
    }

    private function getExtractDataArray(array $array)
    {
        $fields = [];
        $values = [];
        foreach ($array as $key => $value) {
            $fields[] = $key;
            $values[] = $value;
        }

        $params = '';
        for($i = 1; $i <= count($fields); $i++)
            $params .= $i == count($fields)? '?' : '?,';

        return ['fields' => implode(',', $fields), 'params' => $params, 'values' => $values];
    }
}