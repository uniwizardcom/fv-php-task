<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(Request $request): Response
    {
        if($request->query->get('page') !== null) {
            $page = (int)$request->query->get('page');

            return $this->data($page);
        }

        return $this->render('index.html.twig', []);
    }

    private function data(int $page): JsonResponse
    {
        $data = [];

        for($i = 1; $i <= 10; $i++) {
            $data[] = [
                'label' => 'Position: ' . ($page * 10 + $i),
                'y' => rand(0, 10000) / 100
            ];
        }

        return $this->json([
            'page' => $page,
            'data' => $data,
        ]);
    }
}
