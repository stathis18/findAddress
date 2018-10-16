<!DOCTYPE html>
<html>
  <head>
    <title>Εύρεση Διέθυνσης Mέσω Google</title>
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
  </head>

<body onload="initMap();"> <!gia na fortwnetai o xartis automata!>
<br>
<?php
	session_start();
	$_SESSION['save_by']='address';
	//$_SESSION['warning']="";
?>
<table cellpadding:"0">
<!emfanisi formas>	
<form id="address_form" action="save_data.php" method="POST">	
<td id="td_form" valign="top" style="text-align: left">			
<!ta stoixeia dieuthinsis emfanizontai sto aristero meros tis othonis>
<div class="address_div" >	     			
    <table id="table_address">
	<td id="td_menu" style="min-width: 80px;max-width: 130px;">	
		<table id="table_menu" cellpadding:"0" border="0" style="min-width: 80px;max-width: 210px;min-height: 360px;">
			<tr>
				<td class="menu" id="google" style=" text-align: center;  background-color:lightgray;" >
					<a href="byAddress.php" id="google_text" style="font-size: 22px;text-align: center; padding-top: 20px;padding-bottom: 30px;">Μέσω Διεύθυνσης</a>
					<script>document.getElementById("google_text").style.backgroundColor = "Gray";</script>
				</td>
				<td class="border-side-rows" rowspan="7" style="max-width: 2px;min-width:2px;height: 100%;"></td>
			</tr>
			<tr></tr>
			<tr>
				<td class="menu" id="elta" style="text-align: center;  background-color:lightgray; "> <!opacity: 0.3;>
				<!to link gia to Μέσω Νομού einai apenergopoihmeno>	
					<a href="byState.php"  style="font-size: 22px;text-align: center;padding-top: 20px;padding-bottom: 30px;">Μέσω Νομού</a>
				</td>	
			</tr>	
			<tr style="min-height:50px;max-height: 50px;"></tr>
			<tr>
				<td class="menu" id="tk" style="text-align: center;  background-color:lightgray; "> <!opacity: 0.3;>
				<!to link gia to Μέσω ΤΚ einai apenergopoihmeno>	
					<a href="byZip.php"  style="font-size: 22px;text-align: center;padding-top: 20px;padding-bottom: 30px;">Μέσω <br> Τ.Κ.</a>
				</td>
			</tr>
			<tr></tr>
			<tr></tr>
		</table>
	</td>
	<td id="td_pedia">
	 <table id="table_pedia">	
	  <tr style="height:60px;">
		<td class="wideField" style="text-align: left;" colspan="4">	
      	<input id="autocomplete" placeholder="Πληκτρολόγησε: Οδό αριθμό, Περιοχή, Χώρα" onFocus="geolocate();" type="text" ondblclick="document.getElementById('clear_button').click()"/>
		<script>
			document.getElementById("autocomplete").focus();
			document.styleSheets[0].insertRule('#autocomplete::-webkit-input-placeholder { font-size: 21px; }', 0);
		</script>
		</td>
		<td></td>
		<td></td>
		<td></td>
      </tr>
      <tr style="height:60px">
        <td class="label">Οδός</td>
        <td class="wideField" ><input class="field" id="route" name="route" disabled="true" readonly/></td>
	    <td class="label">Αριθμός</td>
	    <td class="slimField" ><input class="field" id="street_number" name="street_number" disabled="true" readonly/></td>	
      </tr>
      <tr style="height:60px">
        <td class="label">Περιοχή</td>
        <td class="wideField" colspan="1"><input class="field" id="locality" name="locality"  disabled="true" readonly/></td>
		<td></td>
		<td><input id="visible_map" style="max-width:20px;min-width:10px;" value="1";/></td>
			<script> document.getElementById("visible_map").style.display='none';</script>
      </tr>
      <tr style="height:60px">
		<td class="label">Νομός</td>
        <td class="wideField" style="text-align: left;"><input class="field" id="administrative_area_level_3"  name="administrative_area_level_3" disabled="true"readonly/></td>
		<td class="label">Τ.Κ.</td>
        <td class="slimField"><input class="field" id="postal_code" name="postal_code" disabled="true" readonly/></td>
      </tr>
      <tr style="height:60px">	
        <td class="label">Χώρα</td>
        <td class="wideField" colspan="1"><input class="field" id="country"  name="country" disabled="true" readonly/></td>
		<td></td>
		<td></td>
      </tr>
	  <!pedio invisible gia to eksoteriko anti nomou>
	  <tr style="height:30px">
		<td class="label"></td> <!Perioxi gia to eksoteriko>
        <td class="wideField" colspan="1"><input class="field" id="administrative_area_level_1" name="administrative_area_level_1"  disabled="true"></input></td>
			<script> document.getElementById("administrative_area_level_1").style.display='none';</script>
		<td></td>
		<td></td>
	  </tr>
	  <tr style="height:60px;padding-bottom: 0px;">	
		<td></td>
		<td style="vertical-align:bottom;">
		   <!input type="image" src="icons/map_marker.png" class="button" value="map marker" onclick="initMap();" style="width: auto"/>
		<div class="container">
		  <img src="icons/map_marker.png"  id="map_button" class="button" alt="map_marker" style="width: 60px;margin-right: 1px; " onclick="showHide();"
			   style="width: 60px;">
			<script>document.getElementById('map_button').style.display='none';</script>
			<!div class="middle">
    			<!div class="hover_text" style="margin-left: 5px;"><!map/div>
			  </div>
		</div>
		</td>
		<td style="vertical-align:bottom;"><div class="container">
		  <!input class="button" name="action" value="clear all" type="submit"  onclick="" method="post"/>
		<button id="clear_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="clear all" method="post"> 
  			<img src="icons/delete.png" id="delete_button"  class="button" style="height:45px;"/>
		</button>
		<button id="cancel_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="exit" method="post"  
				onclick= "return confirm('Πάτησε οκ αν θες έξοδο αλλίως πάτησε Ακύρωση'); "> 
  			<img src="icons/cancel.png" id="cancel_button"  class="button" style="height:45px;"/>
		</button>	
			<?php	/*
				if(isset ($_POST['action'])){
				if ($_POST['action'] == 'exit') {
    			echo "<script>window.close();</script>";
			}}*/
			?>
			<script>document.getElementById('clear_button').style.display='none';</script>
			<div class="middle">
    			<!div class="hover_text" ><!Clear/div>
			  </div>
			</div>
		</td> 
		<td style="vertical-align:bottom;"><div class="container">
			<!input id="save_button" class="button" name="action" value="save" type="submit" onclick="" method="post"/>
			<button id="save_button" type="submit" style="background-color:transparent; border-color:transparent;" name="action" value="save" method="post"> 
  				<img src="icons/save.png"  class="button" style="height:45px;"/>
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
		  <i id ="cancel_text"  style="font-size: 20px;vertical-align:top;padding-top: 0px;margin-right: ">cancel</i>
		</td>
		 <script>document.getElementById('clear_text').style.display='none';</script>
		<td style="padding-right:18px;"><i style="font-size: 20px;vertical-align:top;padding-top: 0px;">save</i></td>
	  </tr>
	</table>
	</td>
  </table>
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
	document.getElementById("autocomplete").focus();
}
</script>

