<?php
include_once 'header.php';
include_once 'backend/backendUtils.php';
include_once 'backend/models.php';
GenerateHeader("Admin Page", ['admin.css']);
//CanIBeHere(true);

/**
 * Echos a secondary nav bar used to quickly travel between database table pages.
 */
function GenerateAdminNavigationElement() {
    $tableNames = GetAllTables();
    $buildArray = ['<nav class="navlinks">'];
    foreach ($tableNames as $tableName)
        $buildArray[] = "<a href=\"admin.php?table=$tableName\">$tableName</a>";
    $buildArray[] = '</nav>';
    $navigationElement = implode('', $buildArray);
    echo $navigationElement;
}

/**
 * Checks url param, validates table, generates table element.
 * If unsuccessful, will generate page with useful information.
 * @return void
 */
function BuildPage() {
    if (isset($_GET['table'])) {
        $model = TryModelFromString($_GET['table']);
        if (!is_null($model))
            return GenerateAdminTable($model);
    } else 
        header('Location: admin.php?table=user');
    UnsuccessfulPage();
}

/**
 * Create model from string, validates instance of basemodel.
 * @param string $tableName exact name of model to be created
 * @return BaseModel|null returns basemodel if class exists and instance of basemodel, otherwise null.
 */
function TryModelFromString(string $tableName) {
    try
    {
        $model = new $tableName();
        if ($model instanceof BaseModel)
            return $model;
        else
            return null;
    }
    catch (Exception $exception)
    {
        return null;
    }
}

/**
 * Generates a 'SELECT *' as json statement, performs query, and creates table from json using model.
 * @param BaseModel $sqlModel sql table class obj
 */
function GenerateAdminTable(BaseModel $sqlModel) {
    $selectAllJsonQuery = $sqlModel->SelectQuery();
    $selectAllJsonString = SelectExecution($selectAllJsonQuery);
    $selectAllJson = json_decode($selectAllJsonString);
    JsonToAdminTable($selectAllJson);
}

/**
 * Takes in json and echos a html table with all data and a delete option.
 * @param array $json array containing 
 */
function JsonToAdminTable(array $json) {
    if (empty($json))
        return DiscloseEmptyTable();
    $buildArray = ['<table>'];
    $buildArray[] = AdminTableHeaderRow($json[0]);
    $buildArray[] = AdminTableRows($json);
    $buildArray[] = '</table>';
    $tableHTML = implode('', $buildArray);
    echo $tableHTML;
}

/**
 * Echos div element that explains that there is no data in this table.
 */
function DiscloseEmptyTable() {
    echo '
    <div>
        It appears that the table requested does exist! However, it contains no rows...
    </div>';
}

/**
 * Create table header row with trailing delete column.
 * @param stdClass $firstRow first row of dataset, used for it's keys and will reperesent all rows.
 * @return string tr HTML element.
 */
function AdminTableHeaderRow(stdClass $firstRow) {
    $buildArray = ['<tr><th>'];
    $objectVars = get_object_vars($firstRow);
    $firstRowKeys = array_keys($objectVars);
    $firstRowKeys[] = 'DELETE';
    $buildArray[] = implode('</th><th>', $firstRowKeys);
    $buildArray[] = '</th><tr>';
    $headerRowHTML = implode('', $buildArray);
    return $headerRowHTML;
}

/**
 * Creates a string of <tr> HTML elements to be used in a table, includes delete options.
 * @param array $json array of stdClasses representing the response from the db.
 * @return string string of <tr> HTML elements. ie: '<tr>...</tr><tr>...</tr>'
 */
function AdminTableRows(array $json) {
    $buildArray = ['<tr>'];
    $dataRows = [];
    foreach ($json as $row)
        $dataRows[] = AdminRowToTableData($row);
    $buildArray[] = implode('</tr><tr>', $dataRows);
    $buildArray[] = '</tr>';
    $tableRowsHTML = implode('', $buildArray);
    return $tableRowsHTML;
}

/**
 * Create a string of <td> HTML elements to be used in a row, includes delete option.
 * @param stdClass $row stdClass of values representing a db row.
 * @return string string of <td> HTML elements. ie: '<td>val1</td><td>val2</td>'
 */
function AdminRowToTableData(stdClass $row) {
    $id = $row->id;
    $buildArray = ['<td>'];
    $rowValues = get_object_vars($row);
    $rowValues[] = "<a href=\"profile.php?u=$id\">X</a>";
    $buildArray[] = implode('</td><td>', $rowValues);
    $buildArray[] = '</td>';
    $tableDataHTML = implode('', $buildArray);
    return $tableDataHTML;
}

/**
 * Echos div element that explains that the table cannot be found/proccessed
 */
function UnsuccessfulPage() {
    echo '
    <div>
        <h3>Unavailable</h3>
        <p>Looks like the table you\'re trying to find is not available.</p>
    </div>';
}

?>
<body>
    <?php
    GenerateNavigationElement();
    GenerateAdminNavigationElement();
    BuildPage();
    ?>
</body>
<?php
