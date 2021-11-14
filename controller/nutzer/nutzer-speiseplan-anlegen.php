<?php
/***********************************************************************************************

nutzer-speiseplan-anlegen:

Hinweis:

Autor: Rainer Reimold * 0151/28872748 * rainerreimold@gmx.de
Datum: 23.09.2021

***********************************************************************************************/


include 'inc/header.php';
	
	// Im Schritt 0 sollten wohl zunächst alle bereits exitierenden Wochenpläne angezeigt werden?
	
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

ich würde mir hier gern einen Schritt weiter zu gehen wünschen!
Rainer: 04.07.2021


Wenn ich einem "Schema" folge, so könnte ich am Mo und Samstag eine Suppe wählen.
Am Sonntag ein ordentliches Hauptgericht. Braten Klöße
Am Donnerstag eine Süßspeise Eierkuchen/Grißbrei 
Am Mittwoch etwas leichtes, wie ein gefülltes Omelette oder E
Dienstag: Fisch oder Nuggets
Freitag: Currywurst oder Szegediner

**/




	// Im Schritt 1 müssen alle Rezepte angezeigt werden.

	// Ich glaube, dass die Auswahl über ein multiple Formular ungünstig ist.
	// Das Auslesen wäre lösbar, aber die Zuordnung zu den Wochentagen wäre schwierig.
	// Das ist zwar im ersten Moment für das Projekt und die Bestellzettel unwichtig, dennoch 
	// stellt die App Vorschläge, aber keine Vorschrift für die möglichen Speisenpläne der Woche dar.
	
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