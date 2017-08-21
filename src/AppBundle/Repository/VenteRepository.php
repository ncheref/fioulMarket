<?php

namespace AppBundle\Repository;

/**
 * VenteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VenteRepository extends \Doctrine\ORM\EntityRepository
{
	
	/**
	 * Cette fonction retourne les ventes en fonction d'un code postal id, et d'un intervalle de deux dates
	 * @author ncheref
	 * @param integer $code_postal_id
	 * @param date $dateMin
	 * @param date $dateMax
	 * @return array
	 */
	public function getPricesBetweenTwoDates ($code_postal_id, $dateMin, $dateMax)
	{
		$qb = $this
					->createQueryBuilder('vente')
					->select('vente')
					->where('vente.postalCodeId = :CODE_POSTAL_ID')
					->andWhere('vente.date BETWEEN :DATE_MIN AND :DATE_MAX')
					->setParameter('CODE_POSTAL_ID', $code_postal_id)
					->setParameter('DATE_MIN', $dateMin)
					->setParameter('DATE_MAX', $dateMax);
		
		return $qb->getQuery()->getResult();
	}
}