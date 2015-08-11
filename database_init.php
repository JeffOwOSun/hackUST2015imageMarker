<?php
	$db = new SQLite3('my_database.db') or die('unable to connect to database');
	//drop previous tables
	$db->exec("DROP TABLE IF EXISTS images");
	$db->exec("DROP TABLE IF EXISTS boxes");
	//create tables
	$db->exec("CREATE TABLE images(id INTEGER PRIMARY KEY, path varchar(255), request_count INTEGER)") or die("create images failed");
	$db->exec("CREATE TABLE boxes(id INTEGER PRIMARY KEY, positive_classification INTEGER, image_id INTEGER, first_point_X REAL, first_point_Y REAL, second_point_X REAL, second_point_Y REAL)");
	//feed in the images table
	$files = scan('images');
	$count = 0;

	foreach($files as $file)
	{
		//insert the file with path
		if ($file["type"] == "file")
		{
			$db->exec("INSERT INTO images (path, request_count) VALUES ('" . $file["path"] . "', 0)") or die("fail to insert into images");
			$count += 1;
		}
	}

	echo "successfully inserted ".$count." records\n";

	//scan the directory
	function scan($dir){

		$files = array();

		// Is there actually such a folder/file?

		if(file_exists($dir)){
		
			foreach(scandir($dir) as $f) {
			
				if(!$f || $f[0] == '.') {
					continue; // Ignore hidden files
				}

				if(is_dir($dir . '/' . $f)) {

					// The path is a folder

					$files[] = array(
						"name" => $f,
						"type" => "folder",
						"path" => $dir . '/' . $f,
						"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
					);
				}
				
				else {

					// It is a file

					$files[] = array(
						"name" => $f,
						"type" => "file",
						"path" => $dir . '/' . $f,
						"size" => filesize($dir . '/' . $f) // Gets the size of this file
					);
				}
			}
		
		}

		return $files;
	}
?>