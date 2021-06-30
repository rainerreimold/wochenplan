<?php
/*********************************************************************************************************************
 Name: speise.inc.php
 Typ: Controller
 Ziel: Das Erstellen einer Speise, erfolgt durch die Auswahl verschiedener Speiekomponenten. Diese werden so zu 
	   Bestandteilen der Speise. 
	   Mit diesem Ansatz sollten nunmehr auch ungewöhnlichere Kombinationen möglich sein, die zugleich aufgrund 
	   der jeweiligen Mengenangaben auch durchkalkuliert werden könnten.


 Aufruf: ... erfolgt indirekt über die .htaccess	an controller.php, der mit parameter den betreffenden Controller 
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


static $db;




function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die Übersicht ist doch nicht die action sondern der
	//controller.....
    
    /* Den Header können wir leider nicht mehr zentral einbinden,
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
				// innere Abfrage der Speise, nach den zugehörigen Speisebestandteilen 
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

 Das Detail für Speisen geht hier natürlich völlig ab.

 Orientiert an der vorhandener Speise anlegen, muss hier im 
 
 1. Schritt 
 - festgestellt werden, um welche Art von Speise es sich handelt.
 
 2. Damit erfolgt die Auswahl/Aktivierung des Formulars und

 3. mit den Rezeptbestandteilen werden diese ausgelesen und in dem Formular angezeigt. 

 Wichtig! 
 ---> Soll die Darstellung / Detail des Rezeptes und die Bearbeitung unterschieden werden?

 Im Prinzip schon, denn die Anzeige sollte für jeden Nutzer möglich sein, die Bearbeitung aber nur für einen 
 berechtigten Personenkreis.




**/


	
    else if ( $action == 'details') {
        
	      include 'inc/header.php';
	

       try {
		//echo "HIER";
               //    SELECT domain_id, domain_name FROM `domain` WHERE 1
		$sql = "SELECT * FROM `rezept` WHERE `rezept_id` = $id";

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
	            $rezept_id=$id;
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"auspraegung/".$rezept_id."\">".$inhalt['beschreibung']."</a>";
	            echo "</td><td>";
				//echo "<a href=\"auspraegung/".$rezept_id."\">".$inhalt['beschreibung']."</a>";
	            
/***	 

AN DIESER STELLE SOLLTE DER REKURSIVE AUFRUF UND ANZEIGE DER REZEPTBESTANDTEILE ERFOLGEN

***/


/* */

				$sql2 = "SELECT distinct rt.rezeptteil_id,rt.aktiv, sk.speisekomponente_id as skid, sk.bezeichnung as skbez FROM `rezept` rez, `rezeptteil` rt,`speisekomponente` sk
				WHERE rt.rezept_id=$id
				and rt.aktiv=1 
				and rt.rezept_id = rez.rezept_id
				and sk.speisekomponente_id = rt. speisekomponente_id";

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
  
    kleines Formular zum hinzufügen einer Speise

	Datum: 17:05.2021
  
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
					
		      // Formular Hauptspeise	
			  echo '<div class="form" style="width:1000px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 			
			  echo '<form method="post" action="hauptspeiseEintragen" style="width:60px; padding:10px; margin:10px;">

                <fieldset style="background:#cfcfcf; width:950px; text-align:right; padding:10px; margin-right:10px;">
                <legend>Rezept anlegen</legend>';       
             echo '<label>Rezept: </label><input class="textformsuppe" type="text" name="speise" placeholder="xxx.xx" required /><br>';
             
             echo "<br>\n";
			// echo "Was soll es f&uuml;r ein Rezept werden?<br>\n";
		

			 $HauptbeilageSelect="\n<select class=\"auswahl2\" name=\"hauptbeilage\" size=\"5\" multiple>\n";
             $HauptbeilageSelect.=getHauptBeilage()."\n";
             $HauptbeilageSelect.="</select>\n";
			
			 echo $HauptbeilageSelect;

			 $SaettigungsbeilageSelect="\n<select class=\"auswahl2\" name=\"saettigungsbeilage\" size=\"5\" multiple>\n";
             $SaettigungsbeilageSelect.=getSaettigungsBeilage()."\n";
             $SaettigungsbeilageSelect.="</select>\n";
			
			 echo $SaettigungsbeilageSelect;

			 $GemuesebeilageSelect="\n<select class=\"auswahl2\" name=\"gemuesebeilage\" size=\"5\" multiple>\n";
             $GemuesebeilageSelect.=getGemueseBeilage()."\n";
             $GemuesebeilageSelect.="</select>\n";
			
			 echo $GemuesebeilageSelect;

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


			// Suppe	
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

			// kleine Speisen
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

			der darf aber auch nur ausgeführt werden, wenn das Rezept nicht existiert.		

		Teil 2  

			// lies die restlichen Daten und trage sie mit der rezeptId in Rezeptbestandteile


		BSP für Transaktionen

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

		 
		 $hauptbeilage		 = $_REQUEST['hauptbeilage'];			
		 $bez_hauptbeilage = getBezeichnungSpeisekomponente($hauptbeilage);		   
		 $saettigungsbeilage = $_REQUEST['saettigungsbeilage'];
		 $bez_saettigungsbeilage = getBezeichnungSpeisekomponente($saettigungsbeilage);	
		 $gemuesebeilage 	 = $_REQUEST['gemuesebeilage'];
		 $bez_gemuesebeilage = getBezeichnungSpeisekomponente($gemuesebeilage);			
  
        /* Da es sich um 3 identische Routinen handelt, lagere ich das in eine externe Funktion aus */	   
   



	    try {

       
		  $sql ="replace into speisebestandteil set speisekomponente_id = '".$hauptbeilage."', speise_id = '".$speise_id."', bezeichnung = '". $bez_hauptbeilage."' ";
		  

          print $sql."<br>";

          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		  
 		  $db->beginTransaction();
  		        

		  $db->query($sql);
		  $sql = "update speisebestandteil set initial_id=speisebestandteil_id order by speisebestandteil_id desc Limit 1;";          
          $db->query($sql);		  
		  print $sql."<br>";
				


		  $sql = "replace into speisebestandteil set speisekomponente_id = '".$saettigungsbeilage."', speise_id = '".$speise_id."', bezeichnung = '". $bez_saettigungsbeilage."' ";
		  $db->query($sql);
		  $sql = "update speisebestandteil  set initial_id=speisebestandteil_id order by speisebestandteil_id desc Limit 1;";          
          $db->query($sql);		  
		  print $sql."<br>";
          

		  $sql = "replace into speisebestandteil set speisekomponente_id = '".$gemuesebeilage."', speise_id = '".$speise_id."' , bezeichnung = '". $bez_gemuesebeilage."'";
		  $db->query($sql);
		  $sql = "update speisebestandteil  set initial_id=speisebestandteil_id order by speisebestandteil_id desc Limit 1;";          
	      $db->query($sql);		  
		  print $sql."<br>";
    	
	      
		  $db->commit();
  
		  $db=null;

          }
          catch(PDOException $e){
			  $dbh->rollBack();
              print "<br>".$e->getMessage();
          }

		// das Rezept existiert nicht (if)
         }
		else {
 			echo "Das Rezept existiert schon!";
		}
        
          //die();
          

			echo '<script src="window.history.back(-2);"></script>';
			 
 			/* function zurueck() {
    		     window.history.back(-2)
  			 }
  */
          //header('location:../uebersicht');



    }

	/*** 
  
		Suppe eintragen
   
	***/

	/// noch zu überarbeiten

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

			der darf aber auch nur ausgeführt werden, wenn das Rezept nicht existiert.		

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
	
