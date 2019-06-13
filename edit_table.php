<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

<?php
include 'utils.php';

$tbl_name = $_GET['tbl_name'];

$db_connection = new mysqli($servername, $username, $password, $dbname);

if ($db_connection->connect_error) {
  die("Connection failed: " . $db_connection->connect_error);
}

$column_names = query_table_columns($db_connection, $tbl_name);
$rows = query_table_rows($db_connection, $tbl_name);
$primary_keys = get_primary_keys($column_names, $rows);

function print_edit_form($column_names, $rows, $primary_keys) {
  echo '<form method="POST" action="">';

  echo '<select name="primary_key">';
  foreach ($primary_keys as $pkey) {
    echo "<option value=\"$pkey\">$pkey</option>";
  }
  echo '</select>';

  echo '<select name="field_name">';
  foreach ($column_names as $column) {
    if (!$column["primary"]) {
      $value = $column["name"];
      echo "<option value=\"$value\">$value</option>";
    }
  }
  echo '</select>';

  echo "<p>Новое значение:<br><input type=\"text\" name=\"field_value\"/></p>";

  echo '<input type="submit" name="btn_edit" value="Изменить">';

  echo '</form>';
}

print_edit_form($column_names, $rows, $primary_keys);

if (isset($_POST['btn_edit'])) {
  $field = $_POST['field_name'];
  $value = $_POST['field_value'];
  $key = $_POST['primary_key'];
  $sql =
    "UPDATE " . $tbl_name .
    " SET " . $field . "='" . $value . "'" .
    " WHERE id = " . $key;

  $result = $db_connection->query($sql);

  if ($result == true)
    echo "TRUE";
  else
    echo $db_connection->error;
}

$db_connection->close();

?>

  </body>
</html>
