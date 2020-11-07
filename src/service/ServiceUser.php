<?php


namespace App\service;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;

class ServiceUser
{
    private $entityManager;

    /**
     * ServiceUser constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persistUser (Usuario $us){
        $this->entityManager->persist($us);
        $this->entityManager->flush();
        return $us;
    }
    public function findUser(){
       return $this->entityManager->getRepository(Usuario::class)->findAll();
    }
    public function removeUser(Usuario $usuario){
        $this->entityManager->remove($usuario);
        $this->entityManager->flush();
//        return $us;
    }


}