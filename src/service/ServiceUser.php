<?php


namespace App\service;
use App\Entity\Administrador;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ServiceUser
{
    /** @var EntityManagerInterface  $entityManager*/
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
    }

//   Todo:crear o actualizar administrador:
    public function persistAdmin (Administrador $admin){
        $this->entityManager->persist($admin);
        $this->entityManager->flush();
        return $admin;
    }
//   Todo:busqueda de todos los administradores
    public function findAdmin(){
        return $this->entityManager->getRepository(Administrador::class)->findAll();
    }
//   Todo:eliminar administrador:
    public function removeAdmin(Administrador $administrador){
        $this->entityManager->remove($administrador);
        $this->entityManager->flush();
    }

    //Todo: buscar por parametro en createQueryBuilder() en Administradores:

    public function findParameter($tipo){

        $consulta=$this->entityManager->getRepository(Administrador::class)->createQueryBuilder(Administrador::admin)
            ->where(Administrador::admin.'.tipo=:tipo')->setParameter('tipo',$tipo)->setMaxResults(1)->getQuery()->getSingleResult();
        return $consulta;

    }


    public function findUsuarioByCodigoTipo($codigo){

        $query=$this->entityManager->getRepository(Usuario::class)->createQueryBuilder(Usuario::alias)
            ->join(Usuario::alias.'.tipo','tp')
            ->where('tp.codigo=:codigo')
            ->setParameter('codigo',$codigo)->getquery()->getResult();
        return $query;


        // TODO Tiene que devolver los Usuario que tengan asociado un tipo con el código recibido por parámetro
    }






}