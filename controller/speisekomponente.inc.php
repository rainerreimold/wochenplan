<?php




session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von INgredenzien';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


//require_once './class/LetzteAktivitaet.class.php';

static $db;
//require_once './class/Log.classes.php';
$oLog = new Log();


function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die ?bersicht ist doch nicht die action sondern der
	//controller.....
    
   
	// include 'inc/header.php';
	

    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Ingredenzien</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



	}

/****

	nach der Anpasung der Tabellenstrukturen und Relationen funktioniert die Anzeige derzeit nicht !

	11.05.2021


***/



    else if ( $action == 'zeigeAlleSpeisekomponenten') {
      
	 	include 'inc/header.php';
	
  
       	try {
		    	
        	$sql = "SELECT distinct sk.bezeichnung as skb, 
								sk.speisekomponente_id as id,
								sk.beschreibung as skbesch,
								sk.speisekomponente_hash as hash,
								sk.speisekategorie_id as kat,
								sk.aktiv as akt,
								sk.loeschbar as loe
					FROM 
							`speisekomponente` sk
					where 	sk.speisekomponente_id in 
							(Select Max(speisekomponente_id) from `speisekomponente` group by initial_id)				
					order By sk.bezeichnung asc";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Speisekomponenten f&uuml;r Rezepte</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Bezeichnung
            </td>
			<td style=\"background:darkgrey;a color:orange;width:35px;\" class=\"odd\">| |</td>
            <td style=\"background:darkgrey;a color:orange;width:250px;\" class=\"odd\">Beschreibung</td>
		    <td style=\"background:darkgrey;a color:orange;width:50px;\" class=\"odd\">Zubereitungsart</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">A</td>
			<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">L</td>
          </tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $speisekomponente_id=$inhalt['id'];
				$beschreib = substr($inhalt['skbesch'],0,25);
				$beschreib = strlen($inhalt['skbesch'])>25?$beschreib.'...':$beschreib;

	            $kategorie = '';
				switch ($inhalt['kat']) {		
					case 1:
						$kategorie='S&auml;ttigungsbeilage';
						break;
					case 2:
						$kategorie='Gem&uuml;sebeilage';
						break;
					case 3:
						$kategorie='Fleischbeilage';
						break;
					case 4:
						$kategorie='Suppe';
						break;
					}

	            echo "<tr style=\"border:1px dotted black;\">";
				echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"details/$speisekomponente_id\">".$inhalt['skb']."</a>";
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td>";

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"aendern/$speisekomponente_id\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-pencil\"></span></a></small></small>";
	            echo "<br></td>";

				echo "<td style=\"background:lightgrey;a color:orange;width:250px;padding:6px;\" class=\"odd\"> ";
				echo "<a href=\"bearbeiten/$speisekomponente_id\" title=\"".$inhalt['skbesch']."\">".$beschreib."</a>";
	            echo "<br></td>";
				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    echo $kategorie;
				echo "</td>";

				$color = $inhalt['akt'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$speisekomponente_id."\">AK</a></small>";
             	echo "</td>";
             
            	 $color = $inhalt['loe'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$speisekomponente_id."\">L&Ouml;</a></small>";
             	echo "</td>";


				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
        echo "<br><a href=\"anlegen\">neue Komponente anlegen</a><br>";
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}
	
    
	/**************************************** 
		29.04.2020	
		zu ?berarbeiten 
		ausgelagert: 22.09.2021

	*****************************************/

	else if ( $action == 'aendern') {
       
		require_once("speisekomponente/speisekomponente-aendern.php");
       
	}


	else if ( $action == 'details') {
       
		require_once("speisekomponente/speisekomponente-details.php");
       
	}

    /****************************************
  
    kleines Formular zum hinzuf?gen der Speisekomponenten
  

	Anlegen muss  wegen der ?berarbeitung der Tabellenstruktur und Beziehungen 
	angepasst oder neuerstellt werden

	11.05.2021
	ausgelagert: 22.09.2021

	*****************************************/
  	
    else if ( $action == 'anlegen') {

        require_once("speisekomponente/speisekomponente-anlegen.php");

	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

		28.04.2020
		Da wir feststellen mussten, dass das Weiterleiten auf die ?bersichtsseite ?ber php nicht funktioniert,
		da bereits JavaScript ausgegeben wurde, versuchte ich zun?chst ?ber die WindowsHistory Javascript Funktion
		zu gehen, aber das will auch nicht richtig.
		
		Es sollte doch aber m?glich sein, einen anderen Header einzubinden?	


		12.05.21 

		nach dem Umbau des EIngabeformulars wird das Eintragen ein wenig 
		komplizierter, da wir zum einen 
			die 
		- Bezeichnung und 
		- beschreibung  
		
			f?r die Tabelle: Speisekomponente 

		auswerten und eintragen m?ssen, uns dann die ID holen und zur 
		Verkn?pfung 

			f?r die Tabelle lm_sk_verbindung 


		eintragen

	****************************************/

	else if ( $action == 'eintragen') {

   		 require_once("speisekomponente/speisekomponente-eintragen.php");  
   
    }

 else if ( $action == 'bearbeiten') {
  	
		
         include 'inc/header.php';

		 echo '<h1 style="background: green; color: orange;
	             padding-left:120px;">Speisekomponente</h1>';


		 echo '<div class="eyecatch block">Das Anlegen - Bearbeiten - einer Speisekomponente ist etwas abstrakt.....
			</div>'; 

        /* Jetzt m?ssen die Daten aus der DB gelesen werden */ 

		
		$sql="SELECT 
				lmskv.lm_sk_verbindung_id as verbId,
				lmskv.menge as meng,
				lmskv.einheit as einh,
				lm.bezeichnung as bez
			 FROM 
				`lm_sk_verbindung` lmskv,
				`lebensmittel` lm 
			WHERE 
				`speisekomponente_id` = ".$id."
			and 
				lm.lebensmittel_id = lmskv.lebensmittel_id";

		 //if (DEBUG) echo "<br>".$sql."<br>";
       
	 
         $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
         $rueckgabe = $db->query($sql);
          
		 $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
		 
		// print count($ergebnis);
	     
   		// die();

		//Tabellenkopf..

		echo '<table>';
		echo '	<tr>';
		echo '		<th>Bezeichnung</th>';
		echo '		<th>Menge</th>';
		echo '		<th>Einheit</th>';
		echo '		<th></th>';
		echo '	</tr>';
	
		 foreach ($ergebnis as  $inhalt)
	        {
	            $lebensmittel_id	= $inhalt['verbId'];
				$bezeichnung 		= $inhalt['bez'];
				$menge				= $inhalt['meng'];
				$einheit			= $inhalt['einh'];
		echo '	<tr>';
		echo '		<td>'.$bezeichnung.'</td>';
		echo '		<td>'.$menge.'</td>';	
		echo '		<td>'.$einheit.'</td>';
		echo '		<td></td>';
		echo '	</tr>';
	        }    
		 
		echo '</table>';

		/* Hier beginnt das Formular */
   
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';

	    

  		 echo "<form method=\"post\" action=\"eintragen\" style=\"width:700px; padding:10px; margin:10px;\">";
         
         echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
         echo "<legend>Speisekomponente anlegen</legend>"; 
		 echo '<label>Bezeichnung: </label><input class="textform eyecatch" type="text" name="bezeichnung" placeholder="!" required /><br>';
         echo '<label>Beschreibung: </label>'."<br>";
	     echo "<textarea id='editor' name='editor'></textarea>";
		 echo "</fieldset>";

  	     echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
 		 echo '<h2>Lebensmittel</h2>';	
		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"10\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel()."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;
    

		 echo '<label>Menge: </label><input class="textform eyecatch" type="text" name="menge[]" placeholder="!" required /><br>';
         echo '<label>Einheit: </label><select class="produktform2" name="einheit[]">';	
		 echo '<option value="Gramm">Gramm</option>'; 	
		 echo '<option value="Milliliter">Milliliter</option>';
		 echo '<option value="St&uuml;ck">St&uuml;ck</option>';
		 echo '</select>';


		 echo '<h2>Schnittform - Zubereitungsart - Garmethode</h2>'; 
		
   	     $SchnittformsartSelect="\n<select class=\"produktform2\" name=\"schnittform[]\">\n";
		 //$SchnittformsartSelect.="\n<option value=\"0\" selected> - keine - </option>\n";
         $SchnittformsartSelect.=getSchnittform()."\n";
         $SchnittformsartSelect.="</select>\n";	

		 //echo '<h2>Zubereitungsart</h2>';
		 $ZubereitungsartSelect="\n<select class=\"produktform2\" name=\"zubereitungsart[]\">\n";
		 //$ZubereitungsartSelect.="\n<option value=\"0\"> - keine - </option>\n";
         $ZubereitungsartSelect.=getZubereitungsart()."\n";
         $ZubereitungsartSelect.="</select>\n";
		
		 $GarmethodeSelect="\n<select class=\"produktform2\" name=\"garmethode[]\">\n";
		 //$GarmethodeSelect.="\n<option value=\"0\"> - keine - </option>\n";
         $GarmethodeSelect.=getGarmethode()."\n";
         $GarmethodeSelect.="</select>\n";
		

         echo $SchnittformsartSelect;
		 echo $ZubereitungsartSelect;
		 echo $GarmethodeSelect;
		 echo "<br>";

		 echo "<input type=\"button\" value=\"noch eins\" onclick=\"clone_this(this)\">";
 	     echo "</fieldset>";
		
		/************************************************************************************

		*************************************************************************************/


        /*
  	     echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
 
		 echo '<div class="table">';
         echo '<div class="spalte">';


		 // hier biegen wir jetzt in Richtung Lebensmittel ab... allerdings wird das schnell zu un?bersichtlich

		 // getIngredenzien()
	

        / * ich glaube wir sollten die Rohlebensmittel in die Kategorien unterteilen...
			z.B: Fleisch / Fisch,   Gem?se,  Eier, S?ttigungsbeilage, Sauce, Gew?rze, ?le/fette 
		* /
	
		 echo '<h2>Lebensmittel</h2>';	
		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"5\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel('Fleisch')."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;

		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"5\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel('Gem&uuml;se')."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;

		 $LebensmittelSelect="\n<select class=\"produktform\" name=\"lebensmittel[]\" size=\"5\" multiple>\n";
         $LebensmittelSelect.=getLebensmittel('Gem&uuml;se')."\n";
         $LebensmittelSelect.="</select>\n";	
		 echo $LebensmittelSelect;

	     echo '</div>';
      
         echo '<div class="spalte">';
   	  
		  // Zubereitungsart

		 echo '<h2>Zubereitungsart</h2>';
		 $ZubereitungsartSelect="\n<select class=\"produktform2\" name=\"zubereitungsart\">\n";
         $ZubereitungsartSelect.=getZubereitungsart()."\n";
         $ZubereitungsartSelect.="</select>\n";
			
		 echo $ZubereitungsartSelect;
		 echo "<br>";
      
		 echo '<h2>Garmethode</h2>'; 
		 $GarmethodeSelect="\n<select class=\"produktform2\" name=\"garmethode\">\n";
         $GarmethodeSelect.=getGarmethode()."\n";
         $GarmethodeSelect.="</select>\n";
			
		 echo $GarmethodeSelect;
		 echo "<br>";

		  // getMengen()
         
		 echo '<h2>Menge</h2>';
 		 $MengenSelect="\n<select class=\"produktform2\" name=\"mengen\" size=\"3\" multiple>\n";
         $MengenSelect.=getMengen()."\n";
         $MengenSelect.="</select>\n";
			
		  echo $MengenSelect;
		  echo "<br><br>";

		  
  

		  // Speisekategorie
		  echo '<h2>Speisekategorie</h2>';
		  $SpeisekategorieSelect="\n<select class=\"produktform2\" name=\"speisekategorie\" size=\"3\" multiple>\n";
          $SpeisekategorieSelect.=getSpeisekategorie()."\n";
          $SpeisekategorieSelect.="</select>\n";
			
		  echo $SpeisekategorieSelect;
		  echo "<br><br>";

		  // evtl Garnitur	

		     echo '</div>';
      echo '<div class="clear"></div>';
      echo '</div>';  
      echo '</div>'; 
  */
		/************************************************************************************

		*************************************************************************************/

  	

         echo "</fieldset>";
         echo "<br>\n";
                echo "<fieldset style=\"background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;\">
              <button type=\"reset\">Eingaben l&ouml;schen</button>
			  
              <button type=\"submit\">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>";
 	 
       echo '<script type="text/javascript">';
   	   echo "	CKEDITOR.replace('editor');
       </script>";

	    echo '<script type="text/javascript">';

       echo "<!--
			function clone_this(objButton)
			{
				if(objButton.parentNode)
    			{
    				tmpNode=objButton.parentNode.cloneNode(true);
   					objButton.form.appendChild(tmpNode);
    				for(j=0;j<objButton.form.lastChild.childNodes.length;++j)
        			{
        				if(objButton.form.lastChild.childNodes[j].type=='text')
            			{
           					objButton.form.lastChild.childNodes[j].value='';
            				break;
            			}
       				}
    				objButton.value='entfernen';
    				objButton.onclick=new Function('f1','this.form.removeChild(this.parentNode)');
    			}
			}
			//-->
			</script>";


	 
     include "inc/footer.php";


	}





    else if ( $action == "aktiv" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `speisekomponente` Set `aktiv`=(`aktiv`-1)*-1 where `speisekomponente_id`=".$id.";";

  
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
        header('location:../zeigeAlleSpeisekomponenten') ;

	}

	else if ( $action == "loeschbar" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `speisekomponente` Set `loeschbar`=(`loeschbar`-1)*-1 where `speisekomponente_id`=".$id.";";

  
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
        header('location:../zeigeAlleSpeisekomponenten') ;

	}







}
	
