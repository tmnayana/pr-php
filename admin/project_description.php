<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Portal</title>
	<!-- Include all the required style sheets -->	
	<link href="../css/project_description.css" rel="stylesheet" type="text/css">
  	<link href="../css/project_details.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Nosifer' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Tauri' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>

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

if ($_SESSION['is_logged_in'] == 0 || !strcmp ( $_SESSION['type'], 'user' )  )
{
    header("Location:index.php");
    die();
}

$id = $_GET['id'];

// Establish connection to the database projects with 'root' as username and ''(nothing) as password
$con=mysqli_connect("localhost","root","","projects");

// Defensive technique : To check whether the connection to the database is actually established, before we
// access the contents of the database
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Basic sql query to get a project from the database based on id
$result = mysqli_query($con,"SELECT * FROM project WHERE id=$id");
$row = mysqli_fetch_array($result);


// display all the details of that project
echo "<table border=\"1\" id=\"proj_details_id\">";
echo "<tr><td id=\"test_col1\">";
echo "<span id=\"proj_name\">Project Name : </span>";
echo "</td><td id=\"test_col2\">";
echo "<span id=\"proj_name_value\">".$row['Name']."</span>";
echo "</td></tr>";

echo "<tr><td id=\"test_col1\">";
echo "<span id=\"proj_author\">Author : </span>";
echo "</td><td id=\"test_col2\">";
echo "<span id=\"proj_author_value\">".$row['author']."</span>";
echo "</td></tr>";


echo "<tr><td id=\"test_col1\">";
echo "<span id=\"proj_guide\">Guided By : </span>";
echo "</td><td id=\"test_col2\">";
echo "<span id=\"proj_guide_value\">"."Prof. ".$row['guide']."</span>";
echo "</td></tr>";

echo "<tr><td id=\"test_col_abstract1\">";
echo "<span id=\"proj_abstract\">Abstract : </span>";
echo "</td><td id=\"test_col_abstract2\">";
echo "<span id=\"proj_abstract_value\">";
$file=fopen("../info".$id.".txt","r") or exit("Unable to open file!");
while(!feof($file))
{
  echo fgets($file). "<br>";
}
echo "<span id=\"proj_name_value\">";
fclose($file);
echo "</td></tr>";

echo "<tr><td id=\"test_col1\">";
echo "<span id=\"proj_year\">Year : </span>";
echo "</td><td id=\"test_col2\">";
echo "<span id=\"proj_year_value\">".$row['year']."</span>";
echo "</td></tr>";

echo "<tr><td id=\"test_col1\">";
echo "<span id=\"proj_lang\">Programming Language : </span>";
echo "</td><td id=\"test_col2\">";
echo "<span id=\"proj_lang_value\">".$row['PL']."</span>";
echo "</td></tr>";

echo "<tr><td id=\"test_col1\">";
echo "<span id=\"proj_domain\">Domain : </span>";
echo "</td><td id=\"test_col2\">";
echo "<span id=\"proj_domain_value\">".$row['domain']."</span>";
echo "</td></tr>";

echo "<tr><td id=\"test_col1\">";
echo "<span id=\"proj_status\">Project Status : </span>";
echo "</td><td id=\"test_col2\">";
echo "<span id=\"proj_status_value\">";
if ($row['status'] == 0)
  echo "Not Completed";
else
  echo "Completed";
echo "</span>";
echo "</td></tr>";

echo "</table>";
echo "<br>";echo "<br>";

// A facility to request for source code
$path = "request.php?id=".$id."";

echo "<div id=\"request_and_back\">";
echo "<a href=\"admin_projects.php\" id=\"back\"><< Go Back</a>";
echo "</div>";

// CLose db con.
mysqli_close($con);
?>
		</div>
	</div>
</body>
</html>
