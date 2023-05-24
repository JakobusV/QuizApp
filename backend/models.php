<?php
class BaseModel {
    public int $id;
    /**
    * Allows for all or specific columns to be retrieved on table, returns query string for execution.
    * @param mixed $columns Optional: Columns that exist within the table, used to specify return data. If blank will return all columns.
    * @param mixed $filters Optional: Filters for the query specified by strings. Filters are only attached with AND operators.
    * @param bool  $json    Optional: Defaults to true, either returns columns as json or plain
    * @return string Query for phpapi database
    */
    public function SelectQuery($columns = array(), $filters = array(), $json = true, $limit = 100) {
        foreach ($columns as $column)
            $this->ValidateColumn($column);
        $formattedColumns = $this->CreateSelectColumnFormat($columns, $json);
        $filter = '';
        if (count($filters) > 0)
            $filter = 'WHERE '.join(' AND ', $filters);
        return 'SELECT '.$formattedColumns.' FROM '.get_class($this).' '.$filter.' LIMIT '.$limit.';';
    }
    /**
    * Creates SQL JSON_OBJECT format or plain comma seperated format for select statement.
    * @param mixed $columns
    * @param bool  $json Defaults to true, either returns columns as json or plain
    * @return array|string
    */
    private function CreateSelectColumnFormat($columns = array(), $json = true) {
        if (count($columns) == 0)
            $columns = array_keys(get_class_vars(get_class($this)));
        if ($json) {
            $jsonColumns = 'JSON_OBJECT(';
            foreach($columns as $column)
                $jsonColumns .= "'".$column."', ".$column.',';
            $jsonColumns = substr_replace($jsonColumns, ') as data', -1);
            return $jsonColumns;
        } else {
            $plainColumns = '';
            foreach($columns as $column)
                $plainColumns .= "'".$column."', ";
            return $plainColumns;
        }

    }
    /**
    * Generic insert query utilizing all class specific properties.
    * @return string
    */
    public function InsertQuery() {
        $values = get_class_vars(get_class($this));
        array_splice($values, 0, 1);
        $query = 'INSERT INTO '.get_class($this).' ';
        $columnNames = '('.join(', ', array_keys($values)).')';
        $columnValues = array();
        foreach ($values as $column => $val)
            array_push($columnValues, $this->FormatColumnValue($this->$column));
        return $query.$columnNames.' VALUES ('.join(', ', $columnValues).');';
    }
    /**
    * Generic update query utilizing all class properties.
    * @return string
    */
    public function UpdateQuery() {
        $values = get_class_vars(get_class($this));
        $query = 'UPDATE '.get_class($this).' SET ';
        $columnChanges = array();
        foreach ($values as $column => $val)
            array_push($columnChanges, $column.' = '.$this->FormatColumnValue($this->$column));
        $query .= join(', ', $columnChanges).' WHERE id = '.$this->id;
        return $query;
    }
    /**
    * Generic delete query utilizing class' id property.
    * @return string
    */
    public function DeleteQuery() {
        return 'DELETE FROM '.get_class($this).' WHERE id = '.$this->id;
    }
    /**
    * Create SQL where statement using equals. Used for exact strings or number datatypes.
    * @param mixed $column
    * @param mixed $value
    * @return string
    */
    public function CreateFilterExact($column, $value) {
        return $column.'='.$this->FormatColumnValue($value);
    }
    /**
    * Create SQL where statement using LIKE. Used for stirngs and text datatypes.
    * @param mixed $column
    * @param mixed $value
    * @return string
    */
    public function CreateFilterLike($column, $value) {
        return $column." LIKE '%".$value."%'";
    }
    /**
    * Perform check to see if column exists within class. Throws UnexpectedValueException if column not found.
    * @param mixed $column
    * @throws UnexpectedValueException
    */
    protected function ValidateColumn($column) {
        if (!property_exists(get_class($this), $column))
            throw new UnexpectedValueException("Column not found within table. column:".$column." table:".get_class($this));
    }

    /**
     * Formats given value for sql query usage
     * String data types are surounded by single quotes
     * Bool data types are converted to 1 for true and 0 for false
     * Other numbers are unchanged
     * @param mixed $value
     * @return mixed
     */
    protected function FormatColumnValue($value) {
        if (is_string($value)) return "'" . $value . "'";
        else if (is_bool($value)) return ($value)? 1 : 0;
        else return $value;
    }
}

/**
 * Validates string and checks if table exists.
 * @param mixed $tableName Name of table (Exact)
 * @return bool Whether or not table exists.
 */
function IsValidTable($tableName = "") {
    if ($tableName === null || trim($tableName) === '')
        return false;

    if (in_array($tableName, GetAllTables()))
        return true;
    else
        return false;
}

/**
 * Retrieve all mysql table names
 * @return array
 */
function GetAllTables() {
    $tables = array();
    $path = realpath(__FILE__);
    $allClasses = get_declared_classes();
    foreach ($allClasses as $class)
    {
    	$classDetails = new ReflectionClass($class);
        $filePath = $classDetails->getFileName();
        if ($filePath == $path && $class != "BaseModel")
            array_push($tables, $class);
    }
    return $tables;
}

class user extends BaseModel {
    public int $id;
    public string $username;
    public string $password;
    public bool $isAdmin;
}

class quiz extends BaseModel {
    public int $id;
    public int $userId;
    public string $title;
}

class question extends BaseModel {
    public int $id;
    public int $quizId;
    public string $content;
    public string $rightAnswer;
    public string $wrongAnswer1;
    public string $wrongAnswer2;
    public string $wrongAnswer3;
}
?>