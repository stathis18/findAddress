<!DOCTYPE html>
<html>
<head>
    <title>Εύρεση Διέθυνσης Μέσω Νομού</title>
	<meta name="description" content="Web Api for finding an address">
	<meta name="keywords" content="HTML,CSS,JavaScript,PHP">
	<meta name="author" content="Stathis Liampas">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="height=device-height, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel= "stylesheet" type="text/css" href= "style.css">
	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
	<link rel="icon" type="image/png" href="icons/google_icon.png">
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK82k3-3glRm_PJfQ6bzjQMiKgXeU8DoQ"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
function getStates(value) {
    $.post("search.php", {name:value},function(data){
        $("#results").html(data);
    }
    ); 
}
</script>
</head>

<body onLoad="if(document.getElementById('value_nomos').value!= ''){initMapMarker();}
			  else{document.getElementById('nomos').focus(); }
			  if(document.getElementById('address').value!= ''){document.getElementById('submit').click();}"> <!if(document.getElementById('route').value!= ''){document.getElementById('map_button').click();}>
<br>
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
	$con = mysql_connect("$host", "$username", "$password") or die("Αδυναμία σύνδεσης! Ενημερώστε το τμήμα ΙΤ.");
	//mysqli_query($con,"SET CHARACTER SET 'utf8'");
	mysql_select_db("$db_name") or die ("Αδυναμία σύνδεσης με βάση! Ενημερώστε το τμήμα ΙΤ.");
	$mysqli = new mysqli("$host", "$username", "$password", "$db_name");
	
	//gia ellinikous xaraktires
	$mysqli->set_charset("utf8");
	$mysqli->query("SET NAMES 'utf8'");
	$_SESSION['save_by']='state';
	//$_SESSION['nomos']="";
