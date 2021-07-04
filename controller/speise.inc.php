<?php
/*********************************************************************************************************************
 Name: speise.inc.php
 Typ: Controller
 Ziel: Das Erstellen einer Speise, erfolgt durch die Auswahl verschiedener Speiekomponenten. Diese werden so zu 
	   Bestandteilen der Speise. 
	   Mit diesem Ansatz sollten nunmehr auch ungew�hnlichere Kombinationen m�glich sein, die zugleich aufgrund 
	   der jeweiligen Mengenangaben auch durchkalkuliert werden k�nnten.


 Aufruf: ... erfolgt indirekt �ber die .htaccess	an controller.php, der mit parameter den betreffenden Controller 
		 aufruft.
 Hinweis: In diesem Projekt geht es nur um die Umsetzung, es wurde im ersten Release auf jegliche Dinge, die das 
 			Erstellen erschweren verzichtet. So wurden hier keine Klassen genutzt.

 Author: Rainer Reimold
 Datum: 17.05.2021





*********************************************************************************************************************/



session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Speisen - Erstellung von Speisen';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;

require_once './class/Log.classes.php';
require_once './class/LetzteAktivitaet.class.php';

static $db;




function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die �bersicht ist doch nicht die action sondern der
	//controller.....
    
    /* Den Header k�nnen wir leider nicht mehr zentral einbinden,
       da sonst die header location nicht mehr funktioniert. 
      
         include 'inc/header.php';
	 */
    
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Rezept</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    else if ( $action == 'zeigeAlleSpeisen') {
      
       include 'inc/header.php';
	
      
        
       try {
		// ermittle die jeweilige Speise_id und die bezeichnung
   		$sql = "select speise_id, bezeichnung, aktiv, loeschbar from speise where aktiv=1 and loeschbar=0;";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        	        
	      echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	      echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Speisekomponenten f&uuml;r Rezepte</th></tr>';
	      echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">";
          echo "Rezept";
          echo "</td>";
          echo "<td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Rezeptbestandteil</td>";
		  echo "<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">   </td>";
		  echo "<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">A</td>";
		  echo "<td style=\"background:darkgrey;a color:orange;width:20px;\" class=\"odd\">L</td>";
          echo "</tr>";

          foreach ($ergebnis as  $inhalt)
	      {
	          
	            $speise_id=$inhalt['speise_id'];
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"details/$speise_id\">".$inhalt['bezeichnung']."</a>";
	            echo "</td>";

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
				echo "<br>";

				/*********************************************************************
				// innere Abfrage der Speise, nach den zugeh�rigen Speisebestandteilen 
				*********************************************************************/

				$sql2 = "select speisebestandteil_id,bezeichnung from speisebestandteil where speise_id=".$speise_id.";";		
				$rueckgabe2 = $db->query($sql2);         
		  		$ergebnis2 = $rueckgabe2->fetchAll(PDO::FETCH_ASSOC);
	
				foreach ($ergebnis2 as  $inhalt2)
	        	{
					
					echo "<a href=\"../speisebestandteil/details/".$inhalt2['speisebestandteil_id']."\">".$inhalt2['bezeichnung']."</a>";
	            	echo "<br>";		
				}
				echo "<br></td>";

				echo "<td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
			    //echo  $inhalt['rtb'];
				echo "</td>";
			


				$color = $inhalt['aktiv'] == 1?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"aktiv/".$speise_id."\">AK</a></small>";
             	echo "</td>";
             
            	 $color = $inhalt['loeschbar'] == 0?'green':'red';
             	echo "<td style=\"background:".$color.";a::link,a::hover { text-decoration: none; color: white; };width:50px;\" class=\"tdhersteller\">";
             	echo "<small><a href=\"loeschbar/".$speise_id."\">L&Ouml;</a></small>";
             	echo "</td>";


				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
         echo "<br><a href=\"anlegen\">neues Rezept anlegen</a><br>";
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}

/****

 Das Detail f�r Speisen geht hier nat�rlich v�llig ab.

 Orientiert an der vorhandener Speise anlegen, muss hier im 
 
 1. Schritt 
 - festgestellt werden, um welche Art von Speise es sich handelt.
 
 2. Damit erfolgt die Auswahl/Aktivierung des Formulars und

 3. mit den Rezeptbestandteilen werden diese ausgelesen und in dem Formular angezeigt. 

 Wichtig! 
 ---> Soll die Darstellung / Detail des Rezeptes und die Bearbeitung unterschieden werden?

 Im Prinzip schon, denn die Anzeige sollte f�r jeden Nutzer m�glich sein, die Bearbeitung aber nur f�r einen 
 berechtigten Personenkreis.




**/


	
    else if ( $action == 'details') {
        
	      include 'inc/header.php';
	

       try {
		//echo "HIER";
               //    SELECT domain_id, domain_name FROM `domain` WHERE 1

		$sql = "SELECT * FROM `speise` WHERE `speise_id` = $id";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Lizenzen f&uuml;r Clients</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\"> Das Rezept

          </td>
           <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Komponenten</td>";
           //echo "<td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Anzahl</td>
			echo "</tr>";

	        foreach ($ergebnis as  $inhalt)
	        {
	            $speise_id=$id;
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"auspraegung/".$rezept_id."\">".$inhalt['beschreibung']."</a>";
	            echo "</td><td>";
				//echo "<a href=\"auspraegung/".$rezept_id."\">".$inhalt['beschreibung']."</a>";
	            
/***	 

AN DIESER STELLE SOLLTE DER REKURSIVE AUFRUF UND ANZEIGE DER REZEPTBESTANDTEILE ERFOLGEN

***/


/* 

				$sql2 = "SELECT distinct rt.rezeptteil_id,rt.aktiv, sk.speisekomponente_id as skid, sk.bezeichnung as skbez FROM `rezept` rez, `rezeptteil` rt,`speisekomponente` sk
				WHERE rt.rezept_id=$id
				and rt.aktiv=1 
				and rt.rezept_id = rez.rezept_id
				and sk.speisekomponente_id = rt. speisekomponente_id";*/

 				$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          		$rueckgabe2 = $db->query($sql2);
          
		  		$ergebnis2 = $rueckgabe2->fetchAll(PDO::FETCH_ASSOC);


				echo "<div>";
				foreach ($ergebnis2 as  $inhalt2) {
					echo "<a href=\"../speisekomponente/".$inhalt2['skid']."\">".$inhalt2['skbez']."</a><br>";
				}
				echo "</div>";
/* */


           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$rezept_id."\">bearbeiten</a>)</em></small></small>";
	            echo "</td><td style=\"background:lightgrey;a color:orange;width:50px;padding:6px;\" class=\"odd\"> ";
	            echo "<br></td></tr>";
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
  
    kleines Formular zum hinzuf�gen einer Speise

	Datum: 17:05.2021

	03.07.21 EInbau zus�tzliches Attribut 
		- speiseart zur Auswahl von S��speisen, Hauptspeisen, Suppen.
		Ziel: damit man sp�ter vermeiden kann, jeden Tag Fleischgerichte oder 5 mal in der Woche S��speisen zu essen.

  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		   include 'inc/header.php';
	

		// neue Tabnavigation 
			echo '<section data-title="Radio und Label">';


    	 echo '<h1 style="background: orange;
	             padding-left:320px;">Rezept</h1>';
        

    
     echo '<div class="tabbed" >
		<input checked="checked" id="tab1" type="radio" name="tabs" />
		<input id="tab2" type="radio" name="tabs" />
		<input id="tab3" type="radio" name="tabs" />
		<input id="tab4" type="radio" name="tabs" />
		<input id="tab5" type="radio" name="tabs" />
		
		<div class="nav nav-w" style="width: 1000px;">
			<label for="tab1">Hauptspeise</label>
			<label for="tab2">Suppe</label>
			<label for="tab3">Vorspeise</label>
			<label for="tab4">Dessert</label>
			<label for="tab5">kl.Speise</label>
		</div>
	
		<figure style="width: 1000px;">
			<div class="tab1">
				<div class="lines">
					<h5>Hauptspeise</h5>
					
					<p>';
					

			/**********************************************************************************************************

		      // Formular Hauptspeise	



			**********************************************************************************************************/


			  echo '<div class="form" style="width:1000px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 			
			  echo '<form method="post" action="hauptspeiseEintragen" style="width:60px; padding:10px; margin:10px;">

                <fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
                <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textformsuppe" type="text" name="speise" placeholder="xxx.xx" required /><br>';
             
             echo "<br>\n";
			// echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
		

			 $HauptbeilageSelect="\n<select class=\"auswahl2 haupt\" name=\"hauptbeilage\" size=\"5\" multiple>\n";
             $HauptbeilageSelect.=getHauptBeilage()."\n";
             $HauptbeilageSelect.="</select>\n";
			  

			 $SaettigungsbeilageSelect="\n<select class=\"auswahl2 sat\" name=\"saettigungsbeilage\" size=\"5\" multiple>\n";
			 $SaettigungsbeilageSelect.=getSaettigungsBeilage()."\n";
             $SaettigungsbeilageSelect.="</select>\n";
						 
			 $GemuesebeilageSelect="\n<select class=\"auswahl2 gem\" name=\"gemuesebeilage\" size=\"5\" multiple>\n";
             $GemuesebeilageSelect.=getGemueseBeilage()."\n";
             $GemuesebeilageSelect.="</select>\n";
			
			 $SaucebeilageSelect="\n<select class=\"auswahl2 sau\" name=\"saucebeilage\" size=\"5\" multiple>\n";
             $SaucebeilageSelect.=getSaucen()."\n";
             $SaucebeilageSelect.="</select>\n";
			 
			

			 echo "<span class=\"label2 haupt\">Hauptkomponente&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</span>\n";
			 echo "<span class=\"label2 sat\">-&nbsp;&nbsp;&nbsp;S&auml;ttigungsbeilage&nbsp;&nbsp;&nbsp;</span><br>\n";

			 echo $HauptbeilageSelect;
 			 echo $SaettigungsbeilageSelect;
			 
			 echo "<br/><br/>";
			 echo "<span class=\"label2 gem\">Gem&uuml;sebeilage</span>\n";  	
			 echo "<span class=\"label2 sau\">Saucebeilage</span><br>\n";  		
	
			
			 echo $GemuesebeilageSelect;
			 echo $SaucebeilageSelect;

			 echo "<br/><br/>";

				
			 /*
				
				Vielleicht ist die Unterscheidung �ber die Speiseart 
				hier auch in Fleisch und Fisch sinnvoll 
			
			*/ 
			 	
			 $SpeiseartSelect="\n<select class=\"auswahl2\" name=\"speiseart\" size=\"5\" multiple>\n";
             $SpeiseartSelect.=getSpeiseart()."\n";
             $SpeiseartSelect.="</select>\n";

			 echo "<span class=\"label2 haupt\">Speiseart&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;</span>";
			 echo $SpeiseartSelect;	

			 echo "<br/><br/>";
			 echo "<textarea id='editor' name='editor'></textarea>";
			

             echo '</fieldset>';
			  echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';

			echo	'</p>
				</div>
			</div>';

		/* Ende Tab/Bereich Anlegen eines Hauptgerichtes */

		/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :Suppe	
			
		********************************************************************************************************/

		echo '<div class="tab2">
				  <div class="lines">
					<h5>Suppe</h5>
					<p>';
					  
			  echo '<div class="form" style="width:940px; text-align:right; padding:10px; margin:10px auto auto auto;">';
		 			
			  echo '<form method="post" action="suppeEintragen" style="width:900px; padding:10px; margin:10px;">

              <fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">
              <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label>
			  <input class="textformsuppe" type="text" name="speise" placeholder="Suppe" required style="width:750px;/><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
              
			 echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
		

			 $SuppeSelect="\n<select class=\"auswahl eyecatch\" name=\"suppe\" size=\"5\" multiple>\n";
             $SuppeSelect.=getSuppen()."\n";
             $SuppeSelect.="</select>\n";
			
			 echo $SuppeSelect;

			 echo "<br><br>\n";
			 				

			  echo "<textarea id='editorSuppe' name='editorSuppe'></textarea>";
  	

			 echo '</fieldset>';

             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';

  		/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :Vorspeise	
			
		********************************************************************************************************/


			echo '<div class="tab3">
				
				<div class="lines">
					<h5>Vorspeise</h5>
					<p>';
					  
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="vorspeiseEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="speise"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r eine Vorspeise werden?<br>\n";
		
	
			 $VorspeiseSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $VorspeiseSelect.=getVorspeisen()."\n";
             $VorspeiseSelect.="</select>\n";
			
			 echo $VorspeiseSelect;
			 echo "<br><br>\n";
			 
			 echo "<textarea id='editorVorspeise' name='editorVorspeise'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '
					</p>
				</div>
			
			</div>';

			/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :Dessert	
			
			********************************************************************************************************/


			// Dessert
		echo '<div class="tab4">
				<div class="lines">
					<h5>Dessert</h5>
					<p>';
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="dessertEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="speise"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r ein Dessert werden?<br>\n";
		
	
			 $DessertSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $DessertSelect.=getDessert()."\n";
             $DessertSelect.="</select>\n";
			
			 echo $DessertSelect;
			 echo "<br><br>\n";
			 
			  echo "<textarea id='editorDessert' name='editorDessert'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';

			/********************************************************************************************************
			
			 Beginn Tab Anlegen 
			 :kleine Speise, das soll soetwas S�lze oder Bauernfr�hst�ck sein.
			 Das sind nicht immer kleine Speisen, daher ist der Ausdruck nicht gl�cklich.

			 Im Wesentlichen w�rde so nur ein Bestandteil auf dem Teller liegen.	
			
			********************************************************************************************************/


			echo '<div class="tab5">
				<div class="lines">
					<h5>Speiseteil</h5>
					<p>';
			  echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 		
			  echo '<form method="post" action="dessertEintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textform eyecatch" type="text" name="speise"  required /><br>';
             echo '</fieldset>';
             echo "<br>\n";
			 
			 echo '<fieldset style="background:#cfcfcf; width:800px; text-align:right; padding:10px; margin-right:10px;">';
             
			 echo "Was soll es f&uuml;r eine Speiseteil werden?<br>\n";
		
	
			 $SpeiseteilSelect="\n<select class=\"auswahl eyecatch\" name=\"vorspeise\" size=\"5\" multiple>\n";
             $SpeiseteilSelect.=getBestandteil()."\n";
             $SpeiseteilSelect.="</select>\n";
			
			 echo $SpeiseteilSelect;
			 echo "<br><br>\n";
			 
			  echo "<textarea id='editorSpeiseteil' name='editorSpeiseteil'></textarea>";
  	
   		     echo '</fieldset>';


             echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>';
					echo '</p>
				</div>
			
			</div>';




		echo '</figure>
	</div>
</section>';
	
   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "	CKEDITOR.replace('editorSuppe');";
   echo "	CKEDITOR.replace('editorVorspeise');";
   echo "	CKEDITOR.replace('editorDessert');";
   echo "	CKEDITOR.replace('editorSpeiseteil');";
   echo "    </script>";
			

     include 'inc/footer.php';


	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	****************************************/

	else if ( $action == 'hauptspeiseEintragen') {

     
    
		 $speise        	 = $_REQUEST['speise'];
		 $beschreibung 		 = $_REQUEST['editor'];
		 $speiseart_id 		 = $_REQUEST['speiseart'];	
 		 // exisitert dieses Rezept schon?

		 if (!isSpeiseExist($speise)) {

		
		 // wenn nicht, dann eintragen und die ID ermitteln
		try {
	
		  $sql = "replace into speise set bezeichnung = '".$speise."', beschreibung = '".$beschreibung."', speiseart_id=".$speiseart_id." ";

          print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }

		  $speise_id = getLastSpeiseId();
		  setSpeiseInitialId($speise_id);	


     	/***

			der darf aber auch nur ausgef�hrt werden, wenn das Rezept nicht existiert.		

		Teil 2  

			// lies die restlichen Daten und trage sie mit der rezeptId in Rezeptbestandteile


		BSP f�r Transaktionen

		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 		$dbh->beginTransaction();
  		$dbh->exec("insert into staff (id, first, last) values (23, 'Joe', 'Bloggs')");
  		$dbh->exec("insert into salarychange (id, amount, changedate) 
      		values (23, 50000, NOW())");
  		$dbh->commit();
  
		} catch (Exception $e) {
  			$dbh->rollBack();
  			echo "Failed: " . $e->getMessage();
		}




		*****/

		 
		 /** im Moment sind die Selectfelder im Formular f�r Hauptspeisen 
				zwar mehrfach(multiple) ausw�hlbar 
			 an dieser Stelle erfolgt aber nur eine einfache Auswertung 
		 
			 Es m�ssen daher F�lle ber�cksichtigt werden, bei denen
			 2 Gem�se aber keine S�ttigungsbeilage oder wie beim 
			 Zigeuner kein Gem�se, daf�r eine Sauce zur Speise geh�ren.
				
			anhand des Beispiels in speisekomponente
			$zubereitungsart		= array();
	 		$zubereitungsart		= $_REQUEST['zubereitungsart'];
			// pr�fen ob der Request existiert	
			$id = isset($_GET['id'])?$_GET['id']:'';

		 */
         $hauptbeilage				= array();
		 $hauptbeilage		 		= isset($_REQUEST['hauptbeilage']) ? $_REQUEST['hauptbeilage'] : '';
			
		// $bez_hauptbeilage 			= getBezeichnungSpeisekomponente($hauptbeilage);

		 $saettigungsbeilage  		= array();
		 $saettigungsbeilage 		= isset($_REQUEST['saettigungsbeilage']) ? $_REQUEST['saettigungsbeilage'] : '';
			
		// $bez_saettigungsbeilage 	= getBezeichnungSpeisekomponente($saettigungsbeilage);	

		 $gemuesebeilage 	 		= array();
		 $gemuesebeilage 	 		= isset($_REQUEST['gemuesebeilage'])?$_REQUEST['gemuesebeilage']:'';

		// $bez_gemuesebeilage 		= getBezeichnungSpeisekomponente($gemuesebeilage);	

		 $sauce   			   		= array();
		 $sauce			     		= isset($_REQUEST['saucebeilage'])?$_REQUEST['saucebeilage']:'';

		 //$bez_sauce 		 		= getBezeichnungSpeisekomponente($sauce);	

		 // w�re das nicht sinnvoller, alle Requests in ein Array zu speichern?
		 $speisebestandteil 		= array();

		 // auf diese Art werden auch leere Arrays hinzugef�gt, wordurch es dann zu Fehlern beim Eintrag in die Datenbank kommt. 
		 array_push($speisebestandteil, $hauptbeilage, $saettigungsbeilage, $gemuesebeilage, $sauce);
  		 
		 //entfernen der leeren Elemente
		 $speisebestandteil = array_filter($speisebestandteil);
		 print_r ($speisebestandteil);	
		 echo "<br><br>";echo "<br><br>";
		 echo var_dump($_REQUEST);
		 echo "<br><br>";
		 echo var_dump($speisebestandteil);	
		 echo "<br><br>";
		 //die();

		 
		 $oLog = new Log();

	 	 $oLog->writeLog('Request eingelesen.');
	     //Log::writeLog(var_dump($_REQUEST));
  
        /* Da es sich um 3 identische Routinen handelt, lagere ich das in eine externe Funktion aus	   
		   bisher auch relativ unsinnig.
		   3 Mal hintereinander die identische Funktion auszuf�hren.	    */



	    try {

       
		  

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
 		  $db->beginTransaction();
  		  $i=0;
 
		  do {
     
			    //getBezeichnungSpeisekomponente
				$bezeichnung 		 		= isset($speisebestandteil[$i])?getBezeichnungSpeisekomponente($speisebestandteil[$i]):'';		
				print "<br>".$i.": ".$bezeichnung."<br><br>";
				if ($bezeichnung!='') {
		  			$sql ="replace into speisebestandteil set speisekomponente_id = '".$speisebestandteil[$i]."', speise_id = '".$speise_id."', bezeichnung = '". $bezeichnung."' ";
		  			print $i.": ".$sql."<br><br>";
					$oLog->writeSqlLog($sql);
		  			$db->query($sql);
		  			$sql = "update speisebestandteil set initial_id=speisebestandteil_id order by speisebestandteil_id desc Limit 1;";          
          			$db->query($sql);		  
		  			print $i.": ".$sql."<br><br>";
		 
		  			$oLog->writeSqlLog($sql);	

		   			$db->query($sql);

				}

 	     } while(++$i<count($speisebestandteil)+1);			



		
	      
		  $db->commit();
  
		  $db=null;

          }
          catch(PDOException $e){
			  $db->rollBack();
              print "<br>".$e->getMessage();
          }

		// das Rezept existiert nicht (if)
         }
		else {
 			echo "Das Rezept existiert schon!";
		}
        
          //die();
          
          $oLAkt = new LetzteAktivitaet();
		  $oLAkt -> writeLetzteAktivitaet( "wochenplan - speise eingetragen", "Es wurde der Eintrag: ".$speise." hinzugef�gt.", 1, "Rainer", 1, "wochenplan");	




			echo '<script src="window.history.back(-2);"></script>';
			 
 			/* function zurueck() {
    		     window.history.back(-2)
  			 }
  */
          header('location:../uebersicht');



    }

	/*** 
  
		Suppe eintragen
   
	***/

	/// noch zu �berarbeiten

	else if ( $action == 'suppeEintragen') {

     
    
		 $speise        	 = $_REQUEST['speise'];
		 $beschreibung 		 = $_REQUEST['editorSuppe'];
		
 		 // exisitert dieses Rezept schon?

		 if (!isSpeiseExist($speise)) {

		
		 // wenn nicht, dann eintragen und die ID ermitteln
		try {
	
		  $sql = "replace into speise set bezeichnung = '".$speise."', beschreibung = '".$beschreibung."'";

          print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }

		  $speise_id = getLastSpeiseId();
		  setSpeiseInitialId($speise_id);	



     	/***

			der darf aber auch nur ausgef�hrt werden, wenn das Rezept nicht existiert.		

		Teil 2  

			// lies die restlichen Daten und trage sie mit der rezeptId in Rezeptbestandteile



		*****/

		 
		 $suppe		 = $_REQUEST['suppe'];			
		 $bez_suppe = getBezeichnungSpeisekomponente($suppe);		   
	
      
	    try {

       
		  $sql = "replace into speisebestandteil set speisekomponente_id = '".$suppe."', speise_id = '".$speise_id."', bezeichnung = '". $bez_suppe."'  ";
		  

          print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
 		  $db->beginTransaction();
  		        

		  $db->query($sql);
		  
		  $sql = "update speisebestandteil set initial_id=speisebestandteil_id order by speisebestandteil_id desc Limit 1;";          
          print $sql."<br>";
 
		  $db->query($sql);		  	  
          
		  $db->commit();
  
		  $db=null;
		  $_SESSION['Eintrag']	= $bez_suppe.' erfolgreich eingetragen';	
          }
          catch(PDOException $e){
			  $db->rollBack();
              print "<br>".$e->getMessage();
			  $_SESSION['Eintrag']	= 'Fehler beim Eintrag der Speise';
          }

		// die Speise existiert nicht (if)
         }
		else {
 			echo "Die Speise existiert schon!";
		    $_SESSION['Eintrag']	=  "Die Speise existiert schon!";
		}
        
          //die();
          
		
        header('location:../uebersicht');



    }


	else if ( $action == "aktiv" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `rezept` Set `aktiv`=(`aktiv`-1)*-1 where `rezept_id`=".$id.";";

  
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
        header('location:../zeigeAlleRezepte') ;

	}

	else if ( $action == "loeschbar" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `rezept` Set `loeschbar`=(`loeschbar`-1)*-1 where `rezept_id`=".$id.";";

  
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
        header('location:../zeigeAlleRezepte') ;

	}




}
	
