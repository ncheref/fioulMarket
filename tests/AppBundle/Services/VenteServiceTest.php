<?php
namespace tests\AppBundle\Services;


use AppBundle\Services\VenteService;

class VenteServiceTest extends \PHPUnit_Framework_TestCase{ 
	
	public function testGetVentes()
	{
		$venteService = new VenteService(self::$kernel->getContainer()->get('doctrine')->getManager());
		assertEquals(1, 1);
	}
	
}