?>
	
	
<table cellpadding:"0">
<!emfanisi formas>	
<form id="address_form" action="save_data.php" method="POST">	
<td id="td_form">	
<!ta stoixeia dieuthinsis emfanizontai sto aristero meros tis othonis>
<div class="address_div">	     			
    <table id="table_address">
	<td id="td_menu" style="min-width: 80px;max-width: 130px;">	
		<table id="table_menu" cellpadding:"0" border="0" style="min-width: 80px;max-width: 210px;min-height: 360px;">
			<tr>
				<td class="menu" id="google" style=" text-align: center;  background-color:lightgray;" >
					<a href="byAddress.php" id="byAddress_button" style="font-size: 22px;text-align: center; padding-top: 20px;padding-bottom: 30px;" onclick="document.getElementById('clear_button').click(); document.getElementById('byAddress_button').click();" >Μέσω Διεύθυνσης</a>
				</td>
				<td class="border-side-rows" rowspan="7" style="max-width: 1px;min-width:1px;height: 100%"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="menu" id="elta" style="text-align: center;  background-color:lightgray;" >
				<!to link gia to Μέσω Νομού einai apenergopoihmeno>	
				<a href="byState.php" id="byState_button" style="font-size: 22px;text-align: center;padding-top: 20px;padding-bottom: 30px;" onmousedown="document.getElementById('clear_button').click();">Μέσω Νομού</a>
				</td>
				<script>document.getElementById("byState_button").style.backgroundColor = "Gray";</script>
			</tr>	
			<tr style="min-height:50px;max-height: 50px;"></tr>
			<tr>
				<td class="menu" id="tk" style="text-align: center;  background-color:lightgray; " >
				<!to link gia to Μέσω ΤΚ einai apenergopoihmeno>	
				<a href="byZip.php" id="byZip_button" style="font-size: 22px;text-align: center;padding-top: 20px;padding-bottom: 30px;" onclick="document.getElementById('clear_button').click();document.getElementById('byZip_button').click();">Μέσω <br> Τ.Κ.</a>
				</td>
			</tr>
			<tr></tr>
			<tr></tr>
		</table>
	</td>
	<td id="td_pedia">
	 <table id="table_pedia" border="0">	
	  <tr style="height:60px;">			
       		<td class="label">Χώρα</td>
        	<td class="wideField" style="text-align:left;" <!input class="field" id="country"  name="country" disabled="true"><!/input>
			 <select name="country" id="country" style="max-width:300px;min-width:300px;" disabled >
				<option value="Ελλάδα" id="country_greece"><i>Ελλάδα</i></option>
				<option value="Άλλη χώρα">Άλλη χώρα</option>
			<script>document.getElementById("country").style.opacity="0.7";</script>
			</td>
			<td id="session_nomos">
		  	<?php
			if (isset  ($_SESSION['nomos'])){	
			echo $_SESSION['nomos'];
			} ?>
		  	</td>
			<td id="session_perioxi">
		  	<?php
			if (isset  ($_SESSION['perioxi'])){	
			echo $_SESSION['perioxi'];
			} ?>
			</td>		
      </tr>
	  <tr style="height:60px">
			<td class="label">Νομός</td>
        	<td class="wideField" id="nomoi_ellados" style="text-align: left;max-width: 300px;min-width: 300px;" >
			<!form id="nomos_form" method="POST">	
			<?php
			//pairnw tous nomous apo tin basi mas
			$stmt = $mysqli->prepare("SELECT DISTINCT nomos FROM greek_localities ORDER BY `id` ASC");
			$stmt->execute();
			$stmt->bind_result($nomos);
			$stmt->store_result();
				//selected='$_SESSION['nomos']'
			echo "<select name='nomos' id='nomos' onchange='getNomos();' style='text-align:left; max-width:300px;min-width:300px;' "?>
			<p><?php echo '<option value= ></option>'; ?></p>
			<?php while($stmt->fetch()){?>
				<p><?php echo '<option value='.$nomos.' >'.$nomos.'</option>'; ?></p>
			<?php } 
			echo "</select>";
			?>
			<!prospatheia gia real time pliktrologisi>	
			<script>
			var $rows = $('$nomos');
			$('#search').keyup(debounce(function() {
				var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

				$rows.show().filter(function() {
					var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
					return !~text.indexOf(val);
				}).hide();
			}, 300));
			</script>	
			<!krataw ton epilegmeno nomo>
			<script>
				//document.getElementById("nomos").focus();
				$(function() {
					if (localStorage.getItem('nomos')) {
						$("#nomos option").eq(localStorage.getItem('nomos')).prop('selected', true);
					}
					$("#nomos").on('change', function() {
						localStorage.setItem('nomos', $('option:selected', this).index());
					});
				});
			</script>
			</td>
			<td><input id="value_nomos" name="value_nomos" value="<?php if (isset  ($_SESSION['nomos'])) {echo $_SESSION['nomos'];}?>" ></td>	
			<td><input type=submit name='drop_down_nomos' value="select_nomo" id="select_nomo" onclick=""></td>
		  	<!/form>
      </tr>
      <tr style="height:60px">
        <td class="label">Περιοχή</td>
        <td class="wideField" colspan="1" id="locality_td" style="text-align:left; max-width:300px;min-width:300px;" disabled="true">
			<!input class="field" id="locality" name="locality" ><!/input>
				<!input id="autocomplete" name="autocomplete" placeholder="Πληκτρολόγησε την περιοχή" onFocus="geolocate()" type="text" ><!/input> <!required>
			<p class="field" >
			<!to pedio ΠΕΡΙΟΧΗ ws live search>	
			<input id="locality" name="locality" type="text" placeholder="Πληκτρολόγησε την περιοχή" style="text-align:left; max-width:293px;min-width:293px;" onkeyup="getStates(this.value)" onkeypress="tab();" value="<?php if (isset  ($_SESSION['perioxi'])) {echo $_SESSION['perioxi'];}?>" disabled="true"/>
				<select id="results" style="text-align:left; max-width:298px;min-width:298px;max-height: 50px;" 
						onchange="document.getElementById('locality').value=document.getElementById('results').value;document.getElementById('select_perioxi_button').click();"
						onblur="document.getElementById('locality').value=document.getElementById('results').value;document.getElementById('select_perioxi_button').click();"></select>	
			<script>	
				//prospatheia gia search,den xreiazetai leitorgei OK
				/*	$(document).ready(function() {
				$("#locality").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#results *").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)});});});*/
								
				//i drop down list me ta proteinomena na emfanizetai mono otan prepei
				if(document.getElementById('value_nomos').value==""){document.getElementById('results').style.display="none";}
			</script>
			<?php
			//pairnw tis perioxes tou sugkekrimenou nomou apo tin basi mas
			if (isset  ($_SESSION['nomos'])){	
			$nomos = $_SESSION['nomos'];
			} 	
			
			if (isset($_SESSION['nomos'])){?>
			<script> 
				document.getElementById("locality").disabled = false;
			</script>	
			<?php
			} 		
			?>
			</p>
		</td>
		<td style="text-align: center;padding-top: 13px;" valign='top'><input type=submit name='select_perioxi' value="OK" id="select_perioxi_button" class="ok_button"  onclick='getPerioxi()'></td>
		<script>//if(document.getElementById("value_nomos").value==""){}
			//panta na min fainetai to koumpi OK
			document.getElementById("select_perioxi_button").style.display="none";
		</script>
		<td><input id="value_perioxi" name="value_perioxi" value="<?php if (isset  ($_SESSION['perioxi'])) {echo $_SESSION['perioxi'];}?>" ></td>	
		  <script>if(document.getElementById('value_perioxi').value!=""){document.getElementById('results').style.display="none";}</script>   
		<td><input type=submit name='drop_down_nomos' value="select_perioxi" id="select_perioxi" ></td>
		<td></td>	
		<td></td>		
      </tr>
	  <tr style="height:60px">
		<td class="label">Τ.Κ.</td>
        <!td class="slimField"><!input class="field" id="postal_code" name="postal_code" disabled="true" readonly><!/input><!/td>
		<td class="wideField" id='postal_code_td' style="text-align: left;max-width: 300px;min-width: 300px;" >
			<p class="field" >
				
			<?php
			$perioxi=""; //gia na mhn emfanizei error otan den einai settarismeni
			//pairnw ta tk tou sugkekrimenou nomou kai tis sugkekrimenis perioxis apo tin basi mas
			//$nomos = " ΘΕΣΣΑΛΟΝΙΚΗΣ";//$nomos = $_COOKIE['cookieName'];//$_SESSION['nomos']  = " ΘΕΣΣΑΛΟΝΙΚΗΣ";
			if (isset  ($_SESSION['perioxi'])){	
			$perioxi = $_SESSION['perioxi'];
			}
			if (isset  ($_SESSION['nomos'])){	
			$nomos = $_SESSION['nomos'];
			} 	
			if($stmt3 = $mysqli->prepare("SELECT DISTINCT tk FROM greek_localities where perioxi=? and nomos =? GROUP BY tk ASC")){
				$stmt3->bind_param('ss', $perioxi_s, $nomos_s);
				$perioxi_s = $perioxi;
				$nomos_s = $nomos;
				$stmt3->execute();
				$stmt3->bind_result($tk);
				$stmt3->store_result();
				echo "<select name='postal_code' id='postal_code' onchange='getTK()' style='text-align:left; max-width:300px;min-width:300px;' disabled='false'; readOnly='false'; " ?>
				<p><?php echo '<option value= ></option>'; ?></p>
				<?php while($stmt3->fetch()){?>
					<p><?php echo '<option value='.$tk.'>'.$tk.'</option>'; ?></p>
				<?php }
				echo "</select>"; 
				$stmt3 -> fetch();
			}		
			if (isset($_SESSION['perioxi'])){?>
			<script> 
				document.getElementById("postal_code").disabled = false;
			</script>	
			<?php
			} 		
			?>
			</p>
		 	<!tin epilegmeni perioxi>
			<script>
				document.getElementById("postal_code").focus();
				$(function() {
					if (localStorage.getItem('postal_code')) {
						$("#postal_code option").eq(localStorage.getItem('postal_code')).prop('selected', true);
					}
					$("#postal_code").on('change', function() {
						localStorage.setItem('postal_code', $('option:selected', this).index());
					});
				});
			</script>
			</td>
			<td><input id="value_tk" name="value_tk" value="<?php if (isset  ($_SESSION['tk'])) {echo $_SESSION['tk'];}?>" ></td>	
			<td><input type=submit name='drop_down_nomos' value="select_tk" id="select_tk"></td>
			<!an uparxei mono ena TK proepilekse to>
			<?php
			if ($stmt3->num_rows == 1 && isset  ($_SESSION['perioxi'])){ ?>
				<script> 
						var lastValue = $('#postal_code option:last-child').val();
						document.getElementById("postal_code").value = lastValue;
						document.getElementById("value_tk").value = lastValue;
						document.getElementById("postal_code").readOnly = true;
						//document.getElementById("postal_code").disabled = true;
						//document.getElementById("route").focus();
						//document.getElementById('select_tk').click();
				</script> 
			<?php } ?>
	  </tr>
      <tr style="height:60px">
        <td class="label">Οδός</td>
        <td class="wideField">
			<!input class="field" id="route" name="route" disabled="true">
			<input class="field" id="route" name="route" placeholder="Πληκτρολόγησε την οδό" style="max-width: 298px;" onchange="setRoute();fillInAddress2()" onsubmit="fillInAddress2()" onFocus="initMap();" onclick="initMap();" type="text" disabled="true"></input> <!>
		</td>
			
		<!focus sto pedio dieythinsi kai o cursor stin arxi>
		<script>
			//function focusOnRoute(){
			if(document.getElementById("value_tk").value !="" ){
				document.getElementById("route").focus();
			}	
			//move the cursor at the beginning of the field	
			function moveCaretToStart(el) {
				if (typeof el.selectionStart == "number") {
					el.selectionStart = el.selectionEnd = 0;
				} else if (typeof el.createTextRange != "undefined") {
					el.focus();
					var range = el.createTextRange();
					range.collapse(true);
					range.select();
				}
			}
			var textBox = document.getElementById("route");
			textBox.onfocus = function() {
				moveCaretToStart(textBox);
				window.setTimeout(function() {
					moveCaretToStart(textBox);
				}, 1);
			};
		//}	
		</script>
	
		<!me to patima toy enter Η ΤΟΥ ΤΑΒ na ginetai save>
		<script>
			if(document.getElementById("locality").value == ""){ //diaforetika anairei to scriptaki gia tin odo!
				window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13||e.keyCode==9)		{if(e.target.nodeName=='INPUT'&&e.target.type=='text'){
						document.getElementById('locality').value=document.getElementById('results').value;
						document.getElementById('select_perioxi_button').click();
						document.getElementById('postal_code').focus();
				}
				}},true);
			}
		</script>
	
		<!opoio pedio den einai enabled na fainetai axno!>
		<?php if (empty  ($_SESSION['nomos'])){?>
			<script>
				document.getElementById("locality").style.opacity="0.5";
				document.getElementById("postal_code").style.opacity="0.5";
			</script>
			<?php
			}
			else if (empty  ($_SESSION['perioxi'])){?>
			<script>
				document.getElementById("postal_code").style.opacity="0.5";
			</script>
			<?php
			}
			?>
	    <td class="label"><b>Αριθμός</b></td>
	    <td class="slimField" ><input class="field" id="street_number" name="street_number" style="max-width:99%;text-align: left" value=" " disabled="true" ></input></td>
      </tr>
	  <tr style="height:30px">
		<td><input id="visible_map" style="max-width:20px;min-width:10px;" value="1";/></td>
		<td><input id="submit" type="button" value="Geocode"></td>
		<script> document.getElementById("visible_map").style.display='none';</script>
		<!boithitiko pedio gia emfanisi ston xarti kathe fora poy epilegw nomo, perioxi kai TK>
		<td class="wideField" id="autocomplete_test_td">
			<input class="field" id="address" type="textbox" value="<?php 
																	
																	if (isset  ($_SESSION['nomos']) && isset ($_SESSION['perioxi']) && isset ($_SESSION['tk'])) {
																			echo $_SESSION['perioxi']. ", " . $_SESSION['nomos']. ", " .$tk ;} 
																	else if (isset  ($_SESSION['nomos']) && isset ($_SESSION['perioxi'])) {echo $_SESSION['perioxi']. ", " .$_SESSION['nomos'];}
																	else if (isset  ($_SESSION['nomos']) && empty ($_SESSION['perioxi'])) {echo "νομός ". $_SESSION['nomos'];}
																	?>"  onclick="initMapMarker();document.getElementById('route').focus();" type="text"></input>
		<script> 
			document.getElementById("address").style.display='none';
			document.getElementById("autocomplete_test_td").style.display='none';
			document.getElementById("submit").style.display='none';
		</script>
		</td>
	  </tr>
	  <tr style="height:60px;padding-bottom: 0px;">	
		<td></td>
		<td style="vertical-align:bottom;">
		   <!input type="image" src="icons/map_marker.png" class="button" value="map marker" onclick="initMap();" style="width: auto"/>
		<div class="container">
		  <img src="icons/map_marker.png"  id="map_button" class="button" alt="map_marker" style="width: 60px;margin-right: 1px; " onclick="showHide();"
			   style="width: 60px;">
			<!invisible to koumpi gia emfanisi kai apokripsi toy xarti>
			<script>document.getElementById('map_button').style.display='none';</script>
			<!div class="middle">
    			<!div class="hover_text" style="margin-left: 5px;"><!map/div>
			  </div>
		</div>
		</td>
		<td style="vertical-align:bottom;"><div class="container">
		  <!input class="button" name="action" value="clear all" type="submit"  onclick="" method="post"/>
			<button id="clear_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="clear all" 
				onclick="$('#nomos option:selected').remove(); localStorage.removeItem('nomos');localStorage.removeItem('locality');localStorage.removeItem('postal_code');" 
				method="post"> 
				<img src="icons/delete.png"  class="button" style="height:45px;margin-right: 0px;"  />
			</button>
			<button id="cancel_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="exit" method="post"  
				onclick= " localStorage.removeItem('nomos');localStorage.removeItem('locality');localStorage.removeItem('postal_code');
						  return confirm('Πάτησε οκ αν θες έξοδο αλλίως πάτησε Ακύρωση');"> 
  			<img src="icons/cancel.png" id="cancel_button"  class="button" style="height:45px;"/>
			</button>
			<!invisible to koumpi clear>
			<script>document.getElementById('clear_button').style.display='none';</script>
			<div class="middle">
    			<!div class="hover_text" ><!Clear/div>
			  </div>
			</div>
		</td> 
		<td style="vertical-align:bottom;"><div class="container">
			<!input id="save_button" class="button" name="action" value="save" type="submit" onclick="" method="post"/>
			<button id="save_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="save" method="post" 
					onclick= "localStorage.removeItem('nomos');localStorage.removeItem('locality');localStorage.removeItem('postal_code');"> 
  				<img src="icons/save.png"  class="button" style="height:45px;margin-right:0px;"/>
			</button>
			  <div class="middle">
    			<!div class="hover_text" ><!Save/div>
			  </div>
			</div>
		 </td>	
	  </tr>
	  <tr>
		<td></td>
		<td style="padding-right:18px;"><i id ="map_text" style="font-size: 20px;vertical-align:top;padding-top: 0px;margin-right: 0.5px;">map</i></td><script>document.getElementById('map_text').style.display='none';</script>
		<td style="padding-right:16px;"><i id ="clear_text"  style="font-size: 20px;vertical-align:top;padding-top: 0px;margin-right: 0.5px;">clear</i>
		  <i id ="cancel_text"  style="font-size: 20px;vertical-align:top;padding-top: 0px;margin-left: 16px; ">cancel</i>
		</td>
		 <script>document.getElementById('clear_text').style.display='none';</script>
		<td style="padding-right:18px;"><i style="font-size: 20px;vertical-align:top;margin-right:0px;">save</i></td>
	  </tr>
	</table>
	</td>
  </table>
 <script>	 
