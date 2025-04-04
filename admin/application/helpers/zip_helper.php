<?php
/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false,$config = array()) {

	// Modificacion para no crear el mismo path dentro del ZIP
	$replace_dir = isset($config["replace_dir"]) ? $config["replace_dir"] : "C:/";

	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip_file = str_replace($replace_dir, "", $file);
			$zip->addFile($file,$zip_file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	} else {
		return false;
	}
}

function extract_to($file,$dest_path) {
	$zip = new ZipArchive();
	$res = $zip->open($file);
	if ($res === TRUE) {
	  $zip->extractTo($dest_path);
	  $zip->close();
	  return TRUE;
	} else {
	  return FALSE;
	}
}
?>