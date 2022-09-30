<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PruebasController extends AbstractController
{
    private $logger;
    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }
    // Tenemos que difinir como es el endpoint para poder hacer la peticion desde el cliente

    // ENDPOINT
    /**
     * @Route ("/get/usuarios", name = "get_users")
     */
    public function getAllUser(Request $request){
        // Llamará a base de datos y se traerá toda la lista de users
        // Devolver una respuesta en formato Json
        // Request - Peticion
        // Response - Hay que devolver una respuesta (SIEMPRE)

        //$response = new Response(); // Esto lleva un codigo de estado.
        //$response-> setContent('<div>Hola mundo</div>');

        //Capturamos los datos que viene en el Request
        //get para coger una variable en concreto
        $id = $request->get('id');
        $this->logger->alert('Mensajito');

        // query sql para tarer el user con id = $id
        // intval para pasearlo a numero en vez de string
        $response = new JsonResponse();
        $response -> setData([
            'succes' => true,
            'data' => [
                'id'=> intval($id),
                'nombre' => 'Pepe',
                'email' => 'pepe@email.com'
            ]
        ]);
        return $response;
    }

}