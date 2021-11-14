<?php
/******************************************************************************************************************************

Die Datei ist falsch... hier muss der EIntrag erfolgen.



*******************************************************************************************************************************/

         $speise        	 = $_REQUEST['speise'];
		 $beschreibung 		 = $_REQUEST['editor'];
		
 		 // exisitert dieses Rezept schon?

		 if (!isSpeiseExist($speise)) {

		
		 // wenn nicht, dann eintragen und die ID ermitteln
		try {
	
		  $sql = "replace into speise set bezeichnung = '".$speise."', beschreibung = '".$beschreibung."', speiseart_id=1 ";

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

