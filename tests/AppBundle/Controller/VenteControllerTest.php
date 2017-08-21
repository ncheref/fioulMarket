<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VenteControllerTest extends WebTestCase
{
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Go to the list view
        $crawler = $client->request('GET', '/vente/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /vente/");

        // Go to the show view
        $crawler = $client->click($crawler->selectLink('show')->link());
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code");
    }

    */
	
	public function testGetVentesOfPostalCodeIdBetweenTwoDates()
	{
		$client = static::createClient();
		
		// test avec dateMax < dateMin : la réponse doit être vide
		$crawler = $client->request('GET', '/fioulMarket/web/app_dev.php/show/ventes?id_code_postal=2073&dateMin=01-08-2015&dateMax=2015-07-02');

// 		$this->assertEquals(0,100);
	}
	
}
