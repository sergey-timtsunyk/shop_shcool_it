<?php
/**
 * User: Serhii T.
 * Date: 5/13/18
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Entity\OrderItem;
use AppBundle\Entity\Product;
use AppBundle\Service\BasketStorage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    /**
     * @var BasketStorage
     */
    private $basketStorage;

    /**
     * OrderController constructor.
     * @param BasketStorage $basketStorage
     */
    public function __construct(BasketStorage $basketStorage)
    {
        $this->basketStorage = $basketStorage;
    }

    /**
     * @Route("/order/product/{id}", name="add_product")
     */
    public function addProductAction($id)
    {
        $this->basketStorage->add($id);

        return new JsonResponse(['count' => $this->basketStorage->count()]);
    }

    /**
     * @Route("/order/product/{id}/remove", methods="DELETE", name="remove_product")
     */
    public function removeProductAction($id)
    {
        $this->basketStorage->remove($id);

        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findBy(['id' => $this->basketStorage->get()]);

        $sum = 0;
        array_walk($products, function (Product $product) use (&$sum) {
            $sum += $product->getPrice();
        });

        return new JsonResponse([
            'count' => $this->basketStorage->count(),
            'sum' => $sum,
        ]);
    }

    /**
     * @Route("/order", name="order")
     */
    public function indexAction(Request $request)
    {
        if ($this->basketStorage->count() === 0) {
            return $this->redirectToRoute('homepage');
        }

        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findBy(['id' => $this->basketStorage->get()]);

        $sum = 0;
        array_walk($products, function (Product $product) use (&$sum) {
            $sum += $product->getPrice();
        });

        $order = new Order();

        $form = $this->createFormBuilder($order)
            ->add('phone', TextType::class)
            ->add('note', TextType::class)
            ->add('address', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Confirm'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Order $order */
            $order = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($products as $product) {
                $orderItem = new OrderItem();
                $orderItem->setCount(1);
                $orderItem->setPrice($product->getPrice());
                $orderItem->setProduct($product);

                $order->addItem($orderItem);
                $entityManager->persist($orderItem);
            }

            $order->setCreateAt(new \DateTime('now'));
            $entityManager->persist($order);
            $entityManager->flush();

            $this->basketStorage->clear();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@App/order.html.twig', [
            'products' => $products,
            'sum' => $sum,
            'form' => $form->createView(),
        ]);
    }
}
