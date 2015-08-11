<?php
if (is_ajax()){
	//ASSUMPTION: the database should be setup already
	//TODO: connect to sql database
	$db = new SQLite3('my_database.db') or die('Unable to open database');

	//TODO: randomly select one image that has no submission yet
	$query = "SELECT * FROM images WHERE id IN (SELECT id FROM images EXCEPT SELECT image_id FROM boxes) ORDER BY request_count ASC";

	$result = $db->query($query) or die('Query fail');

	//pass info of the image as json back to client
	$return = $result->fetchArray(SQLITE3_ASSOC);
	if(!$db->exec("UPDATE images SET request_count=".($return['request_count']+1)." WHERE id = ".$return['id'])) echo('fail to update request count'); 

	echo json_encode($return);
}

//Function to check if the request is an AJAX request
function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
?>