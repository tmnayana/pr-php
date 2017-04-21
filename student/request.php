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
$id = $_GET['id'];
$path = "req.php?id=" .$id. "";

echo "<form action=$path method='post'>
		<div id=\"request_text\">
			Why do you want the source code?
		</div>
			<br>
			<textarea rows='5' cols='30' id='ta' name='ta'></textarea>
			<input type='submit' name='submit' id='submit' value='Send'>
		</div>
	</form>
	<a href=\"project_description.php?id=$id\" id=\"back_from_request\">
	<div  id=\"back_from_request\">
		Back
	</div>
</body>";

?>

</html>