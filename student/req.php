<html>

<head>
	<!-- Include all the required style sheets -->
	<link href="../css/request.css" rel="stylesheet" type="text/css">
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

$username = $_SESSION['name'];
$ta = $_POST['ta'];

$id = $_GET['id'];

// Establish connection to the database projects with 'root' as username and ''(nothing) as password
$con=mysqli_connect("localhost","root","","projects");

// Defensive technique : To check whether the connection to the database is actually established, before we
// access the contents of the database
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


// Basic sql query to insert into the database
$sql="INSERT INTO request (name, id, ta)
	  VALUES ('$username', '$id', '$ta')";
if (!mysqli_query($con,$sql))
{
	echo "<div id=\"already_requested\">";
	echo "You have already requested for this project";
	echo "<div>";

	echo "<a href=\"student_projects.php\" id=\"back_home\">";
	echo "Go Home";
	echo "</a>";
}
else
{
	echo "<div id=\"already_requested\">";
	echo "You have requested for project number ".$id;
	echo "</div>";

	echo "<a href=\"student_projects.php\" id=\"back_home1\">";
	echo "<div>";
	echo "Back";
	echo "</div>";
	echo "</a>";
}


?>
</body>



</html>