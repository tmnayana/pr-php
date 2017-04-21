<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Portal</title>
  <!-- Include all the required style sheets -->
  <link href="../css/student.css" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Nosifer' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Tauri' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>

<script type="text/javascript">

</script>
</head>

<body >
<?php
// Session is started and it is checked whether the user has logged in or not
session_start();
if ($_SESSION['is_logged_in'] == 0 )
{
    header("Location:index.html");
    die();
}
echo '
  <div id="header">
    <div id="navbar">
      <div id="project_title">Project Portal</div>
      <div id="menu_table_container">
          <table border="0">
            <tr>
              <td id="menu_col1"><a href="" id="aboutus">About Us</a></td>
              <td id="menu_col1"><a href="../logout.php" id="signout">Sign Out</a></td>
              <td id="menu_col1"><a href="../change_password.html" id="signout">Change Password</a></td>
          </table>
      </div>
    </div>
  </div>

  <div id="container">
    <div id="links_table_container">
      <table id="links_table" border="1" cellspacing="0.6" cellpadding="5">
        <tr>
          <td id="projects_col"><a href="student_projects.php" id="projects">Projects</a></td>
        <tr>
        <tr>
          <td id="search_col"><a href="student_search.php" id="search">Search</a></td>
        <tr>
        <tr>
          <td id="upload_col"><a href="student_upload.php" id="upload">Upload</a></td>
        <tr>
      </table>
    </div>
    <div id="space_container">';

    // Establish connection to the database projects with 'root' as username and ''(nothing) as password
    $con=mysqli_connect("localhost","root","","projects");

// Defensive technique : To check whether the connection to the database is actually established, before we
// access the contents of the database
if (mysqli_connect_errno($con))
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Basic sql query to get all the projects from the database if already reviewed
$result = mysqli_query($con,"SELECT * FROM project WHERE review='1'");
if (mysqli_error($con))
{
   die(mysqli_error($con));
}

$i = 1;

// display results one by one
while(($row = mysqli_fetch_array($result)) && ($i<4) )
{
  $name = $row['Name'];
  $path = "project_description.php?id=".$row['id']."";
  $id = $row['id']; 
  echo "<a href=$path id=\"prj_title\">$name</a>";
  echo "<br />";
  $file=fopen("../info".$id.".txt","r") or exit("Unable to open file!");
  echo "<div id=\"prj_description\" >";
  while(!feof($file))
  {
    echo fgets($file). "<br>";
  }
  echo "</div>";

  $i = $i + 1;
  echo "<br /><hr/>";

}

//close db connection
mysqli_close($con);

    echo '</div>
  </div>';
?>
  </div>
</body>
</html>
