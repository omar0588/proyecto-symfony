<?php

namespace App\Controller\Api;

use App\Repository\MunicipiosRepository;
use App\Repository\ProvinciasRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/provincias")
 */

class provinciasController extends AbstractFOSRestController
//Traemos las provincias y los municipios y los metemos en sus respectivas variables, para tenerlos a mano.
{
    private $repoP;
    private $repoM;
    public function __construct(ProvinciasRepository $repoP, MunicipiosRepository $repoM){
        $this->repoP = $repoP;
        $this->repoM = $repoM;
    }

    // 1. Devolver todas las provincias(id y nombre)
    /**
     * @Rest\Get(path="/")
     * @Rest\View (serializerGroups={"provincias"}, serializerEnableMaxDepthChecks= true)
     */

    // Con esto traemos todas las categorias.
    public function getProvincias(){
        return $this->repoP->findAll();
    }

    // 2. Devolver los municipios de una provincia(id y nombre)
    /**
     * @Rest\Get(path="/")
     * @Rest\View (serializerGroups={"municipios"}, serializerEnableMaxDepthChecks= true)
     */

    // Con esto traemos todas las categorias.
    public function getMunicipiosByProvincia(Request $request){
        return $this->repoM->findBy(['idProvincia'=>$request->get('id')]);
    }
}