<?php
/***********************************************************************************************

nutzer-speiseplan-anlegen:

Hinweis:

Autor: Rainer Reimold * 0151/28872748 * rainerreimold@gmx.de
Datum: 23.09.2021

***********************************************************************************************/


include 'inc/header.php';
	
	// Im Schritt 0 sollten wohl zun�chst alle bereits exitierenden Wochenpl�ne angezeigt werden?
	
	// $Wochenplaene=getAlleWochenplaene();
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



/** 

ich w�rde mir hier gern einen Schritt weiter zu gehen w�nschen!
Rainer: 04.07.2021


Wenn ich einem "Schema" folge, so k�nnte ich am Mo und Samstag eine Suppe w�hlen.
Am Sonntag ein ordentliches Hauptgericht. Braten Kl��e
Am Donnerstag eine S��speise Eierkuchen/Gri�brei 
Am Mittwoch etwas leichtes, wie ein gef�lltes Omelette oder E
Dienstag: Fisch oder Nuggets
Freitag: Currywurst oder Szegediner

**/




	// Im Schritt 1 m�ssen alle Rezepte angezeigt werden.

	// Ich glaube, dass die Auswahl �ber ein multiple Formular ung�nstig ist.
	// Das Auslesen w�re l�sbar, aber die Zuordnung zu den Wochentagen w�re schwierig.
	// Das ist zwar im ersten Moment f�r das Projekt und die Bestellzettel unwichtig, dennoch 
	// stellt die App Vorschl�ge, aber keine Vorschrift f�r die m�glichen Speisenpl�ne der Woche dar.
	
		 echo '<h1 style="background: orange; color:black;
	             padding:20px;">Eigener Speiseplan</h1>';
         echo '<div class="form" style="width:1150px; text-align:right; padding:10px; margin:10px auto auto auto;">

         <form method="post" action="eintragen" style="width:1100px; padding:10px; margin:10px;" class="artikelform">
           <fieldset style="background:#cfcfcf; width:1050px; text-align:right; padding:10px; padding-right:100px;margin:10px;">
           <legend>5 Rezepte ausw&auml;hlen</legend>';       
   
		    // echo '<label>Wochenplan: </label><input class="textform eyecatch" type="text" name="bezeichnung"  required /><br>';

			 // alle Speisen vorselektiert nach einem Schema 04.07.21

		     $RezepteMo="\n<label>Montag: </label>
				<input class=\"textform eyecatch\" type=\"text\" name=\"Montag\" placeholder=\"!\"  /><br>";

  			 echo $RezepteMo;
						

			 $RezepteDi="\n<label>Dienstag: </label>
				<input class=\"textform eyecatch\" type=\"text\" name=\"Dienstag\" placeholder=\"!\"  /><br>";
		
			 echo $RezepteDi;
			 
			 $RezepteMi="\n<label>Mittwoch: </label>
				<input class=\"textform eyecatch\" type=\"text\" name=\"Mittwoch\" placeholder=\"!\"  /><br>";
		
  			 echo $RezepteMi;
		 	 $RezepteDo="\n<label>Donnerstag: </label>
				<input class=\"textform eyecatch\" type=\"text\" name=\"Donnerstag\" placeholder=\"!\"  /><br>";
	
  			 echo $RezepteDo;
	
			 $RezepteFr="\n<label>Freitag: </label>
				<input class=\"textform eyecatch\" type=\"text\" name=\"Freitag\" placeholder=\"!\"  /><br>";

  			 echo $RezepteFr;
		
				// Wochenende
	

			 $RezepteSa="\n<label>Samstag: </label>
				<input class=\"textform eyecatch\" type=\"text\" name=\"Samstag\" placeholder=\"!\"  /><br>";

  			 echo $RezepteSa;

			 $RezepteSo="\n<label>Sonntag: </label>
				<input class=\"textform eyecatch\" type=\"text\" name=\"Sonntag\" placeholder=\"!\"  /><br>";
	 	
			 echo $RezepteSo;


	   echo ' </fieldset>';
	
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