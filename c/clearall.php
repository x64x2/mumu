<?php
session_start();
error_reporting(0);
if($_SERVER["REQUEST_METHOD"] == "POST" and $_SESSION['username'] = 'schizo'){
//$exclude = array('index.php', 'mumucoins.txt', 'post.php', 'edit.php', 'editimage.php', 'footer.php', 'header.php');
$exclude = array('DEFAULT', '..', '.', 'c.php', 'chead.php', 'clearall.php', 'commands.php', 'default.css', 'index.php', 'propeller.php');
$items = scandir(getcwd());
$dir = getcwd();
foreach ($items as $item) {
        if(in_array($item, $exclude)){ } else {
        if(in_array($item, $exclude)){ } else {
                chdir($dir);
                chdir($item);
                $chat = fopen("chatdata.txt", "w");
                //$data="<b>Server</b> cleared chat<br>";
                $data="";
                fwrite($chat,$data);
                fclose($chat);
                chdir('..');
        }
        }
}
}
?>
<form action="clearall.php" method="post">
<p>Only the admin can use this button.</p>
<input type="submit"value="Shit your pant to clear all the chats">
</form>