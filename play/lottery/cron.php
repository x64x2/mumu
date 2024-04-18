<?php
date_default_timezone_set('EST');
//if(date("l h:i A") == "Monday 09:00 AM") {
    $totalstake = fopen("totalstake", "r");
    $totalstake = fread($totalstake, filesize("totalstake"));
    chdir("stake");
    $stakeholders = array_diff(scandir(getcwd()), array('..', '.'));
    foreach($stakeholders as $stakeholder) {
        $shs = fopen($stakeholder, "r");
        $shs = fread($shs, filesize($stakeholder));
        $rankings[] = array("stakeholder" => $stakeholder, "stake" => $shs);
    }
    $strawnum = rand(0, $totalstake);
    foreach($rankings as $rank) {
        for($num = 0; $num < $rank['stake']; $num++){
            if($num == $strawnum){
		$straw = $rank["stakeholder"];
		$strawstake = $rank["stake"];
	    }
        }
    }
    chdir("..");
    //$straw = $strawdraw[rand(0, count($strawdraw))];
    $winner = fopen("winner", "w");
    fwrite($winner, $straw);
    fclose($winner);
    chdir("stake");
    $userstake = fopen($straw, "r");
    $userstake = fread($userstake, filesize($straw));
    chdir("..");
    $winnertickets = fopen("winnertickets", "w");
    fwrite($winnertickets, $userstake);
    fclose($winnertickets);
    $prevstake = fopen("prevstake", "w");
    fwrite($prevstake, $totalstake);
    fclose($prevstake);
    $finaljackpot = fopen("finaljackpot", "w");
    fwrite($finaljackpot, $totalstake * 100);
    fclose($finaljackpot);
    $oldtotalstake = fopen("totalstake", "r");
    $oldtotalstake = fread($oldtotalstake, filesize("totalstake"));
    $totalstake = fopen("totalstake", "w");
    fwrite($totalstake, 0);
    fclose($totalstake);
    chdir("../../user");
    chdir($straw);
    $mumucoins = fopen("mumucoins.txt", "r");
    $mumucoins = fread($mumucoins,filesize("mumucoins.txt"));
    $mumucoins = $mumucoins + ($oldtotalstake * 100);
    $oldmumucoins = fopen("mumucoins.txt", "w");
    fwrite($oldmumucoins, $mumucoins);
    chdir("../../play/lottery/stake");
    $stakeholders = array_diff(scandir(getcwd()), array('..', '.'));
    foreach($stakeholders as $stakeholder) {
        unlink($stakeholder);
    }
    chdir("..");
//}

?>
