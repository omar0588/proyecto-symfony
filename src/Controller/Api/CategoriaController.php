<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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

    // Crear endPoint para devolver
    // Usamos Get para devolver
    // RestView para ver que queremos que devuelva
    // siempre poner serializerEnabled........
    /**
     * @Rest\Get(path="/")
     * @Rest\View (serializerGroups={"get_categorias"}, serializerEnableMaxDepthChecks= true)
     */

    public function getCategorias(){
        return $this->categoriaRepository->findAll();
    }

    // crear endPoint para guardar
    // Usamos Post para guardar
    // Request= donde nos van a enviar la categoria a guardar

    // If para asegurarme de que la categoria que nos llegue es correcta o llega algun dato
    // ! = sino

    //EJEMPLO SIN FORMULARIOS
//    public function createCategoria(Request $request){
//        $categoria = $request->get('categoria');
//        if(!$categoria){
//            return new JsonResponse('Error en la peticion', Response::HTTP_BAD_REQUEST);
//        }
//
//        // Crear el objeto y hacer un set del nombre de la categoria que he recibido
//        $cat = new Categoria();
//        $cat->setCategoria($categoria);
//
//        // Guardamos en base de datos.
//        $this->categoriaRepository->add($cat, true);
//
//        //Enviar una respuesta al cliente
//        return $cat;
//
//    }

    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_categoria"}, serializerEnableMaxDepthChecks= true)
     */

    // If para asegurarme de que la categoria que nos llegue es correcta o llega algun dato
    // ! = sino
    // EJEMPLO CON FORMULARIO
    public function createCategoria(Request $request){
        // Formularios
        // 1. Creo el objeto vacio
        $cat = new Categoria();

        // 2. Inicializamos el Form
        $form = $this->createForm(CategoriaType::class, $cat);

        // 3. Le decimos al formulario que maneje la request
        $form->handleRequest($request);

        // 4.Comprobar si hay error
        if(!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }

        // 5. Todo ok, guardo en BD.
        $this->categoriaRepository->add($form->getData(), true);
        return $form->getData();

    }

}