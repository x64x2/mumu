<?php
function command($command, $syntax) {
        if($command==":mumucoin"){
                chdir('..');
                chdir('user');
                chdir($syntax);
                $mumu = fopen("mumu.txt", "r");
                echo fread($mumu,filesize("mumu.txt"));
                fclose($mumu);
                
        }
}
command(':mumu', 'poo');
?>