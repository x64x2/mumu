<?php
session_start();
?>
<html>
<style>
html{
  background: #000;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
</style>
<?php
chdir('..');
chdir('..');
chdir('user');
chdir($_SESSION['username']);
$mumucoins = fopen("mumucoins.txt", "r");
$mumucoins = fread($mumucoins,filesize("mumucoins.txt"));
$mumucoins = $mumucoins + 10;
$oldmumucoins = fopen("mumucoins.txt", "w");
fwrite($oldmumucoins, $mumucoins);
?>
