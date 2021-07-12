                                                                                                                                       <?php
/**
Die Datei entsteht, da ich mich mit den Ingredenzien "verzettelt" habe.

Ich benötige reine unverarbeitete Lebensmittel.

Bei den Ingredenzien habe ich aber Komponenten die bereits bearbeitet sind.

Bspw. Wirsingroulade, Boulette oder Cordon Bleu
Ich habe zwar zwischen Ingedenzie und Speisekomponenten unterschieden. 
Aber mir fehlt da der rote Faden.


Einerseits ist klar, dass die Anwenung einen Speiseplan eine Anregung für eine ausgewogene Ernährung werden soll,
mit der man besser planen kann, daher wäre es unwichtig, ob ich die Frikadelle selbst herstelle oder sie fertig 
einkaufe, allerdings  - andererseits - befriedigt mich dieser Ansatz als ehemaliger Gastronom nicht wirklich.

Ich kann eine Frikadelle ebenso verschieden herstellen und würzen, wie ich einen Wirsingrouladen statt mit reinem Gehacktem 
auch mit einer Füllung aus Reis, Gehacktem und Feta herstellen. Dann wäre das eine andere Art


Stand:10.04.21
Ich überdenke und überarbeite den Ansatz nochmal komplett.


04.05.21
Ich habe der Tabelle Lebensmittel jetzt 6 neue Attribute hinzugefügt.

1. Kategorie
2. Sorte
3. Teil
4. Herkunft
5. Eigenschaft
6. Artikelnummer


**/



session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von Lebensmittel';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


static $db;

require_once './class/Log.classes.php';
require_once './class/LetzteAktivitaet.class.php';


