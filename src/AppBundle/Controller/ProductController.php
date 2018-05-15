<?php
/**
 * User: Serhii T.
 * Date: 5/13/18
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/products", name="products")
     */
    public function indexAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();

        return $this->render('@App/products.html.twig', [
            'products' => $products
        ]);
    }
}
