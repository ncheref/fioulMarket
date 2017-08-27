<?php
namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use AppBundle\Entity\Vente;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class VenteService { 
	
	protected $em;
	
	public function __construct(EntityManager $em){
		$this->em = $em;
	}
	
	
	/**
	 * Charger le fichier csv contenant des objets ventes en base
	 * @param string $filename : chemin vers le fichier csv
	 * @param string $charDelimiter : d�limiteur du fichier csv
	 */
	public function uploadCsvToBd ($filename , $charDelimiter = ',') {
		
		// Tester l'accessibilit� du fichier
		$this->checkIfFileIsAccessible($filename);
		
		// R�cup�rer les ventes contenues dans le fichier
		$ventes = $this->csvToArray($filename,$charDelimiter);
		
		// Charger les ventes en base
		$this->save($ventes);
	}
	
	/**
	 * tester si un fichier existe et qu'il est accessible
	 * @param string $filename
	 * @throws NotFoundResourceException
	 * @throws \Exception
	 */
	public function checkIfFileIsAccessible ($filename) {
		//Ressource non trouv�e
		if (! file_exists($filename)){
			throw new NotFoundResourceException($filename);
		}
	
		//Ressource inaccessible
		if (! is_readable($filename)) {
			throw new \Exception($filename . 'est inaccessible');
		}
	}

	/**
	 * Retourner un tableau de ventes aliment�s depuis le fichier csv pass� en param�tre
	 * @param string $filename
	 * @param string $charDelimiter
	 * @throws FileException
	 * @return \AppBundle\Entity\Vente[]
	 */
	public function csvToArray ($filename , $charDelimiter = ',') {
		
		$header = Null;
		$arrayFromCsv = [];
		$firstLine = true;
		
		if (($handle = fopen($filename, 'r')) !== false) {
			try {
				// On continue la lecture du fichier tant qu'il y a des lignes non vides
				while (($row = fgetcsv($handle, null, $charDelimiter)) !== false) {
					
					if(!$header) {
						$header = $row;
					} else {
						$row = array_combine($header, $row);
					}
					
					if ($firstLine) {
						$firstLine = false;
						continue;
					}
						
					// Pas de validation des donn�es lues
					$arrayFromCsv [] = $this->createVente($row['postal_code_id'], $row['amount'], date_create_from_format('Y-m-d' , $row['date']));
			
				}
			
			} catch(\Exception $e){
				throw new FileException($e->getMessage());
			
			} finally {
				fclose($handle);
			}
		
		}
		
		return $arrayFromCsv;
	}
	
	
	/**
	 * Cr�er un objet vente � partir des valeurs pass�es en param�tre
	 * @param string $postal_code_id
	 * @param string $amount
	 * @param \DateTime $date
	 * @return \AppBundle\Entity\Vente
	 */
	public function createVente ($postal_code_id, $amount, \DateTime $date) {
		return new Vente($postal_code_id,$amount,$date);
	}
	
	
	/**
	 * Ins�rer les ventes contenues dans le tableau en param�tre en base
	 * @param array $ventes
	 */
	public function save ($ventes) {
		$batchSize = 100;
		$cpt = 1; 
		
		/* @var $vente Vente */ 
		foreach ($ventes as $vente) {
			$this->em->persist($vente);
			
			if ($cpt % $batchSize == 0) {
				$this->em->flush();
			}
		}
		
		$this->em->flush();
	}
	
	/**
	 * Cette fonction appelle une fonction du repository pour r�cup�rer les ventes en fonction des ses trois param�tres
	 * @author ncheref
	 * @param integer $id_code_postal
	 * @param date $dateMin
	 * @param date $dateMax
	 * @return array of Vente
	 */
	public function getVentes ($id_code_postal , $dateMin , $dateMax) {
		return $this->em->getRepository('AppBundle:Vente')->getVentesBetweenTwoDates($id_code_postal , $dateMin , $dateMax);
	}
	
	
	// Pour mes tests (faire une boucle pour trouver un $batchSize proche de l'optimum; vider la table vente � chaque tour de boucle) 
	public function supp () {
		return $this->em->getRepository('AppBundle:Vente')->supp();
	}
	
}