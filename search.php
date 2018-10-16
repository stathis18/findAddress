<?php 
	/*eswteriki kwdikopoihsh gia ellinika*/
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	mb_substitute_character('none');
	
	/*stoixeia sundesis*/
	session_start();
	$host = "localhost";
	$username = "root";
	$password = "";
	$db_name = "findaddress";
			
$con = mysql_connect("$host", "$username", "$password") or die("Αδυναμία σύνδεσης!");
mysql_select_db("$db_name") or die ("Αδυναμία σύνδεσης με βάση!");

	//gia ellinikous xaraktires
	mysql_set_charset("UTF8", $con);
/*
//paradeigma
$search = $_POST["name"];
$players  = mysql_query("SELECT firstname FROM players WHERE firstname LIKE '%$search%'");
while($player = mysql_fetch_assoc($players)) {
	//$data = mysql_fetch_assoc($players);
  echo "<div>" . $player ["firstname"] . "</div>";
}
*/
$search = $_POST["name"];
if(isset ($_SESSION['nomos'])) {
$nomos = $_SESSION['nomos'];
}
else {
	$nomos = "";
}
$perioxes  = mysql_query("SELECT DISTINCT perioxi FROM greek_localities WHERE perioxi LIKE '$search%' and nomos='$nomos' ");
while($perioxi = mysql_fetch_assoc($perioxes)) {
  	//echo $perioxi ["perioxi"].PHP_EOL;
	//echo "<li style='display: list-item;'>" . $perioxi ["perioxi"] . "</li>";
	echo "<option>" . $perioxi ["perioxi"] . "</option>";
}
?>