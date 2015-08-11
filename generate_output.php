<?php
    $db = new SQLite3('my_database.db') or die('Unable to open database');
    $query = "SELECT name,gender FROM images";
    $result = $db -> exec($query) or die('Query fail');
    $return = $result -> fetchArray(SQLITE3_ASSOC);
    echo json_encode($return)

?>
