<?php
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