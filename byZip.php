<!DOCTYPE html>
<html>
<head>
    <title>Εύρεση Διέθυνσης Μέσω Ταχυδρομικού Κώδικα</title>
	<meta name="description" content="Web Api for finding an address">
	<meta name="keywords" content="HTML,CSS,JavaScript,PHP">
	<meta name="author" content="Stathis Liampas">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="viewport" content="height=device-height, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel= "stylesheet" type="text/css" href= "style.css">
	<link rel= "stylesheet" type="text/less" href= "style_boostrap.less">
	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
	<link rel="icon" type="image/png" href="icons/google_icon.png">
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK82k3-3glRm_PJfQ6bzjQMiKgXeU8DoQ"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body onLoad="if(document.getElementById('value_nomos').value!= ''){initMapMarker();}
			  else{document.getElementById('nomos').focus();}
			  if(document.getElementById('address').value!= ''){document.getElementById('submit').click();}"> <!if(document.getElementById('route').value!= '')">
	<!if(document.getElementById('route').value!= ''){document.getElementById('map_button').click();}>
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
	$_SESSION['save_by']='tk';
	
?>
<table cellpadding:"0">
<!emfanisi formas>	
<form id="address_form" action="save_data.php" method="POST">	
<td id="td_form">	
<!ta stoixeia dieuthinsis emfanizontai sto aristero meros tis othonis>
<div class="address_div">	     			
    <table id="table_address">
	<td id="td_menu" style="min-width: 80px; max-width: 150px;">	
		<table id="table_menu" cellpadding:"0" border="0" style="min-width: 80px;max-width: 210px;min-height: 360px;">
			<!td>
			<tr>
				<td class="menu" id="google" style=" text-align: center;  background-color:lightgray;" >
					<a href="byAddress.php" id="byAddress_button" style="font-size: 22px;text-align: center; padding-top: 20px;padding-bottom: 30px;" onclick="document.getElementById('clear_button').click(); document.getElementById('byAddress_button').click();" >Μέσω Διεύθυνσης</a>
				</td>
				<td class="border-side-rows" rowspan="7" style="max-width: 0px;min-width:0px;height: 100%"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="menu" id="elta" style="text-align: center;  background-color:lightgray;"  >
				<!to link gia to Μέσω Νομού einai apenergopoihmeno>	
				<a href="byState.php" id="byState_button" style="font-size: 22px;text-align: center;padding-top: 20px;padding-bottom: 30px;" onclick="document.getElementById('clear_button').click(); document.getElementById('byState_button').click();" >Μέσω Νομού</a>
				</td>	
			</tr>	
			<tr style="min-height:50px;max-height: 50px;"></tr>
			<tr>
				<td class="menu" id="tk" style="text-align: center;  background-color:lightgray; "  onclick="document.getElementById('clear_button').click();"  >
				<!to link gia to Μέσω ΤΚ einai apenergopoihmeno>	
				<a href="byZip.php" id="byZip_button" style="font-size: 22px;text-align: center;padding-top: 20px;padding-bottom: 30px;" onmousedown="document.getElementById('clear_button').click();" >Μέσω <br> Τ.Κ.</a>
				</td>
				<script>
					document.getElementById("tk").style.backgroundColor = "Gray";
				</script>
			</tr>
			<tr></tr>
			<tr></tr>
		</table>
	</td>
	<td id="td_pedia">
	 <table id="table_pedia">	
		<tr style="height:60px">
			<td class="label">Τ.Κ.</td>
			<td class="wideField" id="tk_td" style="text-align: left;" colspan="2">
				<!input class="field" id="postal_code" name="postal_code" type="text" enabled placeholder=" Πληκτρολόγησε τον Ταχυδρομικό κώδικα" type="text"><!/input>
				<input class="field" id="postal_code" name="postal_code" placeholder="Πληκτρολόγησε τον Ταχυδρομικό κώδικα" onchange="document.getElementById('select_tk').click();" 
					   onclick="document.getElementById('clear_button').click();" type="text" value="<?php if (isset  ($_SESSION['postal_code'])) {echo $_SESSION['postal_code'];}?>" enabled required></input> <!onchange="getTK()" >
				 <script>
					document.getElementById("postal_code").focus();
					document.styleSheets[0].insertRule('#autocomplete::-webkit-input-placeholder { font-size: 21px; }', 0);
					document.styleSheets[0].insertRule('#autocomplete::-moz-placeholder { font-size: 20px; }', 0); 
				</script>
				<?php 
				
				if (!empty($_SESSION['postal_code'])){?>
				<script>
					//document.getElementById("postal_code").disabled = true;
					document.getElementById("nomos").disabled = false;
				</script>	
				<?php
					}
				else{ 
				$_SESSION['postal_code']=""; }
				?>			
				<!pairnw ton Taxudromiko Kwdika>	
				<script> 
				function getTK(){
					var local = document.getElementById("postal_code");
					document.getElementById("value_tk").value = local;
					document.getElementById("nomos").disabled=false;
					document.getElementById("nomos").focus();
					document.getElementById('select_tk').click();
			 		//initMap();
				}
				</script>
		 	</td>
		 	<td style="text-align: center;"><input type=submit name='drop_down_tk' value="OK" id="select_tk"  class="ok_button" onclick="click_ok()"></td>
			<td><input id="value_tk" name="value_tk" value="<?php if (isset  ($_SESSION['postal_code'])) {echo $_SESSION['postal_code'];}?>" ></td>	
			<!scriptaki gia press enter button>
			<script>
			function click_ok(){
				document.getElementById('value_tk').value=document.getElementById('postal_code').value;
				document.getElementById('postal_code').value=document.getElementById('value_tk').value;
				//document.getElementById('tk').disabled=true;
			}	
				var focused_id = document.activeElement.id;
				//to parakatw den xreiazetai kan,an bgei se sxolio to script gia apenergopoihsh tou enter paizei aytomata to ok button me to enter!
			/*	if(focused_id == document.getElementById("postal_code")){
				//me to patima toy enter na pairnei tn TK
		  		$("input").keypress(function(event){
            		if(event.keyCode == 13 || event.keyCode == 9) {
					$("#select_tk").click();
            		}
		  			}); 
				} */
			</script>
	  	</tr>
		<tr style="height:60px">
			<td class="label">Νομός</td>
        	<!td class="wideField" style="text-align: left; " >
			<!Lista me tous nomous tis Elladas ws drop down list>
		 	<!input class="field" id="administrative_area_level_3"  name="administrative_area_level_3" disabled="true"><!/input>
			<td class="wideField" style="text-align:left; ">
				<?php
				//pairnw to nomo tou sugkekrimenou tk apo tin basi mas
				if (isset  ($_SESSION['postal_code'])){	
				$tk = $_SESSION['postal_code'];
				} 	
				if($stmt1 = $mysqli->prepare("SELECT DISTINCT nomos FROM greek_localities where tk=?")){
					$stmt1->bind_param('i', $tk_s);
					$tk_s = $tk;
					$stmt1->execute();
					$stmt1->bind_result($nomos);
					$stmt1->store_result();
					//echo "<select name='nomos' id='nomos' onchange='getNomo()' style='text-align:left; max-width:300px;min-width:300px;' disabled='true';" ?>
					<input  id="nomos" name="nomos" onload='getNomos();' disabled='true' style="max-width: 290px;min-width: 290px;" value="<?php if (!empty($_SESSION['postal_code']) && $stmt1->num_rows == 0) {$_SESSION['error']='ΔΕΝ ΒΡΕΘΗΚΕ!'; echo 'ΔΕΝ ΒΡΕΘΗΚΕ!';}
					if($stmt1->fetch()){$_SESSION['state']=$nomos; echo $nomos;}?>"></input>
					<?php 
					if ($stmt1->num_rows < 1){ 
					$_SESSION['postal_code_empty'] = "";?>
					<script> 
						document.getElementById('value_tk').value="ΔΕΝ ΒΡΕΘΗΚΑΝ ΕΓΓΡΑΦΕΣ!";
						document.getElementById("poctal_code").value = "ΔΕΝ ΒΡΕΘΗΚΑΝ ΕΓΓΡΑΦΕΣ!";
					</script>
					<?php	}
				}
				if (isset($nomos)){?>
				<script> 
					document.getElementById("nomos").disabled = true;
					document.getElementById("perioxi").disabled = true;
				</script>	
				<?php
				} 		
				
			if(isset ($_SESSION['error'])){
				session_destroy();
				echo("<meta http-equiv='refresh' content='3'>");
 			}
			?>
			</td>
			<!scriptaki gia na parw ton Nomo>	
			<script> 
				function getNomos(){
					var state = document.getElementById("nomos");
					document.getElementById("value_nomos").value = state;
					document.getElementById("locality").focus();
					document.getElementById('select_nomo').click();
				}
			</script>
			<td><input id="value_nomos" name="value_nomos" value="<?php if (isset  ($_SESSION['state'])) {echo $_SESSION['state'];}?>" ></td>	
			<td><input type=submit name='drop_down_nomos' value="select_nomo" id="select_nomo"></td>	
      </tr>
	  <tr style="height:60px">
       	<td class="label">Χώρα</td>
        <td class="wideField" style="text-align:left; "><!input class="field" id="country"  name="country" disabled="true"><!/input>
			<select name="country" id="country" style="max-width: 300px;min-width: 300px;" disabled>
			<option value="Ελλάδα"><i>Ελλάδα</i></option>
			<option value="Άλλη χώρα">Άλλη χώρα</option>
			<script>document.getElementById("country").style.opacity="0.7";</script>
		</td>
		<td id="session_tk">
		  	<?php
			if (isset  ($_SESSION['postal_code'])){	
			echo $_SESSION['postal_code'];
			} ?>
		</td>	
		<td id="session_nomos">
		  	<?php
			if (isset  ($_SESSION['state'])){	
			echo $_SESSION['state'];
			} ?>
		</td>	
      </tr>
      <tr style="height:60px">
        <td class="label">Περιοχή</td>
        <!td class="wideField" >
		<!input class="field" id="locality" name="locality" disabled="true"><!/input>
		<!input id="autocomplete" name="autocomplete" placeholder=" Πληκτρολόγησε την περιοχή" onFocus="geolocate()" type="text"><!/input>
		<td class="wideField" colspan="1" id="locality_td" style="text-align:left; max-width:300px;min-width:300px;" disabled="true">
			<!input class="field" id="locality" name="locality" ><!/input>
				<!input id="autocomplete" name="autocomplete" placeholder="Πληκτρολόγησε την περιοχή" onFocus="geolocate()" type="text" ><!/input> <!required>
			<p class="bootstrap">
			<?php
			//pairnw tis perioxes tou sugkekrimenou tk apo tin basi mas
			if (isset  ($_SESSION['postal_code'])){	
			$tk = $_SESSION['postal_code'];
			} 	
			if($stmt2 = $mysqli->prepare("SELECT DISTINCT perioxi FROM greek_localities where tk=? GROUP BY perioxi ASC")){
				$stmt2->bind_param('i', $tk_s);
				$tk_s = $tk;
				$stmt2->execute();
				$stmt2->bind_result($perioxi);
				$stmt2->store_result();
				echo "<select name='locality' id='locality' onchange='getPerioxi()' style='text-align:left; max-width:300px;min-width:300px;' disabled='false';  data-live-search='true' data-live-search-style='startsWith' class='selectpicker'>" ?>
				<p><?php echo '<option value= ></option>'; ?></p>
				<!opoio pedio den einai enabled na fainetai axno!>
				<?php if (empty  ($_SESSION['postal_code'])){?>
				<script>document.getElementById("locality").style.opacity="0.5";document.getElementById("nomos").style.opacity="0.5";</script>
				<?php
				}
				while($stmt2->fetch()){?>
					<p><?php echo '<option value='.$perioxi.'>'.$perioxi.'</option>'; ?></p>
				<?php }
				echo "</select>"; 
				$stmt2 -> fetch();
			}
			if (isset($_SESSION['state'])){?>
			<script> 
				document.getElementById("locality").disabled = false;
			</script>	
			<?php
				} 		
			?>
			</p>
		 		<!krataw tin epilegmeni perioxi>
				<script>
				document.getElementById("locality").focus();
				$(function() {
					if (localStorage.getItem('locality')) {
						$("#locality option").eq(localStorage.getItem('locality')).prop('selected', true);
					}
					$("#locality").on('change', function() {
						localStorage.setItem('locality', $('option:selected', this).index());
					});
				});
				</script>
	
				<script>			
				//$("input#locality").val(filterby).trigger('keyup'); 
					var Narrower = (function ( window, document, undefined ) {
					
					function Narrower( arr ) {
						this.arr  = arr || []
					}

					Narrower.prototype.update = function ( str ) {
						var rgxp, results

						// optimization
						if ( '' === str ) {
							return this.arr
						}
						else {
							// create regular expression
							rgxp = new RegExp( str, 'i' ) // todo: make Unicode-safe once ES6 is widely adopted

							results = this.arr.filter(function ( val ) {
								return null !== val.match( rgxp )
							})

							return results.sort()
						}
					}

					return Narrower

}).call( this, this, this.document )
				</script>
	
				<!pairnw tin Perioxi>	
				<script> 
				function getPerioxi(){
					var local = document.getElementById("locality");
					var strLocality = local.options[local.selectedIndex].text;
					document.getElementById("value_perioxi").value = strLocality;
					document.getElementById("route").focus();
					document.getElementById('select_perioxi').click();
					//den leitoygoun ta parakatw dioti ginetai refresh stin selida ara xanetai o xartis!
			 		//initMap();
					//document.getElementById("map_button").click();
				}
				</script>
		</td>
		<td><input id="value_perioxi" name="value_perioxi" value="<?php if (isset  ($_SESSION['locality'])) {echo $_SESSION['locality'];}?>" ></td>	
		<td><input  id="select_perioxi" type=submit name='drop_down_perioxi' value="select_perioxi" ></td>  
		<!an uparxei mono 1 perioxi proepilekse tin>
		<?php
			if ($stmt2->num_rows == 1 && (isset($_SESSION['state'])) && (empty($_SESSION['locality'])) ){ ?>
				<script> 
						var lastValue = $('#locality option:last-child').val();
						document.getElementById("locality").value = lastValue;
						document.getElementById("value_perioxi").value = lastValue;
						document.getElementById("select_perioxi").click();
						
						localStorage.setItem('locality', $('option:selected', this).index());
						document.getElementById("locality_td").disabled=true;
						document.getElementById("locality_td").enabled=false;
						//setRoute();
				</script> 
			<?php } ?>
      </tr>
      <tr style="height:60px">
        <td class="label">Οδός</td>
        <td class="wideField">
			<!input class="field" id="route" name="route"><!/input>
			<input class="field" id="route" name="route" placeholder="Πληκτρολόγησε την οδό" style="max-width: 298px;" onchange="setRoute();fillInAddress2()" onsubmit="fillInAddress2()" onFocus="initMap();" onclick="initMap();" type="text" disabled="true"></input>
	
			<!focus sto pedio dieythinsi kai o cursor stin arxi>
			<script>
			if(document.getElementById("value_perioxi").value !="" ){
				document.getElementById("route").focus();
			}	
			/*var focused_id = document.activeElement.id;
			if (focused_id == document.getElementById("route")){
				initMap();
			}*/
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
			</script>
		</td>
	<td class="label"><p style=""><b>Αριθμός</b></p></td>
	    <td class="slimField"><input class="field" id="street_number" name="street_number" style="max-width: 94%;text-align: left;" disabled="true"></input></td>
		<td></td>
		<td></td> 
      </tr>
	  <tr style="height:30px">
		<td><input id="visible_map" style="max-width:20px;min-width:10px;" value="1";/></td>
		<td><input id="submit" type="button" value="Geocode"></td>
		<script> document.getElementById("visible_map").style.display='none';</script>
		<!boithitiko pedio gia emfanisi ston xarti kathe fora poy epilegw nomo, perioxi kai TK>
		  <td class="wideField" id="autocomplete_test_td">
			<input class="field" id="address" type="textbox" value="<?php 
																	
																	if (isset  ($_SESSION['state']) && isset ($_SESSION['locality']) && isset ($_SESSION['postal_code'])) 
																			{echo $_SESSION['locality']. "," . $_SESSION['postal_code'];} 
																	else if (isset  ($_SESSION['state']) && isset ($_SESSION['locality'])) {echo $_SESSION['locality']. "," .$_SESSION['state'];}
																	else if (isset  ($_SESSION['state']) && empty ($_SESSION['locality'])) {echo $_SESSION['state'];}
																	?>"  onclick="initMapMarker();document.getElementById('route').focus();" type="text"></input>  
			<script> 
				document.getElementById("visible_map").style.display='none';
				document.styleSheets[0].insertRule('#autocomplete::-webkit-input-placeholder { font-size: 21px; }', 0);
			</script>	
		<td id="session_perioxi">
		  	<?php
			if (isset  ($_SESSION['locality'])){	
			echo $_SESSION['locality'];
			} ?>
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
			<button id="clear_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="clear all" onclick="	$('#nomos option:selected').remove(); localStorage.removeItem('nomos');localStorage.removeItem('locality');localStorage.removeItem('postal_code');" method="post"> 
				<img src="icons/delete.png"  class="button" style="height:45px;margin-right: 0px;"  />
			</button>
			<button id="cancel_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="exit" method="post"  
				onclick= "$('#nomos option:selected').remove(); localStorage.removeItem('nomos');localStorage.removeItem('locality');localStorage.removeItem('postal_code');
						  return confirm('Πάτησε οκ αν θες έξοδο αλλίως πάτησε Ακύρωση'); "> 
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
  				<img src="icons/save.png"  class="button" style="height:45px;margin-right:4px;"/>
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
		  <i id ="cancel_text"  style="font-size: 20px;vertical-align:top;padding-top: 0px;margin-left: 15.5px; ">cancel</i>
		</td>
		 <script>document.getElementById('clear_text').style.display='none';</script>
		<td style="padding-right:18px;"><i style="font-size: 20px;vertical-align:top;margin-right:4px;">save</i></td>
	  </tr>
	</table>
	</td>
  </table>
	  <?php if (isset($_SESSION['state']) && isset($_SESSION['locality'])&& isset($_SESSION['postal_code'])){ ?>
		<!scriptaki energopoihsh odou>	 
		<script> 
		setRoute();
		 function setRoute(){ 
			  document.getElementById("route").disabled = false;
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
		} 
			
		</script>
		<?php } ?>



