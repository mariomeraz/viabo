<?php
namespace Viabo\Backend\Controller\landingPages\viabo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


final class ViewController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        return $this->render('/landing-pages/viabo/viabo.html.twig');
    }
}