<?php
if (is_ajax()) 
{
	$db = new SQLite3('my_database.db') or die('Unable to open database');
	//get post data
    //print_r($_POST['boxes']);
    $id = SQLite3::escapeString($_POST['id']);
    $gender = SQLite3::escapeString($_POST['gender']);
    $query = "UPDATE images SET gender='" . $gender . "' WHERE id=" . $id;
    if (!($db -> exec($query)))
    {
        echo "fail inserting record/n";
    }
}

//Function to check if the request is an AJAX request
function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
?>
