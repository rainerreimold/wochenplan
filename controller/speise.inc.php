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

require_once './class/Log.classes.php';
//require_once './class/LetzteAktivitaet.class.php';

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
  
    kleines Formular zum hinzufügen einer Speise

	Datum: 17:05.2021

	03.07.21 EInbau zusätzliches Attribut 
		- speiseart zur Auswahl von Süßspeisen, Hauptspeisen, Suppen.
		Ziel: damit man später vermeiden kann, jeden Tag Fleischgerichte oder 5 mal in der Woche Süßspeisen zu essen.

  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		require_once("speise/speise-anlegen.php");

	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	****************************************/

	else if ( $action == 'hauptspeiseEintragen') {

     	require_once("speise/hauptspeise-eintragen.php");
    
    }

	/*** 
  
		Suppe eintragen
   
	***/

	/// noch zu überarbeiten

	else if ( $action == 'suppeEintragen') {

     	require_once("speise/suppe-eintragen.php");  
		
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
	
