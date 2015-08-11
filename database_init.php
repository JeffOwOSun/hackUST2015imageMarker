<?php
	$db = new SQLite3('my_database.db') or die('unable to connect to database');
	//drop previous tables
	$db->exec("DROP TABLE IF EXISTS images");
	//create tables
	$db->exec("CREATE TABLE images(id INTEGER PRIMARY KEY, name text, path text)") or die("create images failed");
    //feed in the images table
    $root_dir = ('undetermined')
	$files = scan($root_dir);
	$count = 0;
    $last_name = '';
	foreach($files as $file)
	{
		//insert the file with path
		if ($file["type"] == "file")
        {
            $name =substr(basename($path["path"]), 0, -9);
            if ($name != $last_name)
            {
                $last_name = $name;
			    $db->exec("INSERT INTO images (name, path) VALUES ('" . $name . "', '" . $file["path"] . "')") or die("fail to insert into images");
			    $count += 1;
            }
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