//DEN DEIXNW TA EXTRA POU XREISIMOPOIHSA GIA NA PERASW TIS TIMES APO DROP DROWN MENU	 
	 	document.getElementById("session_nomos").style.display="none";
		document.getElementById("value_nomos").style.display="none";
		document.getElementById("select_nomo").style.display="none";
		document.getElementById("value_perioxi").style.display="none";
		document.getElementById("select_perioxi").style.display="none";
		document.getElementById("session_perioxi").style.display="none";
	 	document.getElementById("value_tk").style.display="none";
		document.getElementById("select_tk").style.display="none";
		document.getElementById("session_tk").style.display="none"; 
		
	 	document.getElementById("submit").style.display="none";
		document.getElementById("address").style.display="none";
	 	document.getElementById("autocomplete_test_td").style.display='none';
	 	document.getElementById("autocomplete_test").style.display="none"; 
</script>

 <!scriptaki energopoihsh odou>	 
<?php if (isset($_SESSION['nomos']) && isset($_SESSION['perioxi'])&& isset($_SESSION['tk'])){ ?>	
	<script> 
		setRoute();
		 function setRoute(){ 
			  document.getElementById("route").disabled = false;
			  //document.getElementById("street_number").disabled = false;
			  /*pairnw to nomo pou exei epileksei kai ton topothetw sto katw pedio*/
			  var nomos_selected = document.getElementById("value_nomos").value;
			  if(nomos_selected!=""){  
			  	document.getElementById("route").focus();
				var	route= ", "+nomos_selected;
			  }
			  /*pairnw tin perioxi pou exei epileksei kai ton topothetw sto katw pedio*/
			  var perioxi = document.getElementById("value_perioxi").value;
			  if(perioxi!=""){  
			  	document.getElementById("postal_code").focus();	  
			  	route =", " + perioxi + route;
			  }
			 var tk = document.getElementById("value_tk").value;
			  if(tk!=""){  
			  	document.getElementById("route").focus();	  
			  	document.getElementById('route').setAttribute('value', route + ", "+ tk);
			  }
			 //document.getElementById("street_number").value="";
			 document.getElementById("route").focus();
		} 
	</script>
<?php } ?>

