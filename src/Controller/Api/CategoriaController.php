<?php

namespace App\Controller\Api;

use App\Repository\CategoriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


// Metemos esta ruta base para que sea general en los siguientes endpoint
/**
 * @Rest\Route("/categoria")
 */
class CategoriaController extends AbstractFOSRestController
{

    private $categoriaRepository;

    public function __construct(CategoriaRepository $repo)
    {
        $this->categoriaRepository = $repo;
    }

    // Crear endPoint
    // RestView para ver que queremos que devuelva
    // siempre poner serializerEnabled........
    /**
     * @Rest\Get(path="/")
     * @Rest\View (serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks= true)
     */

    public function getCategorias(){
        return $this->categoriaRepository->findAll();
    }

}