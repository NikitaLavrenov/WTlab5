<?php

$servername = "127.0.0.1";
$username = "kalenik";
$password = "12345678";
$dbname = "wt_lab5";

function print_table(&$column_names, &$rows) {
  echo "<table class=\"db-table\">";

  echo "<tr>";
  foreach ($column_names as $column)
    echo "<th>" . $column["name"] . "</th>";
  echo "</tr>";

  foreach ($rows as $row) {
    echo "<tr contenteditable>";
    foreach ($column_names as $column) {
      echo "<td tabindex=\"0\" tabincontenteditable=\"true\" class=\"td-value\">" . $row[$column["name"]] . "</td>";
    }
    echo "</tr>";
  }

  echo "<table>";
}

function query_table_columns($conn, $table) {
  $result = $conn->query("SHOW COLUMNS FROM $table");
  $column_names = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $field = array("name"=>$row["Field"], "primary"=>($row["Key"] == "PRI"));
      array_push($column_names, $field);
    }
  }

  return $column_names;
}

function query_table_rows($conn, $table) {
  $result1 = $conn->query("SELECT * FROM $table");
  $rows = array();
  if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
      array_push($rows, $row);
    }
  }

  return $rows;
}

function query_table_list($conn) {
  $tables = array();
  $result = $conn->query("SHOW TABLES");
  if ($result->num_rows > 0) {
    while ($table = $result->fetch_assoc()) {
      array_push($tables, $table["Tables_in_wt_lab5"]);
    }
  }

  return $tables;
}

function get_primary_keys(&$column_names, &$rows) {
  $primary_key_col_names = array_map(
    function ($col) { return $col["name"]; },
    array_filter($column_names, function ($col) { return $col["primary"]; })
  );

  $result = array();
  foreach ($rows as $row) {
    foreach ($row as $field_name => $value) {
      if (in_array($field_name, $primary_key_col_names)) {
        array_push($result, $value);
      }
    }
  }

  return $result;
}


?>
