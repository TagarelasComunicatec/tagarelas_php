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
			return result();
		
		if (strrpos($myString,$delimiter)=== false){
			$result.put($myString);
		} else {
			$result = explode($delimiter, $myString);
		}
		return $result;
	}
}