<!scriptaki gia proboli kai apokripsi tou xarti>
<script>
function showHide()
{
    var pwShown = document.getElementById('visible_map').value;
    if (pwShown == 0) 
    {
        pwShown = 1; //kanto visible
		document.getElementById('visible_map').setAttribute('value', "1");
		document.getElementById('map').style.display='block';
		initMap();
    } 
    else {
        pwShow = 0; //kanto invisible
		document.getElementById('visible_map').setAttribute('value', "0");
		document.getElementById('map').style.display='none';
    }
}
</script>

<!scriptaki gia press enter button>
<script>
	//apenergopoihsh tou default enter button wste me tin epilogh kapoias dieuthinsis na sumplirwnontai aytomata ta pedia!
	window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
</script>

<!scriptaki gia na parw ton Nomo>	
<script> 
function getNomos(){
		//document.getElementById("value_nomos").value = " " + document.getElementById("nomos").value;
		var state = document.getElementById("nomos");
		var strState = state.options[state.selectedIndex].text;
		document.getElementById("value_nomos").value = " " + strState;
		document.getElementById("locality").focus();
		document.getElementById('select_nomo').click();
		//document.getElementById('submit').click();
		//document.getElementById("autocomplete").value = document.getElementById("value_nomos").value;
		document.getElementById("autocomplete").click();				
}
</script>