<!scriptaki gia press enter button>
<script>
	//apenergopoihsh tou default enter button wste me tin epilogh kapoias dieuthinsis na sumplirwnontai aytomata ta pedia!
	window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
</script>

<!me to patima toy pontikiou na gemizoun ta pedia - PROSPATHEIA>
<script>
	//document.getElementById("autocomplete").attachEvent('onclick', function() { fillInAddress();});
	document.getElementById("autocomplete").addEventListener("click", fillInAddress();); //paizei alla thelei kai allo click
	//document.getElementById("autocomplete").addEventListener('mousedown', function(e){fillInAddress();}, true);
			
	//if(document.getElementById("locality").value == ""){ //diaforetika anairei to scriptaki gia tin odo!
		//document.getElementById("autocomplete").addEventListener('mousedown',function(e){
		//		initAutocomplete();
				//},true);
	//}
</script>
</div>
</td>
<!br>

<!scriptaki gia xarti>
<script>
	//document.getElementById('map').style.display='block';
	//document.getElementById('map_button').click();
	//initMap();
</script>	
	
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
<!emfanisi autocomplete search: https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete#try-it-yourself>
<!emfanhsh xarti me to place autocomplete: https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete#try-it-yourself>

<!scriptaki gia autocomplete pediwn>
    <script>
      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_3: 'short_name',
        country: 'long_name',
        postal_code: 'short_name',
		administrative_area_level_1: 'short_name' //gia to eksoteriko
      };

      function initAutocomplete() {
		//prohgoymeni prospatheia xwris options sto search
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')), //HTMLInputElement
            {types: ['geocode']}); //tupos ws dieuthinsi?
        autocomplete.addListener('place_changed', fillInAddress);
		 
	  };
		  
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
			var country = document.getElementById("country").value;
		  //an einai stin Ellada	
		  if(country=="Ελλάδα"){
		  	/****se orismenes perioxes to administrative_area_level_3 den antistoixei se nomo* ARXH ****/
			var administrative_area = document.getElementById('administrative_area_level_3').value;
		  	//gia ton nomo Attikis giati einai xwrismenos se tomeis
			if(administrative_area.includes("Αθηνών")|| administrative_area.includes("Αττική") || administrative_area.includes("Νήσοι")){
				document.getElementById('administrative_area_level_3').value="Αττική";
			}
		  	//gia Kyklades
		  	else if (administrative_area.includes("Νάξος")|| administrative_area.includes("Άνδρος") || administrative_area.includes("Πάρος")|| administrative_area.includes("Άνδρος") || administrative_area.includes("Μήλος")|| administrative_area.includes("Κέα") || administrative_area.includes("Αμοργός")|| administrative_area.includes("Ίος") || administrative_area.includes("Κύθνος")|| administrative_area.includes("Μύκονος") || administrative_area.includes("Σύρος")|| administrative_area.includes("Σαντορίνη") || administrative_area.includes("Σέριφος")|| administrative_area.includes("Σίφνος") || administrative_area.includes("Σίκινος")|| administrative_area.includes("Ανάφη") || administrative_area.includes("Κίμωλος")|| administrative_area.includes("Φολέγανδρος") || administrative_area.includes("Μακρόνησος")|| administrative_area.includes("Ηρακλειά") || administrative_area.includes("Θηρασία")|| administrative_area.includes("Σχοινούσα")|| administrative_area.includes("Κουφονήσι")){
				document.getElementById('administrative_area_level_3').value="Κυκλάδες";
			}
		  	//gia Dwdekanisa
		  	else if (administrative_area.includes("Ρόδος")|| administrative_area.includes("Κάρπαθος") || administrative_area.includes("Κάλυμνος")|| administrative_area.includes("Αστυπάλαια") || administrative_area.includes("Κάσος")|| administrative_area.includes("Τήλος") || administrative_area.includes("Σύμη")|| administrative_area.includes("Λέρος") || administrative_area.includes("Πάτμος")|| administrative_area.includes("Χάλκη")|| administrative_area.includes("Λειψοί")|| administrative_area.includes("Αγαθονήσι") || administrative_area.includes("Καστελλόριζο")){
				document.getElementById('administrative_area_level_3').value="Δωδεκάνησα";
			}
		   //gia Thaso
		   else if(administrative_area.includes("Θάσος")){
				document.getElementById('administrative_area_level_3').value="Καβάλα";
			}
		    //gia Limno
		  	else if (administrative_area.includes("Λήμνο")){
				document.getElementById('administrative_area_level_3').value="Λέσβος";
			}
		    //gia Ikaria
		  	else if (administrative_area.includes("Ικαρία")){
				document.getElementById('administrative_area_level_3').value="Σάμος";
			}
		  	//gia Bories Sporades
		  	else if (administrative_area.includes("Σποράδες")){
				document.getElementById('administrative_area_level_3').value="Μαγνησία";
			}
		  	/****se orismenes perioxes to administrative_area_level_3 den antistoixei se nomo* TELOS ****/
		  }
			//an einai eksoteriko TK kai perioxi mporei na einai agnwstes, enw anti nomou exoun to administrative_area_level_1  (politeies)
		  else{
				if (document.getElementById("administrative_area_level_3").value == ""){
					document.getElementById("administrative_area_level_3").value = document.getElementById("administrative_area_level_1").value;
				}
				if (document.getElementById("postal_code").value == ""){
					document.getElementById("postal_code").value = " ";
				}
				if (document.getElementById("locality").value == ""){
					document.getElementById("locality").value = " ";
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
		//document.getElementById("autocomplete").focus();
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 38.5, lng: 24},
          zoom: 6
        });
		 
        var card = document.getElementById('pac-card'); //
        var input = document.getElementById('autocomplete');
        var types = document.getElementById('type-selector'); //
        //var strictBounds = document.getElementById('strict-bounds-selector'); //

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
		 
		//edw anoigei drop down kai thelei ksana klik!
        var autocomplete =  new google.maps.places.Autocomplete(input);
		 
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
		 //me to click apeikonizeitai h epilogh 
		 $("input").mousedown(function(event){
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
	  
		/* //strict-bounds
        // Bind the map's bounds (viewport) property to the autocomplete object
        autocomplete.bindTo('bounds', map); //
		//Restrict the search to the bounds  
		autocomplete.setOptions({strictBounds: true}) */
		 
        var infowindow = new google.maps.InfoWindow({ maxWidth: 250 });
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
		  animation: google.maps.Animation.DROP, //prothiki animation stin emfanisi tou stigmatos
		  draggable: true,
		  title:"Μετακίνησέ με!"
        });
		marker.addListener('click', toggleBounce); //prothiki animation kata to patima tou stigmatos

		function toggleBounce() {
		  if (marker.getAnimation() !== null) {
			marker.setAnimation(null);
		  } else {
			marker.setAnimation(google.maps.Animation.BOUNCE);
		  }
		}
		 
		/*gia to metakinisimo stigma!** Start **/ 
		//otan stamatisei to drag tou stimgatos
		google.maps.event.addListener(marker, 'dragend', function (evt) {
		//document.getElementById('coordinates').innerHTML = '<p>Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) + '</p>';
		document.getElementById("latitude").setAttribute('value',evt.latLng.lat()); //get the latitude=gewgrafiko platos
		document.getElementById("langitude").setAttribute('value',evt.latLng.lng()); //get the langitude=gewgrafiko mikos
		var latitude_new = document.getElementById("latitude").value;
		var langitude_new = document.getElementById("langitude").value;
		
		//fere to kainourgio meros meta tin metakinisi toy stigmatos!
		  initMapNew();
				
		//thelw na allazei me basi twn kainourgiwn suntetagmenwn to autocomplete text kai to infowindow
		function initMapNew() {	
			var  map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 18,
			  center: new google.maps.LatLng(latitude_new, langitude_new)
			});

			var latAndLang = latitude_new+ ',' +langitude_new;	
			document.getElementById("latlng").setAttribute('value',latAndLang); //gia na dw an pairnw tis nees suntetagmenes
			var geocoder = new google.maps.Geocoder;
			var infowindow = new google.maps.InfoWindow({ maxWidth: 250 });
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
					document.getElementById("autocomplete").value=  infowindow.getContent(results[0].formatted_address);

					//spaw to autocomplete field (input)
					var input = document.getElementById("autocomplete").value;
					var myarray = input.split(",");
					
					var country = document.getElementById("country").value;
					if(country=="Ελλάδα"){
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
							var perioxi = array_final1[1];
							var postal_code = array_final1[2] + " " + array_final1[3];
						}
						//an h perioxi apoteleitai apo 2 lekseis
						else{
							var perioxi = array_final1[1] + " " + array_final1[2];
							var postal_code = array_final1[3]+ " " + array_final1[4];
						}
						document.getElementById("postal_code").value=postal_code;
						document.getElementById("locality").value=perioxi;
					}
					//kathe xwra exei diaforetiki xrisi twn stoixeiwn tis dieythinsis, giauto kai de ginetai stin allagi stigmaton na exoun koini antimetwmpisi
					//gia Kypro
					else if(country=="Κύπρος"){ //
						var address =  myarray[0];
						document.getElementById("route").value=address;
						var perioxi = myarray[1];
						document.getElementById("locality").value=perioxi;
					}
					//gia Italia
					else if(country=="Ιταλία"){ // 
						var address =  myarray[0];
						document.getElementById("route").value=address;
						var array2 = myarray[1].split(",");
						var street_number = myarray[1];
						document.getElementById("street_number").value=street_number;
						var array3 = myarray[2].split(" ");
						var postal_code = array3[1];
						document.getElementById("postal_code").value=postal_code;
						var perioxi = array3[2];
						document.getElementById("locality").value=perioxi;
						var nomos = array3[3];
						document.getElementById("administrative_area_level_3").value=nomos;
					}
					//gia ameriki
					else if(country=="Ηνωμένες Πολιτείες"){ 
						var addressAndnumber =  myarray[0];
						var array1 = addressAndnumber.split(" ");
						var isnum = /^\d/.test(array1[0]); //elegxos an einai arithmos to 2o stoixeio
						if(isnum){
							var street_number = array1[0];
							document.getElementById("street_number").value=street_number;
							var route = array1[1];
							if( array1[2] != null ) {
								var route = array1[1] + " " + array1[2];
							}
							if( array1[3] != null ) {
								var route = array1[1] + " " + array1[2] + " " +array1[3];
							}
							if( array1[4] != null ) {
								var route = array1[1] + " " + array1[2] + " " +array1[3]+ " " +array1[4];
							}
							document.getElementById("route").value=route;
						}
						else{
							var route = array1[0];
							if( array1[1] != null ) {
								var route = array1[0] + " " + array1[1];
							}
							if( array1[2] != null ) {
								var route = array1[0] + " " + array1[1] + " " +array1[2];
							}
							document.getElementById("route").value=route;
						}
						var perioxi = myarray[1];
						document.getElementById("locality").value=perioxi;
						var stateAndTK = myarray[2];
						var array2 = stateAndTK.split(" ");
						var state = array2[1];
						document.getElementById("administrative_area_level_3").value=state;
						var postal_code = array2[2];
						document.getElementById("postal_code").value=postal_code;
					}
					//merikes fores den fairnei stin forma ton nomο kai tin xwra, tote thelw na ta sumplirwnei-DEN LEITOYRGEI!
					if(document.getElementById("country").value == null){
						var country= array1[1]; //to telautaio tmima einai i xwra
						document.getElementById("country").value=country;
					}
					if(document.getElementById("administrative_area_level_3").value == null){
						document.getElementById("administrative_area_level_3").value=" ";
					}
				} else {
				  window.alert('No results found');
				}
			  } else {
				window.alert('Geocoder failed due to: ' + status);
			  }
			});
      	  }
			document.getElementById('save_button').focus();
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
          marker.setVisible(true);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
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
			
		  //gia emfanisi toy TK ston xarti 	
		  var postal_code = document.getElementById('postal_code').value;
			
          infowindowContent.children['place-icon'].src = place.icon;
          //infowindowContent.children['place-name'].textContent = place.name;
          //infowindowContent.children['place-address'].textContent = address;
		  //infowindowContent.children['place-name'].textContent = postal_code; //emfanisi tou TK
		  infowindowContent.children['place-address'].textContent = place.formatted_address;
          infowindow.open(map, marker);
			
		  //emfanish suntatagmenwn
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
		  
		 /* //strict-bounds
        document.getElementById('use-strict-bounds')=
		  
		  document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });*/
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

	<!script gia to localization>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8DQSfGhzpEa0ngRzPLTctoxukF9PvLX0&region=GR"></script>
	
	<!script gia to geocode reverse>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDysySs8ogleetc3DgjVLup6KesWQHA7mI&callback=initMap">

  </body>
</html>