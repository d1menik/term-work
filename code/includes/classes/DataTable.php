<?php
/**
 * Created by PhpStorm.
 * User: DominikMosner
 * Date: 17/01/2019
 * Time: 14:10
 */

class DataTable
{
    private $dataSet;
    private $columns;
    private $string;

    public function __construct($dataSet, $string)
    {
        $this->dataSet = $dataSet;
        $this->string = $string;
    }

    public function addColumn($databaseColumnName, $tht)
    {
        $this->columns[$databaseColumnName] = array("table-head-title" => $tht);
    }

    public function render()
    {
        echo "<h2>" . $this->string. "</h2>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        foreach ($this->columns as $key => $value) {
            echo "<th>" . $value["table-head-title"] . "</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($this->dataSet as $row) {
            echo "<tr>";
            foreach ($this->columns as $key => $value) {
                echo "<td>" . $row[$key] . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
}