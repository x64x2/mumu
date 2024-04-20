<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $username = $_SESSION['username'];
} else {
    exit('You must sign in to edit your profile page.');
}
chdir($_SESSION['username']);
$mumucoins = fopen("mumucoins.txt", "r");
$mumucoins = fread($mumucoins,filesize("mumucoins.txt"));
?>
<html>
<head>
<title>edit your profile page</title>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<link rel="stylesheet" href="/mumutheme.css">
<style>

#body{
width:80%;
height:500px;
color:purple;
font-weight: normal;
background-color:#f4f4f4;
padding:10px;
overflow-y:visable;
}
</style>
</head>
<body>

<br><br></div>
<div id="everythingelse">
<?php 
if($_SESSION['username']=="Pepe" or $_SESSION['username']=="Woyjak" or $_SESSION['username']=="railpro101"){
echo("<a id=menu href");
echo("=");
echo("soyconsole.php");
echo(">soy Console</a>");
} ?>

<form action="post.php" method="post">
<?php
chdir($username);
if (file_exists("bio.txt")) {
        $myfile = fopen("bio.txt", "r") or die("Unable to open file!");
        $content = preg_replace('/<br>/i',"",fread($myfile,filesize("bio.txt")));
        fclose($myfile);
}
?>
<textarea style="text-align:left;" id="body" name="input" placeholder="Here's who I am.">
<?php echo($content); ?>
</textarea>
<br><br>
<input id="btn" type="submit" value="Save">
</form>
</div>
</body>
</html>
    

