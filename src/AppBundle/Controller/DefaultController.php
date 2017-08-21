<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/test", name="test")
     */
    public function testAction (Request $request) {
    	dump($this->getDoctrine()->getManager()->getRepository('AppBundle:Vente')->getPricesBetweenTwoDates('2073', '2015-08-01', '2017-08-01'));
    	exit;
    	return new Response();
    }
}
