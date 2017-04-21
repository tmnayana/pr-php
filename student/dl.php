<?php
	$id = $_GET['id'];
	$filename = $id.'.zip';
	// set the headers for file download
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="source.zip" ');
    readfile("$filename");
?>