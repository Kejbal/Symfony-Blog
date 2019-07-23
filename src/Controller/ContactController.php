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
        if ($request->request->all()) {
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
            } else {
                $arrData = ['success' => 0];
                return new JsonResponse($arrData);
            }
        }

        $this->dataView['controllerName'] = 'ContactController';
        return $this->render('contact/index.html.twig', $this->dataView);
    }
}
