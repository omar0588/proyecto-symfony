<?php

namespace App\Controller\Api;

use App\Repository\RestauranteRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/restaurante")
 */
class RestauranteController extends AbstractFOSRestController
{
    private $repo;
    public function __construct(RestauranteRepository $repo){
        $this->repo = $repo;
    }

    // Hacemos dos endpoints

    // 1. Devolver restaurante por id
    // Me servira para mostrar la pagina del restaurante con toda su informacion
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_restaurante"}, serializerEnableMaxDepthChecks= true)
     */
    public function getRestaurante(Request $request){
        $idRestaurante = $request->get('id');
        $restaurante = $this->repo->find($idRestaurante);
        if(!$restaurante){
            return new JsonResponse('No se ha encontrado categoria', Response::HTTP_NOT_FOUND);
        }
        return $restaurante;
    }

    // 2. Devolver listado de restaurantes, segun dia, hora y municipio
    // primero seleccionamos la direccion a la que se va a enviar
    // Luego seleccionamos dia y hora del reparto
    // Mostrar los restaurantes que cumplan esas condiciones
    /**
     * @Rest\Post (path="/filtered")
     * @Rest\View (serializerGroups={"rest_filtered"}, serializerEnableMaxDepthChecks=true)
     */
    public function getRestauranteBy(Request $request){
        $dia = $request->get('dia');
        $hora = $request->get('hora');
        $idMunicipio = $request->get('municipio');
        //Comprobar que viene esos datos, si no viene alguno -> BAD REQUEST
        $restaurantes = $this->repo->findByDayTimeMunicipio($dia,$hora,$idMunicipio);
        return $restaurantes;

    }



}