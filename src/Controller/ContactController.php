<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends ControllerBase
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request)
    {

        $this->_data_view['controller_name'] = 'ContactController';
        return $this->render('contact/index.html.twig', $this->_data_view);
    }
}