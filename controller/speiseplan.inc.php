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

//require_once './class/LetzteAktivitaet.class.php';
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
					# wochenplanspeise_id
		$sql = "Set @SPA := ".$id.";
				Set @POA := ".$von.";
				select  @SPD := wochenplanspeise_id ,@POS :=position from wochenplanspeise 
				where 
				wochenplan_id=1 
				and position = @POA+1;
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
		$sql = "Set @SPA := ".$id."; # wochenplanspeise_id
				Set @POA := ".$von.";
				select  @SPD := wochenplanspeise_id ,@POS :=position from wochenplanspeise 
				where 
				wochenplan_id=1 and 
				position = @POA-1;
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
	
