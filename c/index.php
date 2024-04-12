<?php
session_start();
chdir("/var/www/mumu.com/c/");
if (isset($_SESSION['username'])){
        } else {
        exit("You are not logged in!");
        }
function rcopy($src, $dst) {
  if (file_exists($dst)) rrmdir($dst);
  if (is_dir($src)) {
    mkdir($dst);
    $files = scandir($src);
    foreach ($files as $file)
    if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
  }
  else if (file_exists($src)) copy($src, $dst);
}
$cdir = getcwd();
//chdir('..');
//chdir('user');
//chdir($_SESSION['username']);
//$neowcoins = fopen("neowcoins.txt", "r");
//$neowcoins = fread($neowcoins,filesize("neowcoins.txt"));
//chdir('..');
//chdir('..');
//chdir('c');
//error_reporting(0);

// Active Chats
$featured = array('chat', 'general', 'dating', 'funny', 'anime', 'programming');
foreach ($featured as $citem){
        chdir($cdir);
        chdir($citem);
        $items = scandir(getcwd());
        $$citem = count($items) - 6;
        if ($$citem < 0){
                $$citem = 0;
        }
        chdir('..');
}
chdir($cdir);
?>
<html>
<head>
	<title>mumu chat</title>
	<link rel="stylesheet" href="/c/dark.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class='header'>
	<h1 style="color:black;">
		
	</h1>

</div>
<div class="main">
<div id="result" style="border:solid 2px purple;">
<span style="color:yellow;">Welcome to  the mumu bbs!</span><br><span style="color:lightblue;"> Have you tried rope yourself?</span>.</span><br>
<br><span style="color:limegreen;">Featured Rooms:<br><br>
chat <span style="color:yellow;">(<?php echo($chat); ?> currently active)</span><br>
general <span style="color:yellow;">(<?php echo($general); ?> currently active)</span><br>
waifu <span style="color:yellow;">(<?php echo($waifu); ?> currently active)</span><br>
gif <span style="color:yellow;">(<?php echo($gif); ?> currently active)</span><br>
otaku <span style="color:yellow;">(<?php echo($otaku); ?> currently active)</span><br>
prog <span style="color:yellow;">(<?php echo($prog); ?> currently active)</span>
</span>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $room = preg_replace('/[^\p{L}\p{N}\s]/u', '', $_POST['room']);
        $room = preg_replace('/\s+/', '', $room);
        $room = strtolower($room);
        echo('<p>');
                if(file_exists($room)){
                        if($room == "DEFAULT"){
                                exit('You think you are slick?');
                        }
                        $room = $room;
                        ?>
                        <large><a href="/c/<?php echo($room);?>">Join /<?php echo($room);?></a></large>
                        <?php
                } else if(strlen($room) <= 20) {
                rcopy("DEFAULT", $room);
                echo($room);
                echo(" was created");
                } else if(strlen($room) > 20){
                echo('Error: Chatroom name must be 20 characters or lower.');
                }
        echo('</p>');
         
} else {

}
?>
</div>
<div class='chatcontrols'>
<form action="" method="POST">
        <input name="room" placeholder="ENTER ROOM HERE" id="chatbox"></input>
        <button id='send' class='btn btn-send' type="submit" value="Submit" label="Start">Send</button>
</form>
</div>
</div>
</html>
