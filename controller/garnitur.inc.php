<?php
/*******************************************************************
  Garnitur

  es bedarf auch einer separaten Ansicht zwischen 
  details und bearbeiten
 
  11.05.2021

  Die Daten kommen von hotelfach.de ... sind aber unvollständig.

  Es fehlen z.B:
  - Strindberg
  - Braumeister
  - Esterhazy	

********************************************************************/

session_start();


require_once './inc/global_config.inc.php';
$_SESSION['title'] = 'Rezepte - Verwaltung von Garnituren';
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
	
    if ( $action == '') {

		$db = $id;
		if ($_SESSION['start']==false) {
    		$_SESSION['start']=true;
			echo "<h1>Ingredenzien</h1>";
			echo "<h2>Ansatz?</h2>";

			die();
		}

	}

	/** Eintrag sollte gelöscht werden können 
		03.05.20 

	*/

    else if ( $action == 'zeigeAlleGarnituren') {
        
        include 'inc/header.php';
	    
  		try {
		  
		$sql = "SELECT Distinct `garnitur_id`,`garnitur_bezeichnung`,`beschreibung`, garnitur_art FROM `garnitur` where 1 order By `garnitur_id` asc";

		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
	        
	        
	        echo "<table  style=\"background:#777;padding:4px;border:1px;\"   cellpadding=\"6\" cellspacing=\"1\">";
	        echo '<tr style="padding:8px;"><th style="font-family: Fira ;color:#ddd">Garnituren f&uuml;r Lebensmittel</th>';

			echo '</tr>';
	        echo "<tr style=\"padding:8px;\"><td style=\"background:darkgrey;a color:orange;width:350px;\" class=\"odd\">
            Bezeichnung
            </td>";

          echo "</tr>";
	        foreach ($ergebnis as  $inhalt)
	        {
	            $garnitur_id=$inhalt['garnitur_id'];
	            
	            echo "<tr style=\"border:1px dotted black;\">";
				echo "<td style=\"background:lightgrey;a color:orange;width:350px;padding:6px;\" class=\"odd\">";
	            
	            echo "<a href=\"/wochenplan/garnitur/details/$garnitur_id\">".$inhalt['garnitur_bezeichnung']."</a>";
	            
	            echo "</td>";
				echo "</tr>";
	        }
	        
	    }
	    catch(PDOException $e){
	        print $e->getMessage();
	    }
	    echo "</table>";
	    $db=null;
	    
        //echo "<br><a href=\"anlegen\">neue Garnitur anlegen</a><br>";
      

		if (DEBUG) {
			echo "<br /><br />action= $action<br /><br />";
			echo "<br /><br />id= $id<br /><br />";
		}




		include 'inc/footer.php';
	}
	
	else if ( $action == 'bearbeiten') {
     
       include 'inc/header.php';        

       try {
		 
		$sql = "Select garnitur_bezeichnung, beschreibung from garnitur where garnitur_id = ".$id;


		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
		  $bezeichnung = $ergebnis[0]['garnitur_bezeichnung'];
		  $beschreibung = $ergebnis[0]['beschreibung'];
 
		 echo '<h1 style="background: orange;
	             padding-left:120px;">Garnitur</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="../eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>'.$bezeichnung.'</legend>';  

		 echo "<input type=\"hidden\" name=\"garnitur_id\" value=\"".$id."\">";     

         echo "<label>Garnitur: </label><input class=\"textform eyecatch\" type=\"text\" name=\"garnitur\"  value=\"".$bezeichnung."\" required /><br>";
         echo '</fieldset>';
         echo "<br>\n";

		echo "<textarea id='editor' name='editor'>".$beschreibung."</textarea>";


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

   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "</script>";
			

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


    else if ( $action == 'details') {
     
       include 'inc/header.php';        

       try {
		 
		$sql = "Select garnitur_bezeichnung, beschreibung from garnitur where garnitur_id = ".$id;


		if (DEBUG) echo "<br>".$sql."<br>";
       
	 
          $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
          $rueckgabe = $db->query($sql);
          
		  $ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	        
		  $bezeichnung = $ergebnis[0]['garnitur_bezeichnung'];
		  $beschreibung = $ergebnis[0]['beschreibung'];
 
		 echo '<h1 style="background: orange;
	             padding-left:120px;">Garnitur</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="../eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>'.$bezeichnung.'</legend>';  

		 echo "<input type=\"hidden\" name=\"garnitur_id\" value=\"".$id."\">";     

         echo "<label>Garnitur: </label>";
		 echo "<input class=\"textform eyecatch\" type=\"text\" name=\"garnitur\"  value=\"".$bezeichnung."\" required /><br>";
         echo '</fieldset>';
         echo "<br>\n";

		echo '<div class="block">'.$beschreibung.'</div>';
		//echo "<textarea id='editor' name='editor'>".$beschreibung."</textarea>";

         echo ' <fieldset style="background:#cfcfcf; text-align:right; padding:10px; margin-right:10px;">
              <a href="../zeigeAlleGarnituren">zur&uuml;ck</a>
            </fieldset>
          </form>
       </div>
       <br>
       <br>
       <br>
       <br>';

   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "</script>";
			

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
  
    kleines Formular zum hinzufügen einer Garnitur
  
	*****************************************/
  	
    else if ( $action == 'anlegen') {
  	
		 include 'inc/header.php';

		 echo '<h1 style="background: orange;
	             padding-left:120px;">Ingredienz</h1>';
         echo '<div class="form" style="width:750px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:700px; padding:10px; margin:10px;">
           <fieldset style="background:#cfcfcf; width:500px; text-align:right; padding:10px; margin-right:10px;">
           <legend>Ingredienz anlegen</legend>';       
         echo '<label>Ingredienz: </label><input class="textform eyecatch" type="text" name="ingredienz"  required /><br>';
         echo '</fieldset>';
         echo "<br>\n";

		echo "<textarea id='editor' name='editor'></textarea>";


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

   echo '<script type="text/javascript">';
   echo "	CKEDITOR.replace('editor');";
   echo "</script>";
			

     include 'inc/footer.php';


	}


	/***************************************

	 Eintragen der Ingredienz 01.05.2020

	****************************************/

	else if ( $action == 'eintragen') {

     
     $ingredienz    = $_REQUEST['ingredienz'];
	 $beschreibung  = $_REQUEST['editor'];
	 $ingredienz_id = isset($_REQUEST['ingredienz_id'])?$_REQUEST['ingredienz_id']:null;
	 if (DEBUG) print "<br><br><br>$ingredienz_id<br><br>";

     try {

	 	  $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          if(!$ingredienz_id) { 

		  	$sql = "replace into ingredienz set bezeichnung = '".$ingredienz."', beschreibung='".$beschreibung."' ";
          	//print $sql."<br>";
		  	$db->beginTransaction();          

		  	$db->query($sql);

	      	$sql="update ingredienz set initial_id = ingredienz_id order by ingredienz_id desc limit 1";		
		  	$db->query($sql);
				
   		  	$db->commit();
          	
		  } else {

		    $sql="update ingredienz set bezeichnung = '".$ingredienz."', beschreibung='".$beschreibung."' where ingredienz_id=".$ingredienz_id;		
           	//print $sql."<br>";
			$db->beginTransaction();          
		  	$db->query($sql);
			$db->commit();
          	
		   }
		  $db=null;
 	
          }
          catch(PDOException $e){
            $db->rollBack();  
			print "<br>".$e->getMessage();
          }



        
          //die();
          

          header('location:../uebersicht');



    }

	else if ( $action == "aktiv" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `ingredienz` Set `aktiv`=(`aktiv`-1)*-1 where `ingredienz_id`=".$id.";";

  
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
        header('location:../zeigeAlleIngredienzien') ;

	}

	else if ( $action == "loeschbar" ) {

	 
        try {
		  // einfacher Switch	
          $sql = "update `ingredienz` Set `loeschbar`=(`loeschbar`-1)*-1 where `ingredienz_id`=".$id.";";

  
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
        header('location:../zeigeAlleIngredienzien') ;

	}


}
	
