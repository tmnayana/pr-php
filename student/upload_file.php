<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Portal</title>
	<!-- Include all the required style sheets -->
	<link href="../css/upload.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Nosifer' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Tauri' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Shojumaru' rel='stylesheet' type='text/css'>
</head>

<body>
<?php
	// Session is started and it is checked whether the user has logged in or not
	session_start();
	if ($_SESSION['is_logged_in'] == 0 )
	{
	    header("Location:index.php");
	    die();
	}

	// Get all the data from the form in the previous page
	$name=$_POST['title'];
	$author=$_POST['authors'];
	$guide=$_POST['guide'];
	$year=$_POST['year'];
	$pl=$_POST['languages'];
	$domain=$_POST['domain'];
	$status = isset($_POST['check']) && $_POST['check']  ? "1" : "0";
 	
// Establish connection to the database projects with 'root' as username and ''(nothing) as password 	
$con=mysqli_connect("localhost","root","","projects");

// Defensive technique : To check whether the connection to the database is actually established, before we
// access the contents of the database
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Basic sql query to to insert data into project table of the database
$sql="INSERT INTO project (name, author, guide, year, pl, domain, status) VALUES
        ('$name', '$author', '$guide', '$year', '$pl', '$domain', '$status')";


if (!mysqli_query($con,$sql))
{
        die('Error: ' . mysqli_error($con));
}
else
{
        // echo "<br> Your Project has been submitted for review";
}

// Basic sql query to get the project from the database based on name
$res = mysqli_query($con,"SELECT * FROM project WHERE name='$name'");
$row = mysqli_fetch_array($res);



// COde to move the file from temporary folder to required folder and renaming it.
if ($_FILES["info"]["error"] > 0)
    {
		echo "Return Code: " . $_FILES["info"]["error"] . "<br>";
    }
	else
    {
		// echo "<br><br><strong>Info file successfully uploaded</strong> <br>";
		// echo "Upload: " . $_FILES["info"]["name"] . "<br>";
		// echo "Type: " . $_FILES["info"]["type"] . "<br>";
		// echo "Size: " . ($_FILES["info"]["size"] / 1024) . " kB<br>";
		// echo "Temp file: " . $_FILES["info"]["tmp_name"] . "<br>";

		if (file_exists("../". "info".$row["id"].".txt"))
		{
			echo "<div id=\"already\">";
		  	echo $_FILES["info"]["name"] . " already exists. ";
		  	echo "<div>";
		}
		else
		{
		  move_uploaded_file($_FILES["info"]["tmp_name"],
		  "../"."info".$row["id"].".txt");
		  // echo "Stored in: " . "project/"."info".$row["id"].".txt";
			echo "<div id=\"already\">Project Successfully Uploaded !</div>";
		}
		
    }



    if($status == "1")
    {
	    if ($_FILES["file"]["error"] > 0)
	    {
			// echo "Return Code: " . $_FILES[""]["error"] . "<br>";
	    }
		else
	    {
			// echo "Successfully uploaded <br>";
			// echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			// echo "Type: " . $_FILES["file"]["type"] . "<br>";
			// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

			if (file_exists("../". $_FILES["file"]["name"]))
			{
				echo "<div id=\"already\">";
				echo $_FILES["file"]["name"] . " already exists. ";
				echo "<div>";
			}
			else
			{
			  move_uploaded_file($_FILES["file"]["tmp_name"],
			  "../student/". $row["id"].".zip");
			  // echo "Stored in: " . "project/student/". $row["id"].".zip";
			}
	    }
	}
	echo "<a href=\"student_upload.php\" id=\"back_home\">Go Back</a>"
  
?>

</body>

</html>