<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Portal</title>
	<!-- Include all the required style sheets -->
	<link href="../css/admin.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Nosifer' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Tauri' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Shojumaru' rel='stylesheet' type='text/css'>

<script type="text/javascript">

</script>


</head>
<body >
	<div id="header">
		<div id="navbar">
			<div id="project_title">Project Portal</div>
			<div id="menu_table_container">
					<table border="0">
						<tr>
							<td id="menu_col1"><a href="" id="aboutus">About Us</a></td>
							<td id="menu_col1"><a href="../logout.php" id="signout">Sign Out</a></td>
					</table>
			</div>
		</div>
	</div>

	<div id="container">
		<div id="links_table_container">
			<table id="links_table" border="1" cellspacing="0.6" cellpadding="5">
				<tr>
					<td id="notifications_col"><a href="admin_notifications.php" id="notifications">Notifications</a></td>
				<tr>
				
				<tr>
					<td id="projects_col"><a href="admin_projects.php" id="projects">Projects</a></td>
				<tr>
				<tr>
					<td id="search_col"><a href="admin_search.php" id="search">Search</a></td>
				<tr>
				<tr>
					<td id="manage_users_col"><a href="admin_manage_users.php" id="manage_users">Manage Users</a></td>
				<tr>
				<tr>
					<td id="source_request_col"><a href="admin_source_request.php" id="source_requests">Source Code Requests</a></td>
				<tr>
			</table>
		</div>
		<div id="space_container">
			<?php

// Session is started and it is checked whether the user is admin or not
session_start();

if ($_SESSION['is_logged_in'] == 0 || !strcmp ( $_SESSION['type'], 'user' ) )
{
    header("Location:../index.php");
    die();
}

// Establish connection to the database projects with 'root' as username and ''(nothing) as password
$con=mysqli_connect("localhost","root","","projects");

// Defensive technique : To check whether the connection to the database is actually established, before we
// access the contents of the database
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Basic sql query to get all the projects from the database which are to be reviewed
$result = mysqli_query($con,"SELECT * FROM project WHERE review='0'");
if (mysqli_error($con))
{
   die(mysqli_error($con));
}

$i = 1;
$j = 1;

// Fetch them one by one and provide option to accept/reject the project
while($row = mysqli_fetch_array($result))
{
  $name = $row['Name'];
  $id = $row['id'];
  $path = "project_description.php?id=".$row['id']."";
  
  echo "<a href=$path id=\"approval_name\">$name</a>";
  echo "<br />";
  $file=fopen("../info".$id.".txt","r") or exit("Unable to open file!");
  echo "<div id=\"approval_text\">";
  while(!feof($file))
  {
    echo fgets($file). "<br>";
  }
  echo "</div>";
  echo "<a href='accept.php?id=$id'><input type='submit' name='ga.$i.' id='ga.$i.' value='Accept'
  			style=\"width: 10%;
  			position: relative;
  			left: 40px; border-radius: 5px; background: black; color: white; height: 40px; font-weigh: bold;\"></a>";
  echo "<a href='reject.php?id=$id'><input type='submit' name='da.$j.' id='da.$j.' value='Reject'
			style=\"width: 10%;
  			position: relative;
  			left: 40px; border-radius: 5px; background: black; color: white; height: 40px; font-weigh: bold;\"></a>";
  echo "<br /><br />";
  $i = $i +1;
  $j = $j +1;
}

if( $i == 1)
{
	echo "<span id=\"no_review_text\">";
	echo 'No Projects to be reviewed';
	echo "</span>";
}

// Close the databse connection
mysqli_close($con);
?>
		</div>
	</div>
</body>
</html>
