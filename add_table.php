<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

<?php
include 'utils.php';

$db_connection = new mysqli($servername, $username, $password, $dbname);

if ($db_connection->connect_error) {
  die("Connection failed: " . $db_connection->connect_error);
}

function print_add_form($column_names) {
  echo '<form method="POST" action="">';

  foreach ($column_names as $column) {
    if (!$column["primary"]) {
      echo (
        "<p>" .
        $column["name"] .
        "<br>" .
        '<input type="text" name="' . $column["name"] . '"/>' .
        "</p>"
      );
    }
  }

  echo '<input type="submit" name="btn_add" value="Add">';

  echo '</form>';
}

$tbl_name = $_GET['tbl_name'];

$column_names = query_table_columns($db_connection, $tbl_name);

print_add_form($column_names);

if (isset($_POST['btn_add'])) {
  $col_name_list = array_map(
    function ($col) { return $col["name"]; },
    array_filter($column_names, function ($col) { return !$col["primary"]; })
  );

  $col_val_list = array_map(
    function ($col_name) { return "'" . $_POST[$col_name] . "'"; },
    $col_name_list
  );

  $sql =
    "INSERT INTO " .
    $tbl_name .
    " (" . implode(",", $col_name_list) .
    ") VALUES (" .
    implode(",", $col_val_list) . ")";

  $result = $db_connection->query($sql);

  if ($result == true)
    echo "Добавлено";
  else
    echo $db_connection->error;
}

$db_connection->close();

?>

  </body>
</html>
