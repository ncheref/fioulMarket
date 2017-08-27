<?php

namespace AppBundle\Command; 

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use AppBundle\Services\VenteService;


class importCSVCommand extends ContainerAwareCommand { 
	
	protected function configure() { 
		$this
			->setName('demo:importCSV')
			->setDescription('Usage: demo:importCSV pathToFile - Importer le fichier CSV en parametre')
			->addArgument(
				'pathToFile',
				InputArgument::REQUIRED,
				'Le chemin vers le fichier a importer'
			); 
	}
	
	
	protected function execute(InputInterface $input, OutputInterface $output) { 
		$io = new SymfonyStyle($input, $output); 
		
		// Récupérer le filename passé en argument 
		$filename = $input->getArgument('pathToFile');
		
		$io->title('Chargement du fichier "' . $filename .'" en cours ...');
		
		$debut = microtime(true);
		
		/* @var $venteService VenteService */  
		$venteService = $this->getContainer()->get('vente_service');
		
		try{
			$venteService->uploadCsvToBd($filename,',');

		} catch(Exception $e) {
			$io->error($e->getMessage());
		}
		
		$fin = microtime(true);
		
		$duree = $fin - $debut;
		
		$io->success('Fin du chargement ... Temps: ' . $duree . ' secondes' );
	}
	
}