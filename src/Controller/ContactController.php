<?php

namespace App\Controller;

use App\Repository\ConfigRepository;
use App\Repository\GroupConfigRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends ControllerBase
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(
        Request $request,
        \Swift_Mailer $mailer,
        ConfigRepository $config,
        GroupConfigRepository $groupConfig,
        TranslatorInterface $translator
    ) {
        if ($_POST) {
            if ($request->request->get('name')
                && $request->request->get('email')
                && $request->request->get('phone')
                && $request->request->get('message')
            ) {

                $groupConfig = $groupConfig->findOneBy(['name' => 'Mail']);

                $args = [
                    'groupConfig' => $groupConfig->getId(),
                    'base' => 'contact_mail',
                ];

                $contactMail = $config->findOneBy($args);

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

        $this->_dataView['controllerName'] = 'ContactController';
        return $this->render('contact/index.html.twig', $this->_dataView);
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

        $this->_dataView['controllerName'] = 'ContactController';
        return $this->render('contact/index.html.twig', $this->_dataView);
    }
}