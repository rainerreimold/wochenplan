<?php

/** 
 * @autor Rainer
 * 
 */
class DatenbankZugriff
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }

    /**
     */
    function __destruct()
    {
        
        // TODO - Insert your code here
    }

	public function fetch_assoc($sql)
	{
	    $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME , DB_USER , DB_PASS );
        $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $rueckgabe = $db->query($sql);
     
		//$ergebnis = $rueckgabe->fetchAll(PDO::FETCH_ASSOC);
	    // return $ergebnis;
		return $rueckgabe->fetchAll(PDO::FETCH_ASSOC);	   
	}

}

