<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, SessionInterface $session)
    {

        $session->set('order', 'weg3wrb');

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => 'hhhhhh',
        ]);

/*        return $this->renderView('index.html.twig', [

        ]);*/
    }
}
