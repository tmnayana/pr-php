<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Portal</title>
	<!-- Include all the required style sheets -->
	<link href="../css/admin_manage_users.css" rel="stylesheet" type="text/css">
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

// Establish connection to the database projects with 'root' as username and ''(nothing) as password
$con=mysqli_connect("localhost","root","","projects");

// Defensive technique : To check whether the connection to the database is actually established, before we
// access the contents of the database
if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Basic sql query to get all the users from the database who are not admin
$result = mysqli_query($con,"SELECT * FROM users WHERE usertype='user'");
if (mysqli_error($con))
{
   die(mysqli_error($con));
}

echo "<div id=\"manage_users_title\">Users</div><br/>";

echo "<div id=\"manage_users_table_container\">";
echo "<table border=\"1px\" id=\"manage_users_table\" cellspacing=\"0\">";

echo "<tr id=\"manage_users_table_heading\">";
echo "<th>Name</th>";
echo "<th>USN</th>";
echo "<th>Email-ID</th>";
echo "<th></th>";
echo "</tr>";

// fetch result one by one and also provide option to delete the user
while($row = mysqli_fetch_array($result))
{
	$usn = $row['usn'];
	$email = $row['email'];
	$phone = $row['phone'];
	$name = $row['name'];
	
	echo "<tr>";
		echo "<td id=\"manage_users_name\">";
			echo $name;
		echo "</td>";
		echo "<td id=\"manage_users_usn\">";
			echo $usn;
		echo "</td>";
		echo "<td id=\"manage_users_email\">";
			echo $email;
		echo "</td>";
		// echo "<td id=\"manage_users_phone\">";
		// 	echo $phone;
		// echo "</td>";
		echo "<td>";
			$del = 'delete_user.php?usn='.$usn;
			echo "<a href=$del><input type=\"button\" value=\"Delete\" id=\"manage_users_delete\"></a>";
		echo "</td>";
	echo "</tr>";

}

echo "</table>";
echo "</div>";

// Close the DB connection
mysqli_close($con);
?>
		</div>
	</div>
</body>
</html>
