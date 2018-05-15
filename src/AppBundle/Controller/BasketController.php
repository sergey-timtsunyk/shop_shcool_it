<?php
/**
 * User: Serhii T.
 * Date: 5/13/18
 */

namespace AppBundle\Controller;

use AppBundle\Service\BasketStorage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BasketController extends Controller
{
    /**
     * @var BasketStorage
     */
    private $basketStorage;

    /**
     * BasketController constructor.
     * @param BasketStorage $basketStorage
     */
    public function __construct(BasketStorage $basketStorage)
    {
        $this->basketStorage = $basketStorage;
    }

    /**
     * @Route("/basket", name="basket")
     */
    public function countAction()
    {
        return new JsonResponse(['count' => $this->basketStorage->count()]);
    }
}
