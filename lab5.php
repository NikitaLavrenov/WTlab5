<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <style media="screen">
      table.db-table 		{ border-right:1px solid #ccc; border-bottom:1px solid #ccc; }
      table.db-table th	{ background:#eee; padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
      table.db-table td	{ padding:5px; border-left:1px solid #ccc; border-top:1px solid #ccc; }
    </style>
  </head>
  <body>

<?php

include 'utils.php';
$db_connection = new mysqli($servername, $username, $password, $dbname);
if ($db_connection->connect_error) {
  die("Connection failed: " . $db_connection->connect_error);
}

$tables = query_table_list($db_connection);

echo '<form method="post">';

echo '<label for="table_name">Название таблицы: </label>';
echo '<select name="table_name">';
foreach ($tables as $table_name) {
  echo "<option value=\"$table_name\">$table_name</option>";
}
echo '</select>';

echo '<div>';
echo '<input type="submit" name="btn_show" value="Показать">';
echo '</div>';

echo '</form>';

if (isset($_POST['btn_show'])) {
    $tbl_name = $_POST['table_name'];

    $column_names = query_table_columns($db_connection, $tbl_name);
    $rows = query_table_rows($db_connection, $tbl_name);

    print_table($column_names, $rows);

    echo "<ul>";
    echo "<li><a href=\"./lab5_add_table.php?tbl_name=$tbl_name\">Добавить</a></li>";
    echo "<li><a href=\"./lab5_delete_table.php?tbl_name=$tbl_name\">Удалить</a></li>";
    echo "<li><a href=\"./lab5_edit_table.php?tbl_name=$tbl_name\">Редактировать</a></li>";
    echo "</ul>";
}

$db_connection->close();
?>

  </body>
</html>