function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die Übersicht ist doch nicht die action sondern der
	//controller.....
    
    
	
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Ingredenzien</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

	/** Die Funktion soll erweitert werden um eine OnchangeSelect Variante
	 zur EIngrenzung der Lebensmittel auf Kategorien 
			(Es sollten die Kategorien der Lebensmittel auch beschränkt werden, da eine Sortierung sonnst erschwert wird)
		Gemüse/Gewürze

	*/

    else if ( $action == 'zeigeAlleLebensmittel') {
        
        include 'inc/header.php';


		echo '<form method="get" action="zeigeAlleLebensmittel"><label>Auswahl: </label>';
		echo ' <select class="produktform" name="id" size="1" onchange="this.form.submit()">';
		echo '  <option value="default" selected>Bitte ausw&auml;hlen</option>';
		echo '  <option value="-1">nicht zugeordnet</option>';
		echo '  <option value="Gem&uuml;se">Gem&uuml;se</option>';
		echo '  <option value="S&auml;ttigungsbeilage">S&auml;ttigungsbeilage</option>';
		echo '  <option value="Fleisch">Fleisch</option>';
		echo '  <option value="&Ouml;le & Fette">&Ouml;le & Fette</option>';
		echo '  <option value="Fisch">Fisch</option>';
		echo '  <option value="Eier">Eier</option>';
		echo '  <option value="Gew&uuml;rz">Gew&uuml;rze</option>';
		echo ' </select>';
		echo '</form>';
		
		echo "<br><br>".$id."<br><br";		

	    try {
		
        	if ( $id == '' Or $id == '-1' ) { 
				$sql = "SELECT Distinct `lebensmittel_id`,`lebensmittel_hash`, `bezeichnung`,`kategorie`, `artikelnummer`, `sorte`, `teil`, `eigenschaft`, `herkunft`, `aktiv`, `loeschbar` FROM `lebensmittel` 
    			where 
    			`lebensmittel_id` in (select max(lebensmittel_id) From lebensmittel group by initial_id ) 
			     order By `bezeichnung` asc";
			} else {

				$sql = "SELECT Distinct `lebensmittel_id`,`lebensmittel_hash`, `bezeichnung`,`kategorie`, `artikelnummer`, `sorte`, `teil`, `eigenschaft`, `herkunft`, `aktiv`, `loeschbar` FROM `lebensmittel` 
    			where 
    			`lebensmittel_id` in (select max(lebensmittel_id) From lebensmittel group by initial_id ) 
				and kategorie = '".$id."'
			     order By `bezeichnung` asc";
			}
	


	      if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        echo '<h3>Lebensmittel f&uuml;r Speisen</h3>';
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;">';
			echo '	<th style="font-family: Fira ;color:#ddd">Bezeichnung</th>';
			echo '  <th>Kategorie</th>';
			echo '  <th>Sorte</th>';
			echo '  <th>Teil</th>';
			echo '  <th>Art.Nr</th>';
			echo '</tr>';
	     /*   echo "<tr style=\"padding:8px;\">
			<td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Bezeichnung</td>
            <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Beschreibung</td>";
		    //<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Rezepte</td>
          echo "</tr>"; */
	        foreach ($ergebnis as  $inhalt)
	        {
	            $lebensmittel_id=$inhalt['lebensmittel_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\">";
				echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"/wochenplan/lebensmittel/details/$lebensmittel_id\">".$inhalt['bezeichnung']."</a>";
	            
	                      //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td>";
			    echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"/wochenplan/lebensmittel/details/$lebensmittel_id\">".$inhalt['kategorie']."</a>";
	            echo "<br></td>";

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"/wochenplan/lebensmittel/details/$lebensmittel_id\">".$inhalt['sorte']."</a>";
	            echo "<br></td>";

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"/wochenplan/lebensmittel/details/$lebensmittel_id\">".$inhalt['teil']."</a>";
	            echo "<br></td>";
		
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<span class=\"tiny\"><small><small><a href=\"/wochenplan/lebensmittel/details/$lebensmittel_id\">".$inhalt['artikelnummer']."</a></small></small></span>";
	            echo "<br></td>";

				$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$lebensmittel_id."\">AK</a></small>";
             	echo "</td>";
             
            	 $color = $inhalt['loeschbar'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$lebensmittel_id."\">L&Ouml;</a></small>";
             	echo "</td>";

				//echo "<td>A</td>";
			    //echo "<td>L</td>";	
				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
        echo "<br><a href=\"anlegen\">neues Lebensmittel anlegen</a><br>";
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}
	
    else if ( $action == 'details') {
     
       include 'inc/header.php';        

       try {
		 
		$sql = "Select bezeichnung, beschreibung, lebensmittel_hash, initial_id, kategorie, sorte, teil, eigenschaft, artikelnummer, herkunft from lebensmittel where lebensmittel_id = ".$id;


		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	 	
          $lebensmittel_hash     = $ergebnis[0]['lebensmittel_hash'];       
     
		  $bezeichnung     = $ergebnis[0]['bezeichnung'];
		  $beschreibung    = $ergebnis[0]['beschreibung'];
		  $kategorie       = $ergebnis[0]['kategorie'];
	   	  $sorte           = $ergebnis[0]['sorte'];
	      $teil            = $ergebnis[0]['teil'];
	      $eigenschaft     = $ergebnis[0]['eigenschaft'];
	      $artikelnummer   = $ergebnis[0]['artikelnummer'];
	      $herkunft        = $ergebnis[0]['herkunft'];
			
		  $initial_id      = $ergebnis[0]['initial_id']; 

		 echo '<h1 style="background: darkslategray; color:white;  text-shadow: 2px 2px 4px #000000; padding:20;margin:20px;
	             padding-left:120px; bottom:1px black solid;">Lebensmittel</h1>';
         echo '<div class="form" style="border-radius:20px;width:750px; text-align:right; padding:10px; margin:10px auto auto auto;background-image: linear-gradient(darkslategray, darkblue);">


         <form method="post" action="../eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Lebensmittel anlegen</legend>';  

		 echo "<input type=\"hidden\" name=\"lebensmittel_id\" value=\"".$id."\">"; 
	     echo "<input type=\"hidden\" name=\"initial_id\" value=\"".$initial_id."\">";     
		 echo "<input type=\"hidden\" name=\"lebensmittel_hash\" value=\"".$lebensmittel_hash."\">";	


         echo "<label>Lebensmittel: </label><input class=\"textform eyecatch\" type=\"text\" name=\"lebensmittel\"  value=\"".$bezeichnung."\" required /><br>";
         echo '</fieldset>';
         echo "<br>\n";

		 echo "<textarea id='editor' name='editor'>".$beschreibung."</textarea>";

				 // Lebensmittelhauptkategorie
		 echo ' <fieldset class="produktform" style="text-align:right; width:90%; padding:10px; margin-right:10px;">';

		 echo '<label>Kategorie: </label><input class="textform eyecatch" type="text" name="kategorie" value="'.$kategorie.'" required /><br>';	
		 echo '<label>Sorte: </label><input class="textform eyecatch" type="text" name="sorte" value="'.$sorte.'" /><br>';
		 echo '<label>Teil: </label><input class="textform eyecatch" type="text" name="teil" value="'.$teil.'"  /><br>';
	     echo '<label>Herkunft: </label><input class="textform eyecatch" type="text" name="herkunft" value="'.$herkunft.'" /><br>';
		 echo '<label>Eigenschaft: </label><input class="textform eyecatch" type="text" name="eigenschaft" value="'.$eigenschaft.'" /><br>';		
		 echo '<label>Artikelnummer: </label><input class="textform eyecatch" type="text" name="artikelnummer" value="'.$artikelnummer.'" /><br>';
		 echo '</fieldset>';	



         echo ' <fieldset style="text-align:right; width:90%;padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';

   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "</script>";
			

    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
      
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}


    /****************************************
  
    kleines Formular zum hinzufügen einer Lebensmittel
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		 include 'inc/header.php';

		 echo '<h1 style="background: darkslategray; color:white;  text-shadow: 2px 2px 4px #000000; padding:20;margin:20px;
	             padding-left:120px; bottom:1px black solid;">Lebensmittel</h1>';
         echo '<div class="form" style="border-radius:20px;width:750px; text-align:right; padding:10px; margin:10px auto auto auto;background-image: linear-gradient(darkslategray, darkblue);">

         <form method="post" action="eintragen" name="verzeichnis" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:90%; text-align:right; padding:10px; margin-right:10px;">
           <legend>Lebensmittel anlegen</legend>';       
         echo '<label>Lebensmittel: </label><input class="textform eyecatch" type="text" name="lebensmittel"  required /><br>';
         echo '</fieldset>';
         echo "<br>\n";

		 echo "<textarea id='editor' name='editor'></textarea>";
		
		 // Lebensmittelhauptkategorie
		 echo ' <fieldset class="produktform" style="text-align:right; width:90%; padding:10px; margin-right:10px;">';
		 echo '<label>Kategorie: </label><input class="textform eyecatch" type="text" name="kategorie"  required /><br>';	
		 echo '<label>Sorte: </label><input class="textform eyecatch" type="text" name="sorte"   /><br>';
		 echo '<label>Teil: </label><input class="textform eyecatch" type="text" name="teil"   /><br>';
	     echo '<label>Herkunft: </label><input class="textform eyecatch" type="text" name="herkunft"   /><br>';
		 echo '<label>Eigenschaft: </label><input class="textform eyecatch" type="text" name="eigenschaft"  /><br>';		
		 echo '<label>Artikelnummer: </label><input class="textform eyecatch" type="text" name="artikelnummer"  value="300999" /><br>';
		 echo '</fieldset>';

         echo ' <fieldset style="text-align:right; width:90%;padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';

     echo '<script type="text/javascript">';
     echo "	CKEDITOR.replace('editor');";
     echo "</script>";
			
	 // hier wird die unveränderte JavascriptFunktion update_auswahl() eingebunden.	
	 echo pullDownChange();

     include 'inc/footer.php';


	}


	/***************************************

	 Eintragen der Lebensmittel 19.04.2021

	 05.05.21
	 Die Funktion ist zum einen für das Anlegen, aber auch das Editieren eines 
	 Eintrages gedacht. 
	 Ich habe nach der Änderung von Ingredenzien auf Lebensmittel allerdings die 
	 Versionierung mit einbezogen, bei der ein Update wiederum keinen Sinn macht.

	 Wenn die Verionierung genutzt werden soll, dann muss die bisher aktuelle 
 	 lebensmittel_id zur parent_id des jetzt folgenden Eintrags werden.

	 Zugleich kann dann nicht mehr der 2. Teil der Transaction heißen
	 initial_id = lebensmittel_id

	 Es muss vielmehr auch i nder detailansicht die intial_id ausgelesen werden.
	 und wenn diese hier nicht leer ist, dann wird sie auch wieder so eingetragen.

	****************************************/

	else if ( $action == 'eintragen') {

	
     require_once './class/Log.classes.php';
	 $oLog = new Log();


     
     $lebensmittel    = htmlspecialchars($_REQUEST['lebensmittel']);
	 $beschreibung    = htmlspecialchars($_REQUEST['editor']);
	 $lebensmittel_id = isset($_REQUEST['lebensmittel_id'])?$_REQUEST['lebensmittel_id']:null;
	 $kategorie       = isset($_REQUEST['kategorie'])?htmlspecialchars($_REQUEST['kategorie']):null;
	 $sorte           = isset($_REQUEST['sorte'])?$_REQUEST['sorte']:null;
	 $teil            = isset($_REQUEST['teil'])?$_REQUEST['teil']:null;
	 $eigenschaft     = isset($_REQUEST['eigenschaft'])?$_REQUEST['eigenschaft']:null;
	 $artikelnummer   = isset($_REQUEST['artikelnummer'])?$_REQUEST['artikelnummer']:null;
	 $herkunft        = isset($_REQUEST['herkunft'])?$_REQUEST['herkunft']:null;
	 $initial_id      = isset($_REQUEST['initial_id'])?$_REQUEST['initial_id']:0;
										 
	 

	 //echo "<br>Intial_id: $initial_id<br>";

	 if (DEBUG) {
			print "<br><br><br>$lebensmittel_id<br><br>";
			var_dump($_REQUEST);
	  }
     try {

	 	  $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         // if(!$lebensmittel_id) { 

		  	$sql = "replace into lebensmittel 
					 set 
						bezeichnung = '".$lebensmittel."', 
						beschreibung = '".$beschreibung."', 
						kategorie =	'".$kategorie."',
						sorte =	'".$sorte."',
						teil =	'".$teil."',
						herkunft =	'".$herkunft."',
						eigenschaft =	'".$eigenschaft."',
						artikelnummer =	'".$artikelnummer."'";


          	print $sql."<br>";
			$oLog->writeSqlLog($sql);	
		  	$db->beginTransaction();          

		  	$db->query($sql);
	      	if ($initial_id == 0 ) {
        		$sql="update lebensmittel set initial_id = lebensmittel_id, lebensmittel_hash = SHA1(lebensmittel_id) order by lebensmittel_id desc limit 1";		
		  		echo "<br>1<br>";
			} else {
				$sql="update lebensmittel set initial_id = ".$initial_id.", parent_id = $lebensmittel_id, lebensmittel_hash = SHA1(lebensmittel_id) order by lebensmittel_id desc limit 1";		
		        echo "<br>2<br>";
			}	

			print $sql."<br>";
			$oLog->writeSqlLog($sql);	


			$db->query($sql);
			//$sql="update lebensmittel set lebensmittel_hash = SHA1(lebensmittel_id) order by lebensmittel_id desc limit 1";		
		  	//$db->query($sql);
						
	
   		  	$db->commit();
          	
		 /* } else {

		    $sql="update lebensmittel 
				   set 
					bezeichnung = '".$lebensmittel."', 
					beschreibung='".$beschreibung."',
					kategorie =	'".$kategorie."',
					sorte =	'".$sorte."',
					teil =	'".$teil."',
					herkunft =	'".$herkunft."',
					eigenschaft =	'".$eigenschaft."',
					artikelnummer =	'".$artikelnummer."'
				   where 
					lebensmittel_id=".$lebensmittel_id;	
	
           	print $sql."<br>";
			$db->beginTransaction();          
		  	$db->query($sql);
			$db->commit();
          	
		   } */
		   $db=null;
 		   $mes = "Eintrag erfolgreich !";
          }
          catch(PDOException $e){
            $db->rollBack();  
			print "<br>".$e->getMessage();
          }
       
          //die();
          
		   $oLAkt = new LetzteAktivitaet();
		   $string = "Es wurde der Eintrag: ".$lebensmittel." hinzugefügt.";	
		   $beschreib = htmlspecialchars($string);

		   $oLAkt -> writeLetzteAktivitaet( "wochenplan - Lebensmittel eingetragen", $beschreib, 1, "Rainer", 1, "wochenplan");	
		   $oLog = new Log();	

          header('location:../uebersicht');



    }

	else if ( $action == "aktiv" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `lebensmittel` Set `aktiv`=(`aktiv`-1)*-1 where `lebensmittel_id`=".$id.";";

  
         // print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          //echo "<br>".$sql."<br>";
          //die();


          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();

		   $oLAkt = new LetzteAktivitaet();
		   $oLAkt -> writeLetzteAktivitaet( "wochenplan - Lebensmittel aktiv", "Der Eintrag: ".$lebensmittel." wurde aktiviert bzw. deaktiviert.", 1, "Rainer", 1, "todo");	


        header('location:../zeigeAlleLebensmittel') ;

	}

	else if ( $action == "loeschbar" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `lebensmittel` Set `loeschbar`=(`loeschbar`-1)*-1 where `lebensmittel_id`=".$id.";";

  
         // print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          //echo "<br>".$sql."<br>";
          //die();


          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }
         //die();
		
		 $oLAkt = new LetzteAktivitaet();
		 $oLAkt -> writeLetzteAktivitaet( "wochenplan - Lebensmittel loeschbar", "Der Eintrag: ".$lebensmittel." wurde auf (nicht)loeschbar gesetzt.", 1, "Rainer", 1, "todo");	


        header('location:../zeigeAlleLebensmittel') ;

	}


}
	