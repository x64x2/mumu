<?php
session_start();
chdir($cwd);
error_reporting(0);
function convertToLink($input) {
   $pattern = '@(http(s)?://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
   return $output = preg_replace($pattern, '<a href="http$2://$3">$0</a>', $input);
}

if(isset($_SESSION['username'])){
        if($_SESSION['username'] == 'MadMax'){ 
                $user="<span style=color:yellow;>".$_SESSION['username']."</span>";
	$chat = fopen("chatdata.txt", "a");
	$data = "<b>".$user.'</b> '.$sub."<br>";
	fwrite($chat,$data);
	fclose($chat);

	$chat = fopen("chatdata.txt", "r");
	echo fread($chat,filesize("chatdata.txt"));
	fclose($chat);
        
        } else {
        echo('<script> itsanerror();</script>');
        }
        return;
}