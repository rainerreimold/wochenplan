<?php

/****

Der Speiseplan soll eine Zusammenstellung der vorhandenen Rezepte erstellen.

Im Sinne einer ausgewogenen/abwechslungsreichen Ern�hrung sollte Mo-Fr 1-2 Mal Suppe und 1 Mal Fleisch eingehalten werden.
Daf�r m�ssen nat�rlich ausreichend Rezepte vorhanden sein, was im Moment 13.04.20 noch nicht der Fall ist.


***/


session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Speiseplan- Wochenplan';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;


static $db;




function doAction( $action = '', $id = '', $von=0, $lim=0, $order='asc' ) {



	if (DEBUG) {
		echo "<br /><br />ID ".$id;
		echo "<br /><br />ACTION ".$action;
	}
	
	//$oDbName = new  DBInformation();

	//Aber die �bersicht ist doch nicht die action sondern der
	//controller.....
    
    include 'inc/header.php';
	
    if ( $action == '') {
	

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Lizenzen</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    /***

	*/


    else if ( $action == 'zeigeAlleSpeiseplaene') {
        
       try {
		echo "HIER";
               //    SELECT domain_id, domain_name FROM `domain` WHERE 1
		$sql = "Select domain_id, domain_name from domain";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Lizenzen f&uuml;r Clients</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">

          </td>
           <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Lizenz</td><td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Anzahl</td></tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $domain_id=$inhalt['domain_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"../auspraegung/zeigeAlleEigenschaftenFuerDomain/$domain_id\">".$inhalt['domain_name']."</a>";
	            
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
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
	
    else if ( $action == 'zeigeDomains') {
        
       try {
		echo "HIER";
               //    SELECT domain_id, domain_name FROM `domain` WHERE 1
		$sql = "Select domain_id, domain_name from domain";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th colspan=3 style="font-family: Fira ;color:#ddd">Lizenzen f&uuml;r Clients</th></tr>';
	        echo "<tr  style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">

          </td>
           <td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">Lizenz</td><td style=\"background:darkgrey;a color:orange;width:80px;\" class=\"odd\">Anzahl</td></tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $domain_id=$inhalt['domain_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\"><td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"auspraegung/".$domain_id."\">".$inhalt['domain_name']."</a>";
	            
	            
	 
           
                //&nbsp;&nbsp;&nbsp;<small><small><em style=\"color:red;\">(<a href=\"details/".$domain_id."\">bearbeiten</a>)</em></small></small>";
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
  
    Formular zum Erstellen eines Speiseplans
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	

	// Im Schritt 0 sollten wohl zun�chst alle bereits exitierenden Wochenpl�ne angezeigt werden?
	
	 $Wochenplaene=getAlleWochenplaene();
	/*
     $i=0;
	 echo '<h1 style="background: red; color:white;
	             padding-left:120px;">Wochenplan</h1>';
     echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">';
 
	 echo '<table width=100%><tr><th> W O C H E N P L A N</th></tr>';	
	 echo '<tr><th>Bezeichnung</th><th>Beschreibung</th></tr>';
	
	 foreach ( $Wochenplaene as $Wochenplan) {

	 echo '<tr><td>';
	 echo $Wochenplan[$i]['rid'];
	 echo '</td></tr>';
	 $i++;
     }
*/





	// Im Schritt 1 m�ssen alle Rezepte angezeigt werden.

	
		 echo '<h1 style="background: orange; color:black;
	             padding-left:120px;">Rezepte</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:700px; padding:10px; margin:10px;" class="artikelform">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>5 Rezepte ausw&auml;hlen</legend>';       
   

	         $Rezepte="\n<select class=\"auswahl eyecatch\" name=\"rezepte\" size=\"10\" multiple>\n";
             $Rezepte.=getAlleRezepte()."\n";
             $Rezepte.="</select>\n";
			
  			 echo $Rezepte;
		
       echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <button type="reset">Eingaben l&ouml;schen</button>
              <button type="submit">Absenden</button>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';

     include 'inc/footer.php';


	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	****************************************/

	else if ( $action == 'eintragen') {

     $headline      = $_POST['headline'];
     $editor        = $_POST['editor'];
    
	/*    echo '<pre>';
		var_dump($_POST);
        print_r($_POST);
        echo  '</pre>';
*/
	 //echo $editor."<br><br>";
	 

          try {

                    
              
        //    $sql = "Replace INTO `liz_anzahl_lizenz` SET `anzahl_lizenz_gesamt` = '".$anzahl."', `anzahl_lizenz_produkt_id` = '".$produkt."', `anzahl_lizenz_verfuegbar` =  '".$anzahl."', `anzahl_lizenz_innutzung` =  0, `lizenz_id` =  '".$lizenz_id."',
        //     `eingetragen` = NOW(), `anzahl_lizenz_datum` = NOW();";

		  //UPDATE `artikel_entwurf` SET `initial_id` = '1', `parent_id` = '0', `headline` = 'Mein Kind ist das H�bscheste', `eingetragen` = NOW() WHERE `artikel_entwurf`.`artikel_entwurf_id` = 1;
		
		  $sql = "replace into artikel_entwurf set headline='".$headline."', artikel_reintext = '".$editor."'";


          print $sql."<br>";
	      $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->query($sql);
          $db=null;

          }
          catch(PDOException $e){
              print "<br>".$e->getMessage();
          }


 		  // getArtikelInitialId	
           
          //die();
          

          header('location:../uebersicht');



    }



}
	
