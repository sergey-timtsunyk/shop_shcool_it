<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@App/homepage.html.twig', []);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        $about = 'Поможем выбрать, не дадим скучать! Наша задача состоит не только в том, чтобы просто продать нужный товар, но и в том, чтобы информировать и просвещать покупателя. Для этого мы снимаем видеообзоры новинок, готовим статьи и новости. Вооружившись всесторонней информацией об интересном устройстве и его главных конкурентах, вы сможете самостоятельно принять взвешенное решение о покупке именно того товара, который вам нужен.';
        return $this->render('@App/about.html.twig',
            ['about' => $about]
        );
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('@App/contact.html.twig',
            ['contact' => 'Адрес: г. Киев']
        );
    }
}
