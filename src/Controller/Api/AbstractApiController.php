<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;

class AbstractApiController extends AbstractFOSRestController
{
    // Crear metodo intermedio para sobreescribir las opciones del formulario
    // asi poder desactivar el csrf_token

}