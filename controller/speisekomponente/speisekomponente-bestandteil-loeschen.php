<?php
/*****************************************************************************

 speisekomponenten-bestandteil-loeschen

 Es soll ein einzelner Bestandteil eines Rezeptes f�r die Erstellung einer
 Speisekomponente gel�scht werden k�nnen.

 notwendige Daten:
 Es muss daher die ID der Speisekomponente 
 die ID der Verbindung zwischen Lebensmittel und Speisekomponente
 und letztlich auch die Initial_id der Verbindung bekannt sein, 
 damit man alle Datens�tze l�schen kann!
 Format:
 "loeschen/'.$lm_sk_verbindung_id.'/'.$lm_sk_verbindung_initial_id.'/'.$lm_sk_verbindung_parent_id.'"
 

 L�schen oder deletable:
 Schliesslich sollte man noch �berlegen, ob man ein Flag auf "l�schen" setzt
 oder den/die Eintra(e)g(e)


 Das L�schen einer gesamten Speisekomponente soll durch eine separate Funktion 
 erm�glicht werden.


 Datum 22.09.2021 

*****************************************************************************/
