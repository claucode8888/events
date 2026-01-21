<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
      $route = match(true){
        $this->isGranted('ROLE_ADMIN') => 'app_admin_events_index',
        default => 'app_event_index'
      };
      
      return $this->redirectToRoute($route);
    }
}