<?php
namespace AppBundle\Utility;

class Utils{
	
	/**
	 * Convert a String in Array
	 * @param string $myString
	 * @param string $delimiter (default '|')
	 * @return array
	 */
	public static function convertToArray($myString,$delimiter=null){
        $delimiter = $delimiter == null ? '|': $delimiter;
		$result = array();
		if ($myString == null)
			return $result;
		
		if (strrpos($myString,$delimiter)=== false){
			$result.put($myString);
		} else {
			$result = explode($delimiter, $myString);
		}
		return $result;
	}
	/**
	 * Transforma a data de String no formato
	 * yyyy-mm-dd hh:i:ss 0000 em long
	 * @param string $date
	 * @return long
	 * 
	 * Data Type Conventions for Openfire
	 * ===================================================================
     * Date column type support varies widely across databases. 
     * Therefore, Openfire specially encodes dates as VARCHAR values. 
     * Each date is a Java long value which is 0-padded to 15 characters. 
     * The long value is the internal representation of Java Date objects,
     * which can be obtained with code such as the following (in JAVA):
     * long currentDate = new Date().getTime(); 
     * ===================================================================
	 */
	public static function dateAsLong($date = ''){
	    $dateTime= new \DateTime($date);
	    return $dateTime->getTimeStamp();
	}
}