<!pairnw tin Perioxi>	
<script> 
function getPerioxi(){
			var local = document.getElementById("locality");
			//document.getElementById("locality").value="";
			//var strLocality = local.options[local.selectedIndex].text;
			document.getElementById("value_perioxi").value = document.getElementById("locality").value;
			document.getElementById("postal_code").focus();
			document.getElementById('select_perioxi').click();
			//document.getElementById('map_button').click();
	 		//initMap();
}
				</script>

<!pairnw ton Taxudromiko Kwdika>	
<script> 
function getTK(){
	var local = document.getElementById("postal_code");
	var strLocality = local.options[local.selectedIndex].text;
	document.getElementById("value_tk").value = strLocality;
	document.getElementById('select_tk').click();
	document.getElementById("route").focus();
	//document.getElementById('map_button').click();
	//initMap();
}
</script>

<?php
if (isset  ($_SESSION['nomos'])){ ?>
<script>initMapMarker();	document.getElementById('submit').click(); document.getElementById("route").focus();</script>
<?php }
?>

</div>
</td>
</div>
</td>

<!i apeikonisi tou xarti me to stigma emfanizetai sto deksi meros tis othonis>
<td style="width:50%">	
<table>
	<tr min-height="20px;">	
		<!suntetagmenes stigmatos>
		<div id="coordinates" align="left"><script>document.getElementById('coordinates').style.display='none';</script>	
		<label>πλάτος:</label>	
		<input id="latitude" name="latitude" style="width:190px;" readonly></input>
		<label>μήκος:</label>	
		<input id="langitude" name="langitude" style="width:190px;" readonly></input>
		</div>
	</tr>
	<tr style="align-content: flex-start">
		<!emfanisi xarti>
		<!div style="margin: auto;  position: relative; text-align: center;"><i!><!Εμφάνιση στο χάρτη:<!/i><!/div>
		<div id="map" ></div>
		<!me stoixeia apo to place autocomplete>
		<div id="infowindow-content">
		  <img src="" width="16" height="16" id="place-icon">
		  <span id="place-name"  class="title"></span><br>
		  <span id="place-address"></span>
		</div>
	</tr>
	<tr>
		<div id="latlng-panel"><script>document.getElementById('latlng-panel').style.display='none';</script>
		  <label>latlng:</label>
		  <input id="latlng" name="latlng" type="text" style="width:480px;" readonly><script>document.getElementById('reverse_button').style.display='none';</script>	
		  <input id="reverse_button" type="button" value="Reverse Geocode"><script>document.getElementById('reverse_button').style.display='none';</script>	
		</div>
	</tr>	
</table>
</td>	
</form>	
</table>

