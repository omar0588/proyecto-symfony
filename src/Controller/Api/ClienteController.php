<?php

namespace App\Controller\Api;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;


//Explicado en CategoriaController
// Establecemos la ruta padre
/**
 * @Rest\Route("/cliente")
 */

class ClienteController extends AbstractFOSRestController
{
    private $repo;
    public function __construct(ClienteRepository $repo){
        $this->repo = $repo;
    }

    // Crear cliente
    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_cliente"}, serializerEnableMaxDepthChecks=true)
     */

    public function createCliente(Request $request){
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }
        //Guardamos en BD
        $this->repo->add($cliente, true);
        return $cliente;
    }

    // Traer un Cliente
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_cliente"}, serializerEnableMaxDepthChecks= true)
     */
    public function getCliente(Request $request){
        $idCliente = $request->get('id');
        $cliente = $this->repo->find($idCliente);
        if(!$cliente){
            return new JsonResponse('No se ha encontrado categoria', Response::HTTP_NOT_FOUND);
        }
        return $cliente;
    }

    // Update cliente
    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View (serializerGroups={"up_cliente"}, serializerEnableMaxDepthChecks=true)
     */
    public function updateCliente(Request $request){
        $idCliente = $request->get('id');
        $cliente = $this->repo->find($idCliente);
        if(!$cliente){
            return new JsonResponse('No hay resutados', Response::HTTP_NOT_FOUND);
        }
        $form = $this->createForm(ClienteTYpe::class, $cliente, ['method'=> $request->getMethod()]);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad data', 400);
        }
        $this->repo->add($cliente, true);
        return $cliente;
    }
}