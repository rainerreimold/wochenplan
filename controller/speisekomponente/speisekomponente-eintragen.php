<?php
/***********************************************************************************************

speisekomponente-eintragen:

Hier werden nur neu angelegte Speisekomponenten eingetragen.

geänderte Einträge würde ich zunächst über eine andere Funktion eintragen wollen.
Es müssen dort auch die initial_id und parent_id bekannt sein und übergeben werden.



***********************************************************************************************/



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


									   
	 $bezeichnung		  	= isset($_REQUEST['bezeichnung'])?$_REQUEST['bezeichnung']:'';
	 $beschreibung		  	= isset($_REQUEST['editor'])?$_REQUEST['editor']:'';						
	 $speisekategorie		= isset($_REQUEST['speisekategorie'])?$_REQUEST['speisekategorie']:'3';
	
	 $oLog = new Log();

	 $oLog->writeLog('Request eingelesen.');
	 //Log::writeLog(var_dump($_REQUEST));
	 //die();


     try {

                    

			/* 12.05.2021 
				Schritt 1: .. Trage den Namen und Beschreibung in die Tabelle 
				Speisekomponente */
		  
			$sql = "replace into speisekomponente 
                set 
				bezeichnung 		= '".$bezeichnung."',
				beschreibung 		= '".$beschreibung."',
			    speisekategorie_id  = '".$speisekategorie."'
";	

			$oLog->writeSqlLog("##########################\n".$sql."\n");
		
			/* Schritt 2: Lies die ID des Eintrags aus. */

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
			
			print $speisekomponente_id."<br><br>";
	
			$sql = "update speisekomponente 
				    SET `initial_id` = ".$speisekomponente_id.", 
					`speisekomponente_hash` = SHA1(".$speisekomponente_id.")
					where speisekomponente_id=".$speisekomponente_id;
			
			print $sql."<br><br>";	

  		    $db->query($sql);
			$oLog->writeSqlLog($sql);
			


		 	$db->commit();
         	

         }
         catch(PDOException $e){
		 	$db->rollBack();
            print "<br>".$e->getMessage();
			$oLog->writeSqlLog("FEHLER: ".$sql);
         }


		

    	/* Schritt 3: die Arrays der ReqestVariablen müssen dynamisch über eine 
		Schleife ausgelesen und in die DB eingetragen werden.

		D

		*/ 
	/*	echo "<br>";
    	echo "<br>";
		echo ", ".$garmethode[0];
		echo "<br>";
		echo "<br>"; 
	*/	
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
						speisekomponente_id 	= '".$speisekomponente_id[$i]."',
						bezeichnung				= '',
						beschreibung			= ''; 
				";
			   
				$sql3 .="update lm_sk_verbindung set initial_id=lm_sk_verbindung_id, lm_sk_verbindung_hash=sha1(lm_sk_verbindung_id) order by lm_sk_verbindung_id desc Limit 1;"; 
				$oLog->writeSqlLog($sql3);	

			
         		$db->query($sql3);



 	     } while(++$i<count($lebensmittel));

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
          