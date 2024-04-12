<?php
session_start();
$username = $_SESSION['username'];
$dir = getcwd();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    exit("Did you know you have to <em>log in</em> to view the feed?");
}
include '../config.php';
chdir('..');    
chdir('user');
chdir($_SESSION['username']);
$mumucoins = fopen("mumucoins.txt", "r");
$mumucoins = fread($mumucoins,filesize("mumucoins.txt"));
chdir($dir);
function convertToLink($input) {
   $pattern = '@(http(s)?://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
   return $output = preg_replace($pattern, '<a href="http$2://$3">$0</a>', $input);
}
if($_SERVER["REQUEST_METHOD"] == "POST" and !empty($_POST['title'])){
        // Prepare an insert statement
        $sql = "INSERT INTO mumu.board (username, title, body) VALUES (?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $username, $_POST['title'], $_POST['body']);
            
            //$date = date('mm/dd/yyyy g:i a');
            $_POST['title'] = htmlentities($_POST['title']);
            $_POST['body'] = htmlentities($_POST['body']);
            $_POST['body'] = nl2br($_POST['body'], false);
            $_POST['body'] = convertToLink($_POST['body']);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header('location: index.php');
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
}

?>
<html>
<head>
<title>message feed</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
<style>
#forms {
background-color:rgb(0,0,0,0); border:solid; color:purple;
}
</style>
</head>
<body>

<br><br></div>
<div id="everythingelse">
          <a style"font-size:30;" id="menu"<?php echo($_SESSION['username']);?>"><?php echo $_SESSION['username'];?></a>
<br><br>
<form action="index.php" method="post" autocomplete="off">
        <h2>New Post</h2>
        <label>Title</label><br><input maxlength="64" name="title"><br>
        <label>Body</label><br><textarea maxlength="6400" style="width:450; height:100;" name="body" placeholder="What's on your mind?"></textarea><br>
        <br><input id="btn" type="submit" class="btn btn-primary" value="Post"><br>
</form>
<h1>recent</h1><div style="text-align:left;">
<?php
$cwd = getcwd();
$sql = "SELECT * FROM mumu.board ORDER BY date desc";
$result = mysqli_query($mysqli,$sql);
while($row = mysqli_fetch_array($result) and $row >= 30) {
        echo('<br><br><br><div style=background-color:#ededed;padding:10px;max-height:300px;overflow:auto;>');
        $pusername = $row['username'];
        $pdate = $row['date'];
        $ptitle = trim($row['title']);
        $pbody = trim($row['body']);
        chdir('..');
        chdir('user');
        chdir($pusername);
        $imageloca = fopen('imagename.txt', 'r');
        $imageloca = fread($imageloca,filesize("imagename.txt"));
        ?> <img style="height:90px; width:90px; border:solid 1px black; float:left; margin-right:20px; margin-bottom:inherit;" src="<?php echo('http:/'); echo('/mumu.matthewevan.xyz/user/'); echo($pusername); echo('/'); echo $imageloca; ?>"><?php
        echo('<div style=padding:10px;font-size:30px;>');
        echo($ptitle);
        echo('</div><em style=font-size:15px;>');
        echo($pusername);
        echo(' (');
        echo($pdate);
        echo(')</em><br><br>');
        echo($pbody);
        echo('</div>');
        chdir($cwd);
}
?>
