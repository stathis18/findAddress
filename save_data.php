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
			
	//sundeomaste kai dialegoyme bash, diaforetika emfanizetai katallilo minima
	mysql_connect("$host", "$username", "$password") or die("Αδυναμία σύνδεσης! Ενημερώστε το τμήμα ΙΤ.");
	mysql_select_db("$db_name") or die ("Αδυναμία σύνδεσης με βάση! Ενημερώστε το τμήμα ΙΤ.");
	$mysqli = new mysqli("$host", "$username", "$password", "$db_name");
	
	//gia ellinikous xaraktires
	$mysqli->set_charset("utf8");

	

	//$url= 'http://192.168.0.54/findaddress/';

//an ginei i apothikeusi stoixewm mesw dieuthinsis
if(($_SESSION['save_by'])=='address'){
	
	if ($_POST['action'] == 'save') { 
		if (!empty($_POST['locality']) && !empty($_POST['postal_code']) && !empty($_POST['country']) && isset($_POST['administrative_area_level_3'])) { // check if both fields are set
			if ((strpos($_POST['administrative_area_level_3'], 'Αθηνών') !== false) || (strpos($_POST['administrative_area_level_3'], 'Αττική') !== false)){ //apothikeysh nomou Attikis
				$_POST['administrative_area_level_3'] = "Αττική";
			}
			//kathe pedio apothikeuetai se ksexoristi grammi
			$txt=$_POST['route'].PHP_EOL.$_POST['street_number'].PHP_EOL.$_POST['locality'].PHP_EOL.$_POST['administrative_area_level_3'].PHP_EOL.$_POST['postal_code'].PHP_EOL.$_POST['country'].PHP_EOL.$_POST['latitude'].PHP_EOL.$_POST['langitude'];
			file_put_contents('findAddress.txt', $txt);
			file_put_contents('findAddress.ini', 'byAddress.php');
			echo "Επιτυχής εγγραφή";
			//$page = $_SERVER['localhost/addressauto/index.php'];
			$sec = "2";
			header("Refresh: $sec; url=index.php");
			session_destroy();
		}
		else {
			//$_SESSION['warning'] = "empty_fields";
			//header("Location: byAddress.php");
			//session_destroy();
			echo "Δεν είναι όλα τα πεδία συμπληρωμένα";
			$sec = "1";
			header("Refresh: $sec; url=byAddress.php"); 
		}
	}

	//refresh ti selida me clear ta sessions
	if ($_POST['action'] == 'clear all') { 
		header("Location: byAddress.php"); 
		session_destroy();
	}
	if ($_POST['action'] == 'exit') {
    	//echo "<script>window.close();</script>";
		header("Location: byAddress.php");
	}
	
}
//an ginei i apothikeusi stoixewm mesw nomou
elseif(($_SESSION['save_by'])=='state') {
  if (isset($_POST['action'])){
	if ($_POST['action'] == 'save') { 
		if (!empty($_POST['postal_code'])) {
			//to pedio autocomplete periexei tin Poli kai tin Xwra	
			//$explode_autocomplete = explode(',',$_POST['autocomplete']); //diaxwrizw poli kai xwra
			//$town = substr($explode_autocomplete[0], -50); //pairnw to 1o kommati prin to komma poy einai i poli
			//$explode_route = explode(',',$_POST['route']); //diaxwrizw odos me tin perioxi
			//$explode_route_final = explode(' ',$explode_route[0]); //an yparxei kai arithmos stin odo, pairnw mono tis odo!
			//if(empty ($_POST['street_number'])){
			//$route = trim(substr($explode_route[0], -200)); //pairnw apo to 1o kommati prin to komma ta 5 teleutaia psifia pou einai i dieuthinsi
			//}
			//else {
			//$route = trim(substr($explode_route_final[0], -200));	
			//}
			
			//se periptwsi pou to route pedio den apoteleitai mono apo odo tote:
			$explode_route = explode(',',$_POST['route']); //diaxwrizw odos me tin perioxi
			$routeAndAddress = $explode_route[0];
			$explode_route_final = explode(' ',$routeAndAddress);		
			$size = sizeof ($explode_route_final);
			$last_element = $explode_route_final [$size-1];
			if (is_numeric($last_element)){
				$route="";
				for($i=0;$i<$size-1;$i++){
					$route =  $route.$explode_route_final[$i]." ";
				}
			}
			else{
				$route = $routeAndAddress;
			}
			$txt=$route.PHP_EOL.$_POST['street_number'].PHP_EOL.$_SESSION['perioxi'].PHP_EOL.trim($_SESSION['nomos']).PHP_EOL.$_POST['postal_code'].PHP_EOL.'Ελλάδα'.PHP_EOL.$_POST['latitude'].PHP_EOL.$_POST['langitude'];
			file_put_contents('findAddress.txt', $txt);
			file_put_contents('findAddress.ini', 'byState.php');
			echo "Επιτυχής εγγραφή";
			$sec = "2";
			header("Refresh: $sec; url=index.php"); 
			session_destroy();
		}
		else {
		   echo "Δεν είναι όλα τα πεδία συμπληρωμένα";
			$sec = "1";
			header("Refresh: $sec; url=byState.php"); 
		}
	}
	
	//refresh ti selida me clear ta sessions
	if ($_POST['action'] == 'clear all') { 
		header("Location: byState.php");
		session_destroy();
	}
	
	if ($_POST['action'] == 'find') {
			$sec = "1";
			header("Refresh: $sec; url=byState.php"); 
	}
	if ($_POST['action'] == 'exit') {
    	//echo "<script>window.close();</script>";
		header("Location: byState.php");
		session_destroy();
	}
  }
  else {
		if($_POST['drop_down_nomos'] == 'select_nomo') {
			//$nomos = $_POST['nomos'];
			$_SESSION['nomos'] = $_POST['value_nomos'];
			//$sec = "1";
			//header("Refresh: $sec; url=byState.php"); 
			header("Location: byState.php");
		}
		if($_POST['drop_down_nomos'] == 'select_perioxi') {
			$_SESSION['perioxi'] = $_POST['value_perioxi'];
			header("Location: byState.php");
		}
	  	if($_POST['select_perioxi'] == 'OK') {
			$_SESSION['perioxi'] = $_POST['value_perioxi'];
			header("Location: byState.php");
		}
		else if( isset ($_POST['drop_down_nomos'])) {
			$_SESSION['tk'] = $_POST['value_tk'];
			header("Location: byState.php");
		}
  }
	
}
//an ginei i apothikeusi stoixewm mesw TK (Taxudromikou Kwdika ))
elseif(($_SESSION['save_by'])=='tk') {
  if (isset($_POST['action'])){
	if ($_POST['action'] == 'save') { 
		if (!empty($_SESSION['postal_code'])){
		//if (isset($_POST['administrative_area_level_3']) && !empty($_POST['autocomplete'])) {
			//to pedio autocomplete periexei tin Poli kai tin Xwra	
			/*$explode_autocomplete = explode(',',$_POST['autocomplete']); //diaxwrizw perioxi-TK kai xwra
			//$postal_code = trim(substr($explode_autocomplete[0], -6)); //pairnw apo to 1o kommati prin to komma ta 5 teleutaia psifia pou einai o TK
			$explode_route = explode(',',$_POST['route']); //diaxwrizw perioxi-TK kai xwra
			$route = trim(substr($explode_route[0], -45)); //pairnw apo to 1o kommati prin to komma ta 5 teleutaia psifia pou einai i dieuthinsi
			if ((strpos($_POST['administrative_area_level_3'], 'Αθηνών') !== false) || (strpos($_POST['administrative_area_level_3'], 'Αττική') !== false)){ //apothikeysh nomou Attikis
				$_POST['administrative_area_level_3'] = "Αττική";
			}*/
			
			//se periptwsi pou to route pedio den apoteleitai mono apo odo tote:
			$explode_route = explode(',',$_POST['route']); //diaxwrizw odos me tin perioxi
			$routeAndAddress = $explode_route[0];
			$explode_route_final = explode(' ',$routeAndAddress);		
			$size = sizeof ($explode_route_final);
			$last_element = $explode_route_final [$size-1];
			if (is_numeric($last_element)){
				$route="";
				for($i=0;$i<$size-1;$i++){
					$route =  $route.$explode_route_final[$i]." ";
				}
			}
			else{
				$route = $routeAndAddress;
			}
					
			//$route = trim(substr($explode_route[0], -200)); //pairnw apo to 1o kommati prin to komma ta 5 teleutaia psifia pou einai i dieuthinsi
			$txt=$route.PHP_EOL.$_POST['street_number'].PHP_EOL.$_SESSION['locality'].PHP_EOL.trim($_SESSION['state']).PHP_EOL.$_SESSION['postal_code'].PHP_EOL.'Ελλάδα'.PHP_EOL.$_POST['latitude'].PHP_EOL.$_POST['langitude']; 
			file_put_contents('findAddress.txt', $txt);
			file_put_contents('findAddress.ini', 'byZip.php');
			echo "Επιτυχής εγγραφή";
			$sec = "2";
			header("Refresh: $sec; url=index.php"); 
			session_destroy();
		}
		else {
		   echo "Δεν είναι όλα τα πεδία συμπληρωμένα";
			$sec = "1";
			header("Refresh: $sec; url=byZip.php"); 
		}
	}

	//refresh ti selida me clear ta sessions
	else if ($_POST['action'] == 'clear all') { 
		header("Location: byZip.php"); 
		session_destroy();
	}
	else if ($_POST['action'] == 'exit') {
    	//echo "<script>window.close();</script>";
		header("Location: byZip.php");
		session_destroy();
	}  
  }
	else {
		if($_POST['drop_down_tk'] == 'OK') {
			$_SESSION['postal_code'] = $_POST['value_tk'];
			header("Location: byZip.php");
		}
		if($_POST['drop_down_perioxi'] == 'select_perioxi') {
			$_SESSION['locality'] = $_POST['value_perioxi'];
			header("Location: byZip.php");
		}
  	}
}

?>