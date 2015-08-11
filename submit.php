<?php
if (is_ajax()) 
{
	$db = new SQLite3('my_database.db') or die('Unable to open database');
	//get post data
	//print_r($_POST['boxes']);
	$boxes = $_POST['boxes'];
	//should be an array of boxes
	foreach ($boxes as $box)
	{
		$first_point_X = SQLite3::escapeString($box["top_left_point"]["x"]);
		$first_point_Y = SQLite3::escapeString($box["top_left_point"]["y"]);
		$second_point_X = SQLite3::escapeString($box["bottom_right_point"]["x"]);
		$second_point_Y = SQLite3::escapeString($box["bottom_right_point"]["y"]);
		$positive_classification = ($box["positive_classification"] == 'true') ? 1 : 0;
		$image_id = SQLite3::escapeString($box["image_id"]);

		//insert them into the box table
		$query = ("INSERT INTO boxes (first_point_X, first_point_Y, second_point_X, second_point_Y, positive_classification, image_id) VALUES ( ".$first_point_X.", ".$first_point_Y.", ".$second_point_X.", ".$second_point_Y.", ".$positive_classification.", ".$image_id.")");
		if (!($db -> exec($query)))
		{
			echo "fail inserting record/n";
		}
	}
	
	print_r($boxes);
}
//Function to check if the request is an AJAX request
function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
?>