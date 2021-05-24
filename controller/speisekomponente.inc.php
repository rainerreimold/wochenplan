<?php




session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von INgredenzien';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


static $db;
require_once './class/Log.classes.php';
$oLog = new Log();


function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die Übersicht ist doch nicht die action sondern der
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
					}

	            echo "<tr style=\"border:1px dotted black;\">";
				echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"details/$speisekomponente_id\">".$inhalt['skb']."</a>";
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td>";

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<small><small><a href=\"details/$speisekomponente_id\" class=\"btn btn-default btn-sm\"><span class=\"glyphicon glyphicon-pencil\"></span></a></small></small>";
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
		zu überarbeiten 


	*****************************************/

	else if ( $action == 'details') {
       

        include 'inc/header.php';

		 echo '<h1 style="background: green; color: orange;
	             padding-left:120px;">Speisekomponente</h1>';


		 echo '<div class="eyecatch block">Das Anlegen - Bearbeiten - einer Speisekomponente ist etwas abstrakt.....
			</div>'; 

        /* Jetzt müssen die Daten aus der DB gelesen werden */ 

		 try {
		
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
  
    kleines Formular zum hinzufügen der Speisekomponenten
  

	Anlegen muss  wegen der Überarbeitung der Tabellenstruktur und Beziehungen 
	angepasst oder neuerstellt werden

	11.05.2021

	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		
         include 'inc/header.php';

		 echo '<h1 style="background: green; color: orange;
	             padding-left:120px;">Speisekomponente</h1>';


		 echo '<div class="eyecatch block">Das Anlegen einer Speisekomponente ist etwas abstrakt. Es geht um das Herstellen einer 
			 Komponente oder eines Speiseteils, welches sp&auml;ter entweder zu einem Bestandteil einer Speise oder eine	
			 Speise insgesamt werden kann.<br>Es kann also sowohl eine Suppe aus Erbsen hergestellt werden, wie auch 
			 Zuckererbsen als Gem&uuml;sebeilage oder Erbsp&uuml;ree als S&auml;ttigungsbeilage.<br><br>

			 Hinzu kommt, dass man das nicht in einem Schritt durchf&uuml;hren k&ouml;nnen wird.<br><br><br>
			 Man muss je nach Rezeptur, die Bestandteile einzeln zusammenf&uuml;gen und so verbinden.<br><br>
	
			Wenn man daher M&ouml;hren als Gem&uuml;sebeilage einer Hauptspeise zubereiten m&ouml;chte, so geh&ouml;ren im ersten Schritt die 
M&ouml;hren, dann aber auch Zwiebeln, Salz, etwas Zucker und ein wenig Pfeffer dazu.<br><br>

			Sollen die M&ouml;hren gebunden werden, dann kann gern auch eine Mehlschwitze in Einzelkomponenten dazugegeben werden oder 
			perspektifisch w&auml;re es nat&uuml;rlich leichter die fertige Komponente Mehrschwitze, bereits fertig in die Verbindung integrieren zu k&ouml;nnen.
				
			<br><br>
			Nur im ersten Schritt wird die Bezeichnung angelegt... 
			Die Beschreibung sollte bis zum letzten Schritt ver&auml;nderbar sein.
			Es muss unterschieden werden, ob die Verbindung fortgesetzt oder abgeschlossen werden soll.
			</div>'; 

         
   
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
		 echo "<br><br>";

		 echo ' <button type=\"reset\">Eingaben l&ouml;schen</button>';
		 echo "<input type=\"button\" value=\"noch eins\" onclick=\"clone_this(this)\">";
		 echo '<button type=\"submit\">Absenden</button>'; 	    
		 echo "</fieldset>";
		
		/************************************************************************************

		*************************************************************************************/


        /*
  	     echo "<fieldset style=\"background:#cfcfcf; width:900px; text-align:right; padding:10px; margin-right:10px;\">";
 
		 echo '<div class="table">';
         echo '<div class="spalte">';


		 // hier biegen wir jetzt in Richtung Lebensmittel ab... allerdings wird das schnell zu unübersichtlich

		 // getIngredenzien()
	

        / * ich glaube wir sollten die Rohlebensmittel in die Kategorien unterteilen...
			z.B: Fleisch / Fisch,   Gemüse,  Eier, Sättigungsbeilage, Sauce, Gewürze, Öle/fette 
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


    /*      echo "</fieldset>";
         echo "<br>\n";

               echo "<fieldset style=\"background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;\">
              <button type=\"reset\">Eingaben l&ouml;schen</button>
			  
              <button type=\"submit\">Absenden</button>
            </fieldset> */
       echo "</form>
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


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

		28.04.2020
		Da wir feststellen mussten, dass das Weiterleiten auf die Übersichtsseite über php nicht funktioniert,
		da bereits JavaScript ausgegeben wurde, versuchte ich zunächst über die WindowsHistory Javascript Funktion
		zu gehen, aber das will auch nicht richtig.
		
		Es sollte doch aber möglich sein, einen anderen Header einzubinden?	


		12.05.21 

		nach dem Umbau des EIngabeformulars wird das Eintragen ein wenig 
		komplizierter, da wir zum einen 
			die 
		- Bezeichnung und 
		- beschreibung  
		
			für die Tabelle: Speisekomponente 

		auswerten und eintragen müssen, uns dann die ID holen und zur 
		Verknüpfung 

			für die Tabelle lm_sk_verbindung 


		eintragen

	****************************************/

	else if ( $action == 'eintragen') {

     
    // $speisekomponente    = $_REQUEST['speisekomponente'];
    // $speisekategorie		= $_REQUEST['speisekategorie'];

	 $lebensmittel		= array();
	 $lebensmittel		= $_REQUEST['lebensmittel'];
	 
	 //echo $lebensmittel[0];	

	 $menge					= array();
     $menge					= $_REQUEST['menge'];
	 $einheit				= array();
	 $einheit				= $_REQUEST['einheit'];

	 $zubereitungsart		= array();
	 $zubereitungsart		= $_REQUEST['zubereitungsart'];
	 $garmethode		 	= array();
	 $garmethode		  	= $_REQUEST['garmethode'];	
 	 $schnittform			= array();
	 $schnittform		  	= $_REQUEST['schnittform'];


									   
	 $bezeichnung		  	= $_REQUEST['bezeichnung'];
	 $beschreibung		  	= $_REQUEST['editor'];						

	
	 Log::writeLog(var_dump($_REQUEST));
	 //die();


     try {

                    

			/* 12.05.2021 
				Schritt 1: .. Trage den Namen und BEschreibung in die Tabelle 
				Speisekomponente */
		  
			$sql = "replace into speisekomponente 
                set 
				bezeichnung 		= '".$bezeichnung."',
				beschreibung 		= '".$beschreibung."'
";	

			$oLog->writeSqlLog($sql);	

			/* Schritt 2: Lies die ID des EIntrags aus. */

		 	// print $sql."<br><br>";
		 	//print $sql2."<br><br>";	

		 	$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
         	$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		 	$db->beginTransaction();
         	$db->query($sql);
		 
		 	$sql = "SELECT speisekomponente_id as skid
				FROM  `speisekomponente` 
				ORDER BY eingetragen DESC 
				LIMIT 1";

			// Eintrag in der Logdatei
		    $oLog->writeSqlLog($sql);	

         	$rueckgabe = $db->query($sql);
         	$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
                     
        	$speisekomponente_id = $ergebnis[0]['skid'];	

			$sql = "update speisekomponente SET `initial_id` = '".$speisekomponente_id."', `speisekomponente_hash` = SHA1('".$speisekomponente_id."'), speisekategorie = 3";
	
  		    $db->query($sql);
			$oLog->writeSqlLog($sql);
			


		 	$db->commit();
         	

         }
         catch(PDOException $e){
		 	$db->rollBack();
            print "<br>".$e->getMessage();
         }


		

    	/* Schritt 3: die Arrays der ReqestVariablen müssen dynamisch über eine 
		Schleife ausgelesen und in die DB eingetragen werden.

		D

		*/ 
		echo "<br>";
    	echo "<br>";
		echo ", ".$garmethode[0];
		echo "<br>";
		echo "<br>"; 
		
		$sql3= '';
		try {
        
			$i=0;
			$db->beginTransaction();
			do {
				if (DEBUG) {
					echo $i.": ".$lebensmittel[$i];
					//echo "<br>";
					echo ", ".$schnittform[$i];
					echo ", ".$garmethode[$i]; 
					echo ", ".$zubereitungsart[$i];
					echo ", ".$menge[$i];
					echo ", ".$einheit[$i];
					echo "<br>";
					echo "<br>";
				}	
			
			    $sql3 .= "replace into lm_sk_verbindung 
               		 set 
						lebensmittel_id 		= '".$lebensmittel[$i]."',
						schnittform_id			= '".$schnittform[$i]."',
						zubereitungsart_id 		= '".$zubereitungsart[$i]."',
						garmethode_id 			= '".$garmethode[$i]."',
						menge 					= '".$menge[$i]."',
						einheit					= '".$einheit[$i]."',
						speisekomponente_id 	= '".$speisekomponente_id."',
						bezeichnung				= '',
						beschreibung			= ''; 
				";
			   
				$sql3 .="update lm_sk_verbindung set initial_id=lm_sk_verbindung_id, lm_sk_verbindung_hash=sha1(lm_sk_verbindung_id) order by lm_sk_verbindung_id desc Limit 1;"; 
				$oLog->writeSqlLog($sql3);	

			
         		$db->query($sql3);



		   }while(++$i<count($lebensmittel));
		// print $sql3;
		 $db->query($sql3);	
		 $db->commit();
         $db=null;

		  $_SESSION['Eintrag']	= $bezeichnung.' erfolgreich eingetragen';	
          header('location:../uebersicht');


         }
         catch(PDOException $e){
		 	$db->rollBack();
            print "<br>".$e->getMessage();
			$oLog->writeSqlLog("Fehler<br>".$e->getMessage());
			$oLog->writeSqlLog($sql3);	

	
         }



        
          die();
          
		 



    }

 else if ( $action == 'bearbeiten') {
  	
		
         include 'inc/header.php';

		 echo '<h1 style="background: green; color: orange;
	             padding-left:120px;">Speisekomponente</h1>';


		 echo '<div class="eyecatch block">Das Anlegen - Bearbeiten - einer Speisekomponente ist etwas abstrakt.....
			</div>'; 

        /* Jetzt müssen die Daten aus der DB gelesen werden */ 

		
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


		 // hier biegen wir jetzt in Richtung Lebensmittel ab... allerdings wird das schnell zu unübersichtlich

		 // getIngredenzien()
	

        / * ich glaube wir sollten die Rohlebensmittel in die Kategorien unterteilen...
			z.B: Fleisch / Fisch,   Gemüse,  Eier, Sättigungsbeilage, Sauce, Gewürze, Öle/fette 
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
	
