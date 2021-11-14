<?php

 include 'inc/header.php';

		 echo '<h1 style="background: green; color: orange;
	             padding:20px; margin:20px;">'.getSpeiseKomponenteBezeichnung($id).'</h1>';


		 echo '<div class="eyecatch block">Das Anlegen - Bearbeiten - einer Speisekomponente ist etwas abstrakt.....
			</div>'; 

        /* Jetzt müssen die Daten aus der DB gelesen werden */ 

		 try {
		

  			$sql="SELECT distinct lm.bezeichnung as bez,
				max(lmskv.lm_sk_verbindung_id) as verbId,
				lmskv.menge as meng,
				lmskv.einheit as einh	
			 FROM 
				`lm_sk_verbindung` lmskv,
				 `lebensmittel` lm
			 WHERE 
				`speisekomponente_id` = ".$id."
			 and
				lm.lebensmittel_id in (select  lebensmittel_id From lm_sk_verbindung 
				group by initial_id )
			 and 
				lm.lebensmittel_id = lmskv.lebensmittel_id
			 group by lmskv.lebensmittel_id
			 order by lmskv.lm_sk_verbindung_id asc";



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