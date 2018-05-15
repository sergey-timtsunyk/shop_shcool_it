<?php
/**
 * User: Serhii T.
 * Date: 5/15/18
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BasketStorage
{
    private $storage = 'basket';
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * BasketStorage constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        if (!$session->has($this->storage)) {
            $session->set($this->storage, []);
        }

        $this->session = $session;
    }

    /**
     * @param $id
     * @return bool
     */
    public function add($id)
    {
        $basket = $this->session->get('basket');
        if (in_array($id, $basket, true)) {
            return false;
        }

        $basket[] = $id;
        $this->session->set('basket', $basket);

        return true;
    }

    /**
     * @return array
     */
    public function get()
    {
        return $this->session->get('basket');
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->session->get($this->storage));
    }

    /**
     * @param $id
     */
    public function remove($id)
    {
        $basket = $this->session->get($this->storage);
        $key = array_search($id, $basket);

        if (array_key_exists($key, $basket)) {
            unset($basket[$key]);
        }

        $this->session->set($this->storage, $basket);
    }

    public function clear()
    {
        $this->session->set('basket', []);
    }
}
