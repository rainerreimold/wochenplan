<?php

	/***************************************

	Das eigentliche Eintragen erfolgt erst hier

	Überarbeitung: 09.07.2021
	Autor: Rainer

	****************************************/

 	 $bezeichnung     = isset($_POST['bezeichnung'])?$_POST['bezeichnung']:'';
	 $bezeichnung     = htmlspecialchars($bezeichnung);
     $editor          = isset($_POST['editor'])?$_POST['editor']:'';
	 $editor          = htmlspecialchars($editor);	

	 $rezeptMo        = isset($_POST['rezeptMo'])?$_POST['rezeptMo']:'';
	 $rezeptDi        = isset($_POST['rezeptDi'])?$_POST['rezeptDi']:'';
 	 $rezeptMi        = isset($_POST['rezeptMi'])?$_POST['rezeptMi']:'';
	 $rezeptDo        = isset($_POST['rezeptDo'])?$_POST['rezeptDo']:'';
	 $rezeptFr        = isset($_POST['rezeptFr'])?$_POST['rezeptFr']:'';
	 $rezeptSa        = isset($_POST['rezeptSa'])?$_POST['rezeptSa']:'';
	 $rezeptSo        = isset($_POST['rezeptSo'])?$_POST['rezeptSo']:'';

	/*
		echo '<pre>';
		var_dump($_POST);
        print_r($_POST);
        echo  '</pre>';
    */ 
	 //echo $editor."<br><br>";
	 
     try {

          // $sql = "replace into wochenplan set rezept_id_mo= '".$rezeptMo."',rezept_id_di= '".$rezeptDi."',rezept_id_mi= '".$rezeptMi."',
		  //		rezept_id_do= '".$rezeptDo."',rezept_id_fr= '".$rezeptFr."',  bezeichnung='".$bezeichnung."', beschreibung = '".$editor."'";

		  $sql = "replace into wochenplan set bezeichnung='".$bezeichnung."', beschreibung='".$editor."'; ";
          print $sql."<br><br>";
	      $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
          $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->beginTransaction();
		  $db->query($sql);

		  $sql = "update wochenplan set initial_id=wochenplan_id order by wochenplan_id desc Limit 1;";
		
		  print $sql."<br><br>";
 	      $db->query($sql);

		  $sql = "select @WOP := wochenplan_id from wochenplan order by wochenplan_id desc Limit 1;
				  replace into wochenplanspeise set wochenplan_id =	@WOP, speise_id = ".$rezeptMo.", position=1;
				  update wochenplanspeise set initial_id=wochenplanspeise_id order by wochenplanspeise_id desc Limit 1;	
				  replace into wochenplanspeise set wochenplan_id =	@WOP, speise_id = ".$rezeptDi.", position=2;
				  update wochenplanspeise set initial_id=wochenplanspeise_id order by wochenplanspeise_id desc Limit 1;
				  replace into wochenplanspeise set wochenplan_id =	@WOP, speise_id = ".$rezeptMi.", position=3;
				  update wochenplanspeise set initial_id=wochenplanspeise_id order by wochenplanspeise_id desc Limit 1;
				  replace into wochenplanspeise set wochenplan_id =	@WOP, speise_id = ".$rezeptDo.", position=4;
				  update wochenplanspeise set initial_id=wochenplanspeise_id order by wochenplanspeise_id desc Limit 1;
				  replace into wochenplanspeise set wochenplan_id =	@WOP, speise_id = ".$rezeptFr.", position=5;
				  update wochenplanspeise set initial_id=wochenplanspeise_id order by wochenplanspeise_id desc Limit 1;
				  replace into wochenplanspeise set wochenplan_id =	@WOP, speise_id = ".$rezeptSa.", position=6;
				  update wochenplanspeise set initial_id=wochenplanspeise_id order by wochenplanspeise_id desc Limit 1;
				  replace into wochenplanspeise set wochenplan_id =	@WOP, speise_id = ".$rezeptSo.", position=7;
				  update wochenplanspeise set initial_id=wochenplanspeise_id order by wochenplanspeise_id desc Limit 1;
				";

		  	print $sql."<br><br>";
		  	$db->query($sql);	

		  	$db->commit();
  	
          	$db=null;
		  	$_SESSION['Eintrag']	= $bezeichnung.' erfolgreich eingetragen';	
          }
          catch(PDOException $e){
			  $db->rollBack();
              print "<br>".$e->getMessage();
			  $_SESSION['Eintrag']	= $bezeichnung.' konnte nicht eingetragen werden!!';
          }


 		  // getArtikelInitialId	
           
          //die();
          
		  $_SESSION['Eintrag']	= $bezeichnung.' erfolgreich eingetragen';
          header('location:../uebersicht');