<!scriptaki gia autocomplete pediwn>
    <script>
      var placeSearch, autocomplete;
      var componentForm = {
        //postal_code: 'short_name',
		street_number: 'short_name',
		route: 'short_name'
      };

      function initAutocomplete() {
		var input = document.getElementById('route');
		var options = {
		  types: ['address'],  
		  componentRestrictions: {country: 'gr'} //mono gia thn ellada
		};
		
		 autocomplete = new google.maps.places.Autocomplete(input, options);		  
		 autocomplete.addListener('place_changed', fillInAddress);
		  
      } 

		  //me to patima toy enter na ginetai save
		  $("input").keypress(function(event){
            if(event.keyCode == 13 || event.keyCode == 9) {
				 $("#save_button").click();
            }
		  });
		
		 function fillInAddress() {
        // Get the place details from the autocomplete object.
        	var place = autocomplete.getPlace();

        	for (var component in componentForm) {
          		document.getElementById(component).value = '';
          		document.getElementById(component).disabled = false;
			}
		  
        	// Get each component of the address from the place details
			// and fill the corresponding field on the form.
        	for (var i = 0; i < place.address_components.length; i++) {
				var addressType = place.address_components[i].types[0];
				if (componentForm[addressType]) {
					var val = place.address_components[i][componentForm[addressType]];
					document.getElementById(addressType).value = val;
				}
			}
		 }

      function fillInAddress2() {
        		    document.getElementById("route").disabled = false;
		  			document.getElementById("street_number").disabled = false;
		 			//spaw to autocomplete field (input)
					var input = document.getElementById("route").value;
					var myarray = input.split(",");
					
						//pairnw to 1o kommati pou afora odo kai arithmo
						var addressAndnumber =  myarray[0];
						var array_final = addressAndnumber.split(" "); //se pinaka ta stoixeia tis odou kai tou arithmou an yparxoun
									
						//an to 1o kommati apoteleitai mexri 2 stoixeia tote
						if(array_final.length<=2){
								var isnum = /\d/.test(array_final[1]); //elegxos an einai arithmos to 2o stoixeio
								if(isnum){ // tote balto ston street_number 
									var number =  array_final[1];			
									if(number<=1000){document.getElementById("street_number").value=number;} //gia na min pairnei ton TK ws arithmo
									document.getElementById("route").value=array_final[0];
								}
								else{ //diaforetika prokeitai gia odo me 2 lekseis
									document.getElementById("route").value=	document.getElementById("route").value+array_final[1];
								}
								//an einai prwta o arithmos kai meta i odos
							var isnumberfirst = /\d/.test(array_final[0]); //elegxos an einai arithmos to 2o stoixeio
								if(isnumberfirst){ // tote balto ston street_number 
									var number =  array_final[0];			
									if(number<=1000){document.getElementById("street_number").value=number;} //gia na min pairnei ton TK ws arithmo
									document.getElementById("route").value=array_final[1];
								}	
								//an den exei arithmo
								if( array_final[1] == null ) {
									document.getElementById("street_number").value=" ";
									document.getElementById("route").value=array_final[0];
								}							
								//an den exei arithmo oute odo
								if( array_final[0] == null ) {
									document.getElementById("street_number").value=" ";
									document.getElementById("route").value=" ";
								} 
						}
						//periptwsi pou i odos exei perissotera apo 1 onomata px Leoforos Kwnstantinou Karamanli tote
						else{
							//elegxw an to teleutaio psifio einai arithmos gia na to balw sto street_number, diaforetika prokeitai mono gia odo
							var last_element = array_final[array_final.length-1];
							var isnum = /\d/.test(last_element);
							if(isnum){
								var address="";
								for(i=0;i<array_final.length-1;i++){
									var address =  address + array_final[i]+" ";
								}
								document.getElementById("route").value=address;
								if(last_element<=1000){document.getElementById("street_number").value=last_element;}
								else{document.getElementById("street_number").value=" ";}//gia na min pairnei ton TK ws arithmo
							}
							else{ //diaforetika prokeita gia odo me 2 lekseis kai panw
								document.getElementById("route").value=addressAndnumber;
							}
						}
		  document.getElementById("save_button").focus();		 
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

	<!scriptaki gia apeikonisi ston xarti- place autocomplete https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete#top_of_page>
	<script>
      function initMap() {
		  /* 
		  var nomos = document.getElementById("nomoi_ellados").value;
		  //pairnw to nomo pou exei epileksei kai ton topothetw sto katw pedio
		  if(nomos!="empty"){  
		  document.getElementById("autocomplete").focus();
		  document.getElementById('autocomplete').setAttribute('value',","+nomos);
		  nomos.scrollLeft = nomos.scrollWidth;
		  }
		 */
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 40.5, lng: 22.2},
          zoom: 5
        });
		 
        var card = document.getElementById('pac-card');
        var input = document.getElementById('route');
        var types = document.getElementById('type-selector'); 
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
		 
		 //edw anoigei drop down kai thelei ksana klik!!!
        var autocomplete =  new google.maps.places.Autocomplete(input);
		  
		  // Set initial restrict for greece
        autocomplete.setComponentRestrictions({'country': 'gr'});
		  
		  //predictions are done with AutocompleteService
		/*service = new google.maps.places.AutocompleteService();
		var request = {
			input: 'tsi',
			componentRestrictions: {country: 'gr'},
		};
		service.getPlacePredictions(request, autocomplete);*/
		  
		//me to patima to enter na apeikonizetai h 1h epilogh aytomata! eixa prosthesei kai gia mouseover: $("input").mousedown(function(event){....
		  $("input").keypress(function(event){
            if(event.keyCode == 13 || event.keyCode == 9) {
                $(event.target).blur();
                if($(".pac-container .pac-item:first span:eq(3)").text() == "")
                    firstValue = $(".pac-container .pac-item:first .pac-item-query").text();
                else
                    firstValue = $(".pac-container .pac-item:first .pac-item-query").text() + ", " + $(".pac-container .pac-item:first span:eq(3)").text();
                event.target.value = firstValue;

            } else
                return true;
		  }); 
	  
        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map); //
		  
		//Restrict the search to the bounds  
		autocomplete.setOptions({strictBounds: true})
		 
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
			map: map,//,
			draggable: true,
			title:"Μετακίνησέ με!"
          //anchorPoint: new google.maps.Point(0, -29)
          //position: new google.maps.LatLng(40.5, 22.2)
        });
		  
		/*gia to metakinisimo stigma!** Start **/ 
		//otan stamatisei to drag tou stimgatos
		google.maps.event.addListener(marker, 'dragend', function (evt) {
		//document.getElementById('coordinates').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
		document.getElementById("latitude").setAttribute('value',evt.latLng.lat()); //get the latitude=gewgrafiko platos
		document.getElementById("langitude").setAttribute('value',evt.latLng.lng()); //get the langitude=gewgrafiko mikos
		var latitude_new = document.getElementById("latitude").value;
		var langitude_new = document.getElementById("langitude").value;
			
		initMapNew(); //fere to kainourgio meros meta tin metakinisi toy stigmatos!
			
		 //thelw na allazei me basi twn kainourgiwn suntetagmenwn to autocomplete text kai to infowindow
		function initMapNew() {	
			var  map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 18,
			  center: new google.maps.LatLng(latitude_new, langitude_new)
			});

			var latAndLang = latitude_new+ ',' +langitude_new;	
			document.getElementById("latlng").setAttribute('value',latAndLang); //gia na dw an pairnw tis nees suntetagmenes
			var geocoder = new google.maps.Geocoder;
			var infowindow = new google.maps.InfoWindow;
			var input = document.getElementById('latlng').value;
			var latlngStr = input.split(',', 2);
			var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};

			geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === 'OK') {
				if (results[0]) {
					map.setZoom(18);
				  	var marker = new google.maps.Marker({
					position: latlng,
					map: map
				  	});
				 	infowindow.setContent(results[0].formatted_address);
				  	infowindow.open(map, marker);

					//bazw sto autocomplete field to onoma apo to stigma. To arxiko kommati einai i dieythinsi k to allo o arithmos!
					document.getElementById("route").value =  infowindow.getContent(results[0].formatted_address);

					//spaw to autocomplete field (input)
					var input = document.getElementById("route").value;
					var myarray = input.split(",");
					
						//pairnw to 1o kommati pou afora odo kai arithmo
						var addressAndnumber =  myarray[0];
						var array_final = addressAndnumber.split(" "); //se pinaka ta stoixeia tis odou kai tou arithmou an yparxoun
									
						//an to 1o kommati apoteleitai mexri 2 stoixeia tote
						if(array_final.length<=2){
							//periptwsi poy uparxei odos
							if(array_final[0]!="Unnamed"){ 
								var address =  array_final[0];
								document.getElementById("route").value=address;
							}
							//periptwsi poy uparxei kai 2o stoixeio eite einai 2i leksi stin odo,eite prokeitai gia arithmos
							if(array_final[1]!=null && array_final[1]!="Road"){ 
								var isnum = /\d/.test(array_final[1]); //elegxos an einai arithmos to 2o stoixeio
								if(isnum){ // tote balto ston street_number 
									var number =  array_final[1];			
									document.getElementById("street_number").value=number;
								}
								else{ //diaforetika prokeitai gia odo me 2 lekseis
									document.getElementById("route").value=	document.getElementById("route").value+array_final[1];
								}
							}
							//an den exei arithmo
							if( array_final[1] == null ) {
								document.getElementById("street_number").value="";
							} 
						}
						//periptwsi pou i odos exei perissotera apo 1 onomata px Leoforos Kwnstantinou Karamanli tote
						else{
							//elegxw an to teleutaio psifio einai arithmos gia na to balw sto street_number, diaforetika prokeitai mono gia odo
							var last_element = array_final[array_final.length-1];
							var isnum = /\d/.test(last_element);
							if(isnum){
								var address="";
								for(i=0;i<array_final.length-1;i++){
									var address =  address + array_final[i]+" ";
								}
								document.getElementById("route").value=address;
								document.getElementById("street_number").value=last_element;
							}
							else{ //diaforetika prokeita gia odo me 2 lekseis kai panw
								document.getElementById("route").value=addressAndnumber;
							}	

						}
						//to 2o tmima tou input field prokeitai gia to taxudromiko kwdiko kai tin perioxi
						var CityAndTKAndCountry =  myarray[1];
						var array1 = CityAndTKAndCountry.split(",");
						var CityAndTK =  array1[0];
						var array_final1 = CityAndTK.split(" ");
						var isnum = /\d/.test(array_final1[2]);
						//an h perioxi apoteleitai apo 1 leksi
						if(isnum){
							var postal_code = array_final1[2] + " " + array_final1[3];
						}
						//an h perioxi apoteleitai apo 2 lekseis
						else{
							var postal_code = array_final1[3]+ " " + array_final1[4];
						}
						//document.getElementById("postal_code").value=postal_code;
					
					
					//merikes fores den fairnei stin forma ton nomο kai tin xwra, tote thelw na ta sumplirwnei-DEN LEITOYRGEI!
					/*if(document.getElementById("country").value == null){
						var country= array1[1]; //to telautaio tmima einai i xwra
						document.getElementById("country").value=country;
					}*/
					if(document.getElementById("administrative_area_level_3").value == null){
						document.getElementById("administrative_area_level_3").value=" ";
					}
					//document.getElementById("route").disabled = false;
		  			document.getElementById("street_number").disabled = false;
				} else {
				  window.alert('No results found');
				}
			  } else {
				window.alert('Geocoder failed due to: ' + status);
			  }
			});
			//document.getElementById("postal_code").disabled = false;
			//document.getElementById("route").disabled = false;
		  	document.getElementById("street_number").disabled = false;
      	  }
		});
		  
		//kata ti stimgi tis metakinisis tou stigmatos
		google.maps.event.addListener(marker, 'dragstart', function (evt) {
			//document.getElementById('coordinates').innerHTML = '<p>Currently dragging marker...</p>';
			document.getElementById("latitude").setAttribute('value','undefined'); 
			document.getElementById('langitude').setAttribute('value','undefined'); //get the langitude=gewgrafiko mikos
		});
		map.setCenter(marker.position);
		/*gia to metakinisimo stigma!** End **/  
	
        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(13); 
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }
		
			var postal_code = document.getElementById('postal_code').value;
			
          infowindowContent.children['place-icon'].src = place.icon;
          //infowindowContent.children['place-name'].textContent = place.name;
		  infowindowContent.children['place-name'].textContent = postal_code; //emfanisi tou TK
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
			
		  document.getElementById("coordinates").style.display='none'; //emfanish suntatagmenwn
		  document.getElementById("latitude").setAttribute('value',marker.getPosition().lat()); //get the latitude=gewgrafiko platos
		  document.getElementById('langitude').setAttribute('value',marker.getPosition().lng()); //get the langitude=gewgrafiko mikos
			
        });
		
        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        //for strict-bounds
		  document.getElementById('use-strict-bounds')=
		  
		  document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked!' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }	
    </script>

	<!scriptaki gia apeikonisi ston xarti- place autocomplete https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete#top_of_page>
	<script>
      function initMap2() {
		  document.getElementById("autocomplete_test").focus();
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 40.5, lng: 22.2},
          zoom: 8
        });
		 
        var card = document.getElementById('pac-card');
        var input = document.getElementById('autocomplete');
        var types = document.getElementById('type-selector'); 
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
		 
		 //edw anoigei drop down kai thelei ksana klik!!!
        var autocomplete =  new google.maps.places.Autocomplete(input);
		  
		  // Set initial restrict for greece
        autocomplete.setComponentRestrictions({'country': 'gr'});
		  
		  //predictions are done with AutocompleteService
		/*service = new google.maps.places.AutocompleteService();
		var request = {
			input: 'tsi',
			componentRestrictions: {country: 'gr'},
		};
		service.getPlacePredictions(request, autocomplete);*/
		  
		//me to patima to enter na apeikonizetai h 1h epilogh aytomata!
		  $("input").keypress(function(event){
            if(event.keyCode == 13 || event.keyCode == 9) {
                $(event.target).blur();
                if($(".pac-container .pac-item:first span:eq(3)").text() == "")
                    firstValue = $(".pac-container .pac-item:first .pac-item-query").text();
                else
                    firstValue = $(".pac-container .pac-item:first .pac-item-query").text() + ", " + $(".pac-container .pac-item:first span:eq(3)").text();
                event.target.value = firstValue;

            } else
                return true;
		  });  
	  
        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map); //
		  
		//Restrict the search to the bounds  
		autocomplete.setOptions({strictBounds: true})
		 
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,//,
          //anchorPoint: new google.maps.Point(0, -29)
          //position: new google.maps.LatLng(40.5, 22.2)
        });
	
        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(13); 
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }
		
			var postal_code = document.getElementById('postal_code').value;
			
          infowindowContent.children['place-icon'].src = place.icon;
          //infowindowContent.children['place-name'].textContent = place.name;
			infowindowContent.children['place-name'].textContent = postal_code; //emfanisi tou TK
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
			
		 document.getElementById("coordinates").style.display='none'; //emfanish suntatagmenwn
		 document.getElementById("latitude").setAttribute('value',marker.getPosition().lat()); //get the latitude=gewgrafiko platos
		 document.getElementById('langitude').setAttribute('value',marker.getPosition().lng()); //get the langitude=gewgrafiko mikos
			
        });
		
        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        //for strict-bounds
		  document.getElementById('use-strict-bounds')=
		  
		  document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked!' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }	
  

