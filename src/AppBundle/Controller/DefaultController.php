<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Util\Util;

class DefaultController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function testAction (Request $request) {
    	
    	dump(Util::validateDate('15-02-2015'));//false
    	dump(Util::validateDate('15/02/2015'));//false
    	dump(Util::validateDate('2015-02-15'));//true
    	dump(Util::validateDate('2015/02/15'));//false
    	dump(Util::validateDate('TOTO'));//false
    	
//     	dump($this->getDoctrine()->getManager()->getRepository('AppBundle:Vente')->getVentesBetweenTwoDates('2073', '2015-08-01', '2017-08-01'));
    	exit;
    	return new Response();
    }
}
