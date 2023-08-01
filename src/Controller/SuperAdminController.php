<?php

namespace App\Controller;

use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SuperAdminController extends AbstractController
{
    #[Route('/super/admin', name: 'app_super_admin')]
    #[IsGranted(LoginFormAuthenticator::ROLE_SUPER_ADMIN)]
    public function index(): Response
    {
        return $this->render('super_admin/index.html.twig');
    }
}