function initMapMarker(){
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 40.5, lng: 22.2},
          zoom: 5
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
			if (document.getElementById('value_nomos').value!="") { //gia tin perioxi kane zoom perissotero
			resultsMap.setZoom(8);
			}
			if (document.getElementById('value_perioxi').value!="") { //gia tin perioxi kane zoom perissotero
			resultsMap.setZoom(13);
				if (document.getElementById('postal_code').value=="") {document.getElementById("postal_code").focus();}
				else {document.getElementById("route").focus();}
			}
			else{
				document.getElementById("locality").focus();
			}  
            //resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
			resultsMap.panTo(results[0].geometry.location);
			
			google.maps.event.addListener(marker, 'click', function(event) {
				var iwindow = new google.maps.InfoWindow();
				iwindow.setContent(results[0].formatted_address);
				iwindow.open(resultsMap, this);
			}); 
			  	//trigger to clickarisma toy stigmatos
			  	google.maps.event.trigger( marker, 'click' );
			  	//apothikevontas kai tis suntetagmenes
				document.getElementById("latitude").setAttribute('value',marker.getPosition().lat()); 
				document.getElementById('langitude').setAttribute('value',marker.getPosition().lng());  
		  }  
		  else {
            alert('Geocode was not successful for the following reason: ' + status);
          }	  
        });
      }
		
    </script>

	<!Ta keys: autocomplete:AIzaSyDitW4QQFeSmLhQp20UTyZJTquIHCu9e2g, xarti:AIzaSyA8DQSfGhzpEa0ngRzPLTctoxukF9PvLX0, reverse Geocoding:AIzaSyDysySs8ogleetc3DgjVLup6KesWQHA7mI 
				,ApiKey3: AIzaSyA7-G5x-cTWMll4fJQB5wOpChhLpm1ZIYs>

	<!script της google για την εύρεση στον χάρτη>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8DQSfGhzpEa0ngRzPLTctoxukF9PvLX0&libraries=places&callback=initMap" async defer></script>
	<!This example requires the Places library. Include the libraries=places parameter when you first load the API. For example:>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDitW4QQFeSmLhQp20UTyZJTquIHCu9e2g&libraries=places"> </script>
	
	<!script της google για την αυτόματα συμπλήρωση πεδίων>
  	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDitW4QQFeSmLhQp20UTyZJTquIHCu9e2g&libraries=places&callback=initAutocomplete" async defer></script>
	
	<!script gia to geocode reverse>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDysySs8ogleetc3DgjVLup6KesWQHA7mI&callback=initMap">

  </body>
</html>