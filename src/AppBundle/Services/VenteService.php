<?php
namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use AppBundle\Entity\Vente;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Symfony\Component\Console\Style\SymfonyStyle;

class VenteService { 
	
	protected $em;
	
	public function __construct(EntityManager $em){
		$this->em = $em;
	}
	
	/**
	 * Fonction qui charge les ventes contenues dans le fichier en paramètre en base
	 * @author ncheref
	 * @param string $filename : le chemin vers le fichier
	 * @param string $charDelimiter : le délimiteur, qui est par défaut à ,
	 * @throws NotFoundResourceException : si le fichier est introuvable
	 * @throws \Exception : si les fichier est inaccessible
	 * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException : en cas d'erreur pendant la lecture
	 * @return number 200 en cas de succès du chargement
	 */
	public function upload($filename , $charDelimiter = ',' , SymfonyStyle $io = null) { 
		
		//Ressource non trouvée
		if (! file_exists($filename)){
			throw new NotFoundResourceException($filename);
		}
		
		//Ressource inaccessible
		if (! is_readable($filename)) {
			throw new \Exception($filename . 'est inaccessible');
		}
		
		$batchSize = 800;
		$ligne = 1;
		$header = Null;
		
		if (($handle = fopen($filename, 'r')) !== false) {
			
			try {
				// On continue la lecture du fichier tant qu'il y a des lignes non vides
				while (($row = fgetcsv($handle, null, $charDelimiter)) !== false) {
					
					// Convertir les données en UTF-8
// 					$row = array_map("utf8_encode", $row);
					
					// Supression des espaces
// 					$row = array_map("trim", $row);
					
					if(!$header) {
						$header = $row;
					} else {
						$row = array_combine($header, $row);
					}
					
					
					if ($ligne != 1) {
						$vente = new Vente();
						$vente->setPostalCodeId($row['postal_code_id']);
						$vente->setAmount($row['amount']);
						$vente->setDate(date_create_from_format('Y-m-d' , $row['date']));
						$this->em->persist($vente);
					}
					
					// flush par lots
					if (($ligne % $batchSize) == 0) {
						// Mettre à jour la progress bar 
						$io->progressAdvance($batchSize);
						
						$this->em->flush();
						$this->em->clear();
					}
					
					$ligne++;
					
					
				}
				
			} catch(\Exception $e){
				throw new FileException($e->getMessage());
				
			} finally {
				fclose($handle);
			}
		}
		
		$this->em->flush();
		$this->em->clear();
		
		$io->progressFinish();
		
		return 200; //succès 
	}
	
	/**
	 * Cette fonction appelle une fonction du repository pour récupérer les ventes en fonction des ses trois paramètres
	 * @author ncheref
	 * @param integer $id_code_postal
	 * @param date $dateMin
	 * @param date $dateMax
	 * @return array of Vente
	 */
	public function getVentes ($id_code_postal , $dateMin , $dateMax) {
		return $this->em->getRepository('AppBundle:Vente')->getPricesBetweenTwoDates($id_code_postal , $dateMin , $dateMax);
	}
	
	
	// Pour mes tests (faire une boucle pour trouver un $batchSize proche de l'optimum; vider la table vente à chaque tour de boucle) 
	public function supp () {
		$q = $this->em->createQuery('delete from AppBundle:Vente v');
		$q->execute();
	}
	
}