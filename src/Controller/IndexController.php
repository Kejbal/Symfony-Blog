<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class IndexController extends ControllerBase
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {

        $this->_data_view['controller_name'] = 'IndexController';
        return $this->render('index/index.html.twig', $this->_data_view);
    }
}