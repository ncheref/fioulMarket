<?php
namespace AppBundle\Util;

class Util
{
	// Vérifier que la date est conforme au format attendu par l'application AAAA-MM-JJ
	public static function validateDate($dateEnString) 
	{
		$date = \DateTime::createFromFormat('Y-m-d', $dateEnString);
		return $date && $date->format('Y-m-d') == $dateEnString;
	}
}