<!scriptaki gia na min fainontai ta boithitika pedia>
<script>	  
	document.getElementById("session_nomos").style.display="none";
	document.getElementById("value_nomos").style.display="none";
	document.getElementById("select_nomo").style.display="none";
	document.getElementById("value_perioxi").style.display="none";
	document.getElementById("select_perioxi").style.display="none";
	document.getElementById("session_perioxi").style.display="none";
	document.getElementById("value_tk").style.display="none";
	document.getElementById("session_tk").style.display="none";
	document.getElementById("submit").style.display="none";
	document.getElementById("address").style.display="none";
	document.getElementById("autocomplete_test_td").style.display="none"; 	
</script>

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
</div>
</td>
<!br>

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
		
		  //me to patima toy enter na ginetai save
	/*	  $("input").keypress(function(event){
            if(event.keyCode == 13 || event.keyCode == 9) {
				 $("#save_button").click();
            }
		  }); 	*/

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
									document.getElementById("route").value=array_final[0];
									var number =  array_final[1];
									if(number<=1000){document.getElementById("street_number").value=number;} //gia na min pairnei ton TK ws arithmo
								}
								else{ //diaforetika prokeitai gia odo me 2 lekseis
									document.getElementById("route").value=	document.getElementById("route").value+array_final[1];
									document.getElementById("street_number").value="";
								}
								//an den exei arithmo
								if( array_final[0] == null ) {
									document.getElementById("route").value="";
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
								if(last_element<=1000){document.getElementById("street_number").value=last_element;} //gia na min pairnei ton TK ws arithmo
							}
							else{ //diaforetika prokeita gia odo me 2 lekseis kai panw
								document.getElementById("route").value=addressAndnumber;
							}	

						}
		  document.getElementById("save_button").focus();
      } 

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
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 40.5, lng: 22.2},
          zoom: 5
        });
		 
        var card = document.getElementById('pac-card');
        var input = document.getElementById('route');
        var types = document.getElementById('type-selector'); 
        //var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
		 
		 //edw anoigei drop down kai thelei ksana klik!!!
        var autocomplete =  new google.maps.places.Autocomplete(input);
		  
		  // Set initial restrict for greece
        autocomplete.setComponentRestrictions({'country': 'gr'});
		  
		//me to patima to enter na apeikonizetai h 1h epilogh aytomata! //eixa prosthesei kai gia mouseover: $("input").mousedown(function(event){...
		 //if(focused_id == document.getElementById("route")){ 
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
		 //}
	  
        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map); //
		  
		//Restrict the search to the bounds  
		//autocomplete.setOptions({strictBounds: true})
		 
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
			map: map,//,
			draggable: true,
			title:"Μετακίνησέ με!"
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
					document.getElementById("route").disabled = false;
		  			document.getElementById("street_number").disabled = false;
				} else {
				  window.alert('No results found');
				}
			  } else {
				window.alert('Geocoder failed due to: ' + status);
			  }
			});
			//document.getElementById("postal_code").disabled = false;
			document.getElementById("route").disabled = false;
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
		/*  document.getElementById('use-strict-bounds')=
		  
		  document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked!' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            }); */
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
			}
            resultsMap.panTo(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
			//resultsMap.setCenter(results[0].geometry.location);
			google.maps.event.addListener(marker, 'click', function(event) {
				var iwindow = new google.maps.InfoWindow();
				iwindow.setContent(results[0].formatted_address);
				iwindow.open(resultsMap, this);
				//apothikevontas kai tis suntetagmenes- Xreiazetai click sto stigma	  
				//document.getElementById("latitude").setAttribute('value',event.latLng.lat()); 
				//document.getElementById('langitude').setAttribute('value',event.latLng.lng());  
			}); 
			  	//trigger to clickarisma toy stigmatos
			  	google.maps.event.trigger( marker, 'click' );
			  	//apothikevontas kai tis suntetagmenes
				document.getElementById("latitude").setAttribute('value',marker.getPosition().lat()); 
				document.getElementById('langitude').setAttribute('value',marker.getPosition().lng());   
          } else {
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