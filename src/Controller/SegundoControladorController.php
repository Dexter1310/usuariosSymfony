<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SegundoControladorController extends AbstractController
{
    /**
     * @Route("/info/{nombre}/{apellidos}/", name="info")
     */
    public function info($nombre, $apellidos)
    {
        return $this->render('segundo_controlador/info.html.twig', [
            'controller_name' => 'SegundoControladorController',
            'nombre' => $nombre,
            'apellidos' => $apellidos
        ]);
    }
}
