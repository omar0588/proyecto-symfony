<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Rest\Route("/user")
 */
class UserController extends AbstractFOSRestController
{
    private $repo;
    private $hasher;

    public function __construct(UserRepository $repo, UserPasswordHasherInterface $hasher){
        $this->repo = $repo;
        $this->hasher = $hasher;
    }

    //EndPoint para registrar a los usuarios
    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"user"}, serializerEnableMaxDepthChecks= true)
     */
    public function createUser(Request $request){
        //OJO que el rol va por separado
        //EJEMPLO
        /*
         * {
         * "user": {
         *          "email": ....
         *          "password": ....
         *            },
         *   "role": ----
         * }
         */

        //Me lo guarda en formato Array
        $user = $request->get('user');
        $role = $request->get('role');

        // Enviarlo al form
        $form = $this->createForm(UserType::class);
        $form->submit($user);
        if(!$form->isSubmitted() || !$form->isValid()){
            return $form;
        }

        /**
         * @var User $newUser
         */
        $newUser = $form->getData();

        // Establecer el rol
        // - Guardamos el rol en un ARRAY
        $roles[] = $role;
        $newUser->setRoles($roles);

        //Codificar el password
        $hashedPassword = $this->hasher->hashPassword(
            $newUser,
            $user['password']
        );
        $newUser->setPassword($hashedPassword);

        // guardamos en bd
        $this->repo->add($newUser, true);
        return $newUser;
    }

}