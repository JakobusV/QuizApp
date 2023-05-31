<?php
class BaseModel {
    public int $id;
    /**
ааа * Allows for all or specific columns to be retrieved on table, returns query string for execution.
ааа * @param mixed $columns Optional: Columns that exist within the table, used to specify return data. If blank will return all columns.
ааа * @param mixed $filters Optional: Filters for the query specified by strings. Filters are only attached with AND operators.
    * @param bool  $json    Optional: Defaults to true, either returns columns as json or plain
ааа * @return string Query for phpapi database
ааа */
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
     * Creates a dynamic join between two valid tables given and two valid columns to join by.
     * @param string $joinedTable        Required: Table to join onto the base table.
     * @param mixed $joinedColumns       Optional: Columns that exist within the joined table, used to specify return data. If blank will return all columns.
     * @param string $joinedTargetColumn Required: Target column in the joined table to join on the origin column in the base table.
     * @param string $joinType           Optional: Defaults to INNER, supports all join types.
     * @param mixed $baseColumns         Optional: Columns that exist within the base table, used to specify return data. If blank will return all columns.
     * @param string $baseOriginColumn   Required: Origin column in the base table to join with the target column in the joined table.
     * @param mixed $filters             Optional: Filters for the query specified by strings. Filters are only attached with AND operators.
     * @param bool $json                 Optional: Defaults to true, either returns columns as json or plain.
     * @return string                    Query for phpapi database.
     */
    public function SelectJoinQuery($joinedTable = "", $joinedColumns = array(), $joinedTargetColumn = "", $joinType = "INNER", $baseColumns = array(), $baseOriginColumn = "", $filters = array(), $json = true, $limit = 100) {
        // Validate joining table
        $tableResult = $this->ValidateJoiningTable($joinedTable, $joinedColumns);
        if (is_bool($tableResult) && $tableResult == false) throw new UnexpectedValueException("Table is not valid");

        // Validate join type
        $joinType = strtoupper($joinType);
        if ($joinType != "LEFT" && $joinType != "INNER" && $joinType != "RIGHT" && $joinType != "CROSS") throw new UnexpectedValueException("Join type is not valid");

        // Get formatted columns of both the base table and joined table
        foreach ($baseColumns as $column)
            $this->ValidateColumn($column);
        if (count($baseColumns) == 0)
            $baseColumns = array_keys(get_class_vars(get_class($this)));
        if (count($joinedColumns) == 0)
            $joinedColumns = array_keys(get_class_vars(get_class($tableResult)));
        $this->ValidateColumn($baseOriginColumn);
        $tableResult->ValidateColumn($joinedTargetColumn);
        $formattedCombinedColumns = $this->CreateSelectColumnFormatForJoins($baseColumns, $joinedColumns, $json);

        // Add filters
        $filter = '';
        if (count($filters) > 0)
            $filter = 'WHERE '.join(' AND ', $filters);

        return 'SELECT '.$formattedCombinedColumns.' FROM '.get_class($this).' as base '.$joinType.
            ' JOIN '.get_class($tableResult).' as joined ON base.'.$baseOriginColumn.' = joined'.'.'.$joinedTargetColumn.
            ' '.$filter.' LIMIT '.$limit.';';
    }
    /**
ааа * Creates SQL JSON_OBJECT format or plain comma seperated format for select statement.
ааа * @param mixed $columns
    * @param bool  $json Defaults to true, either returns columns as json or plain
ааа * @return array|string
ааа */
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
                $plainColumns .= "".$column.", ";
            $plainColumns = trim($plainColumns);
            $plainColumns = substr_replace($plainColumns, '', -1);
            return $plainColumns;
        }

    }
    /**
     * Summary of CreateSelectColumnFormatForJoins
     * @param mixed $baseColumns Columns from the base table
     * @param mixed $joinedColumns Columns from the joining table
     * @param mixed $json Defaults to true, either returns columns as json or plain
     * @return array|string
     */
    private function CreateSelectColumnFormatForJoins($baseColumns, $joinedColumns, $json = true) {
        if ($json) {
            $jsonColumns = 'JSON_OBJECT(';
            foreach($baseColumns as $column)
                $jsonColumns .= "'".$column."', base.".$column.',';
            foreach($joinedColumns as $column)
                $jsonColumns .= "'joined".ucfirst($column)."', joined.".$column.',';
            $jsonColumns = substr_replace($jsonColumns, ') as data', -1);
            return $jsonColumns;
        } else {
            $plainColumns = '';
            foreach($baseColumns as $column)
                $plainColumns .= "base.".$column.", ";
            foreach($joinedColumns as $column)
                $plainColumns .= "joined.".$column.", ";
            $plainColumns = trim($plainColumns);
            $plainColumns = substr_replace($plainColumns, '', -1);
            return $plainColumns;
        }
    }
    /**
ааа * Generic insert query utilizing all class specific properties.
ааа * @return string
ааа */
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
ааа * Generic update query utilizing all class properties.
ааа * @return string
ааа */
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
ааа * Generic delete query utilizing class' id property.
ааа * @return string
ааа */
    public function DeleteQuery() {
        return 'DELETE FROM '.get_class($this).' WHERE id = '.$this->id;
    }
    /**
ааа * Create SQL where statement using equals. Used for exact strings or number datatypes.
ааа * @param mixed $column
ааа * @param mixed $value
ааа * @return string
    */
    public function CreateFilterExact($column, $value) {
        return $column.'='.$this->FormatColumnValue($value);
    }
    /**
ааа * Create SQL where statement using LIKE. Used for stirngs and text datatypes.
ааа * @param mixed $column
ааа * @param mixed $value
ааа * @return string
ааа */
    public function CreateFilterLike($column, $value) {
        return $column." LIKE '%".$value."%'";
    }
    /**
ааа * Perform check to see if column exists within class. Throws UnexpectedValueException if column not found.
ааа * @param mixed $column
ааа * @throws UnexpectedValueException
ааа */
    protected function ValidateColumn($column) {
        if (!property_exists(get_class($this), $column))
            throw new UnexpectedValueException("Column not found within table. column:".$column." table:".get_class($this));
    }
    /**
     * Checks that the string table name is valid and validates all columns
     * @param mixed $joinedTable Table name to be joined
     * @param mixed $joinedTableColumns Columns of the joined table
     * @return bool|question|quiz|user Returns table object or false if not valid
     */
    protected function ValidateJoiningTable($joinedTable, $joinedTableColumns) {
        $joinedTable = strtolower($joinedTable);
        // Valid table name?
        if (!IsValidTable($joinedTable)) return false;
        // Create new object based on name of table
        $table;
        switch($joinedTable) {
            case "user":
                $table = new user();
                break;
            case "quiz":
                $table = new quiz();
                break;
            case "question":
                $table = new question();
                break;
        }
        // Validate columns based on object
        foreach($joinedTableColumns as $column)
            $table->ValidateColumn($column);
        return $table;
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