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

function print_delete_form() {
  echo '<form method="POST" action="">';
  echo "<p>Имя поля:<br><input type=\"text\" name=\"field_name\"/></p>";
  echo "<p>Значение поля:<br><input type=\"text\" name=\"field_value\"/></p>";
  echo '<input type="submit" name="btn_edit" value="Изменить">';
  echo '</form>';
}

print_delete_form();

if (isset($_POST['btn_edit'])) {
  $field = $_POST['field_name'];
  $value = $_POST['field_value'];
  $sql =
    "DELETE FROM " . $tbl_name .
    " WHERE " . $field . " = ";
  if ($field == "id") {
    $sql .= $value;
  } else {
    $sql .= "'$value'";
  }

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
