<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use AppBundle\Util\Util;
use Symfony\Component\Asset\Exception\InvalidArgumentException;

/**
 * Vente controller.
 *
 */
class VenteController extends Controller
{

	/**
	 * Cette fonction d'extraire les vente en fonction d'un ID code postal et un intervalle de deux dates
	 * @author ncheref
	 * @param integer $id_code_postal code postal de la ville dont veut extraire les prix
	 * @param date $dateMin date min de l'intervalle de recherche
	 * @param date $dateMax date max de l'intervalle de recherche
	 * @Rest\View()
     * @Rest\Get("/show/ventes")
	 */
	public function getVentesOfPostalCodeIdBetweenTwoDatesAction (Request $request) {
		$id_code_postal = $request->query->get('id_code_postal');
		$dateMin = $request->query->get('dateMin');
		$dateMax = $request->query->get('dateMax');
		
		// absence de l'un des paramètres
		if (!$id_code_postal || !$dateMin || !$dateMax) {
			throw new ParameterNotFoundException('Usage: /show/ventes?id_code_postal=...&dateMin=AAAA-MM-JJ&dateMax=AAAA-MM-JJ');
		}
		
		// Si le format de date est incorrect 
		if (!Util::validateDate($dateMin) || !Util::validateDate($dateMax)) {
			throw new InvalidArgumentException('Format de date incorrect. Format attendu : AAAA-MM-JJ');
		}

		/* @var $serviceConvertCSVToArray ConvertCSVToArray */
		$serviceConvertCSVToArray = $this->get('vente_service');  
		$ventes = $serviceConvertCSVToArray->getVentes($id_code_postal, $dateMin, $dateMax);

		return $ventes;
	}
	
}
