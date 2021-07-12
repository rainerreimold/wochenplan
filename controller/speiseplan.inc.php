<?php

/****

Der Speiseplan soll eine Zusammenstellung der vorhandenen Rezepte erstellen.

Im Sinne einer ausgewogenen/abwechslungsreichen Ernährung sollte Mo-Fr 1-2 Mal Suppe und 1 Mal Fleisch eingehalten werden.
Dafür müssen natürlich ausreichend Rezepte vorhanden sein, was im Moment 13.04.20 noch nicht der Fall ist.

Nach gut einem Jahr Unterbrechung muss ich den Ansatz erneuern.
Ich beginne mit dem 

1. Anlegen
2. Eintragen 
3. Anzeigen
4. Änderung 



***/


session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Speiseplan- Wochenplan';
$_SESSION['start'] = isset($_SESSION['start'])?$_SESSION['start']:false;

require_once './class/LetzteAktivitaet.class.php';

require_once './class/Log.classes.php';
static $db;




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
			echo "<h1>Lizenzen</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}



		}

    /***

	*/


    else if ( $action == 'zeigeAlleSpeiseplaene') {
  
		require_once("speiseplan/zeigeAlleSpeiseplaene.php");

	}
	
    else if ( $action == 'zeigeDomains') {

           include 'inc/header.php';
	
       try {
		//echo "HIER";
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
  	
       require_once("speiseplan/speiseplan-anlegen.php");

	}


	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	Überarbeitung: 09.07.2021
	Autor: Rainer

	****************************************/

	else if ( $action == 'eintragen') {

    	require_once("speiseplan/speiseplan-eintragen.php");

    }

	else if ( $action == 'wechselrunter') {

		$oLog = new Log();

		$sql = "Set @SPA := ".$id.";
				Set @POA := ".$von.";
				select  @SPD := speise_id ,@POS :=position from wochenplanspeise where wochenplan_id=1 and position = @SPA+1;
				Update wochenplanspeise set position = @POS where wochenplanspeise_id = @SPA;
				Update wochenplanspeise set position = @POA where wochenplanspeise_id = @SPD;";	
		 try {

			$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
    		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        		
    		$db->beginTransaction();	
   		
			
			$oLog->writeSqlLog("##########################\n".$sql."\n");
    		//print "SQL: ".$sql."<br>\n";

			//die();
			
			$db->query($sql);
    		$db->commit();
			$db=null;
  		}
  		catch(PDOException $e){
    		print "<br>".$e->getMessage();
  		}	
        header('location:../../zeigeAlleSpeiseplaene') ;

	}
	
	
	
	else if ( $action == 'wechselhoch') {

		$oLog = new Log();
		$sql = "Set @SPA := ".$id.";
				Set @POA := ".$von.";
				select  @SPD := speise_id ,@POS :=position from wochenplanspeise where wochenplan_id=1 and position = @SPA-1;
				Update wochenplanspeise set position = @POS where wochenplanspeise_id = @SPA;
				Update wochenplanspeise set position = @POA where wochenplanspeise_id = @SPD;";	
		 try {

			$db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
    		$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        		
    		$db->beginTransaction();	
   		
    		//print "SQL: ".$sql."<br>\n";

			//die();
			$oLog->writeSqlLog("##########################\n".$sql."\n");
			$db->query($sql);
    		$db->commit();
			$db=null;
  		}
  		catch(PDOException $e){
    		print "<br>".$e->getMessage();
  		}	


 	   header('location:../../zeigeAlleSpeiseplaene') ;

	}
    

}
	
