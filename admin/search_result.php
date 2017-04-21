<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- the javascript function in previous page calls this page -->

<head>

  <title>Portal</title>
  <!-- Include all the required style sheets -->
  <link href="../css/admin_search.css" rel="stylesheet" type="text/css">
  <link href="../css/student.css" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Nosifer' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Fredoka+One' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Tauri' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>
</head>

<?php

// Session is started and it is checked whether the user is admin or not
session_start();

if ($_SESSION['is_logged_in'] == 0 || !strcmp ( $_SESSION['type'], 'user' )  )
{
    header("Location:index.php");
    die();
}

if ( isset($_GET['queryString']))
{
  $string = '';


  $text = $_GET['queryString'];

  if(isset($_GET['options']))
  {
    if ($_GET['options'] == "Name")
    {
      $select = "Name";
    }
    else if ($_GET['options'] == "Domain")
    {
      $select = "domain";
    }
    else if ($_GET['options']=="Year")
    {
      $select = "year";
    }
    else
    {
      $select = "PL";
    }

    // Establish connection to the database projects with 'root' as username and ''(nothing) as password
    $con=mysqli_connect("localhost","root","","projects");

    // Defensive technique : To check whether the connection to the database is actually established, before we
// access the contents of the database
    if (mysqli_connect_errno($con))
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    // Basic sql query for searching for the project based on name, domain etc.
    if($select != "year")
    {
      $result = mysqli_query($con,"SELECT * FROM project WHERE $select LIKE '%" .$text . "%'");  
    }
    else {
      $result = mysqli_query($con,"SELECT * FROM project WHERE year='$text'");
    }
    if (mysqli_error($con))
    {
       die(mysqli_error($con));
    }

    if(mysqli_num_rows($result) == 0)
    {
      $string .= "<span id=\"search_res_for\">No Significant Results found for : </span>" ."<span id=\"res\">".$text."</span>";
      $string .=  "<br><br>";
    }
    else
    {
      
      $string .= "<span id=\"search_res_for\">Search Results for : </span>"."<span id=\"res\">".$text."</span>";
      $string .= "<br><br>";

      while($row = mysqli_fetch_array($result))
      {
        $name = $row['Name'];
        $path = "project_description.php?id=".$row['id']."";
        $string .= "<ul>";
        $string .= "<li><a href=\"$path\" target=\"_blank\" id=\"res_link\"> $name </a></li>";
        $string .= "</ul>";
      }
    }

    // close db con.
    mysqli_close($con);
    echo $string;
    exit;
  }
}
?>
  
