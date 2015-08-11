<?php
if (is_ajax()){
	//ASSUMPTION: the database should be setup already
	//TODO: connect to sql database
	$db = new SQLite3('my_database.db') or die('Unable to open database');

	//TODO: randomly select one image that has no submission yet
	$query = "SELECT * FROM images WHERE gender = ''";

	$result = $db->query($query) or die('Query fail');

	//pass info of the image as json back to client
	$return = $result->fetchArray(SQLITE3_ASSOC);

	echo json_encode($return);
}

//Function to check if the request is an AJAX request
function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
?>
