<?php

namespace App\Controller;

use App\Repository\ConfigRepository;
use App\Repository\GroupConfigRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends ControllerBase
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer, ConfigRepository $config, GroupConfigRepository $groupConfig)
    {

        if ($_POST) {
            if ($request->request->get('name') && $request->request->get('email') && $request->request->get('phone') && $request->request->get('message')) {

                $groupConfig = $groupConfig->findOneBy(['name' => 'Mail']);
                $contactMail = $config->findOneBy(['groupConfig' => $groupConfig->getId(), 'base' => 'contact_mail']);

                $message = (new \Swift_Message('Contact from  webpage'))
                    ->setFrom($request->request->get('email'))
                    ->setTo($contactMail->getValue())
                    ->setBody(
                        $request->request->get('message')
                    );

                $result = $mailer->send($message, $errors);

                $arrData = ['success' => $result];
                return new JsonResponse($arrData);
            }
        }

        $this->_data_view['controller_name'] = 'ContactController';
        return $this->render('contact/index.html.twig', $this->_data_view);
    }

    public function mail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('testkejbal@gmail.com')
            ->setTo('kejbal@gmail.com')
            ->setBody(
                'You should see me from the profiler!',
                'You should see me from the profiler!'
            )
            /*
         * If you also want to include a plaintext version of the message
        ->addPart(
        $this->renderView(
        'emails/registration.txt.twig',
        ['name' => $name]
        ),
        'text/plain'
        )
         */
        ;
        $errors = [];
        $result = $mailer->send($message, $errors);

        $this->_data_view['controller_name'] = 'ContactController';
        return $this->render('contact/index.html.twig', $this->_data_view);
    }
}