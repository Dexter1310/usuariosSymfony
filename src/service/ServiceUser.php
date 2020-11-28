<?php


namespace App\service;

use App\Entity\Administrador;
use App\Entity\Tipo;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ServiceUser
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /**
     * ServiceUser constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function persistUser(Usuario $us)
    {
        $this->entityManager->persist($us);
        $this->entityManager->flush();
        return $us;
    }

    public function findUser()
    {
        return $this->entityManager->getRepository(Usuario::class)->findAll();
    }

    public function removeUser(Usuario $usuario)
    {
        $this->entityManager->remove($usuario);
        $this->entityManager->flush();
    }

    //Todo:crear o actualizar administrador:
    public function persistAdmin(Administrador $admin)
    {
        $cate = $admin->getTipo();
        if ($cate == Administrador::PRINCIPAL) {
            $admin->setCategoria('Principal');
        } elseif ($cate == Administrador::ADMIN) {
            $admin->setCategoria('Admin');
        } elseif ($cate == Administrador::OF1) {
            $admin->setCategoria('Oficial 1');
        } else {
            $admin->setCategoria('Oficial 2');
        }
        $this->entityManager->persist($admin);
        $this->entityManager->flush();
        return $admin;
    }

    //Todo:busqueda de todos los administradores
    public function findAdmin()
    {
        return $this->entityManager->getRepository(Administrador::class)->findAll();
    }

    //Todo:eliminar administrador:
    public function removeAdmin(Administrador $administrador)
    {
        $this->entityManager->remove($administrador);
        $this->entityManager->flush();
    }

    //Todo: buscar por parametro en createQueryBuilder() en Administradores:

    public function findParameter($tipo = null)
    {

        $consulta = $this->entityManager->getRepository(Administrador::class)->createQueryBuilder(Administrador::ALIAS)
            ->where(Administrador::ALIAS . '.tipo=:tipo')->setParameter('tipo', $tipo)->setMaxResults(1)->getQuery()->getSingleResult();
        return $consulta;
    }

    //TODO: Tiene que devolver los Usuario que tengan asociado un tipo con el código recibido por parámetro
    public function findUsuarioByCodigoTipo($codigo)
    {
        $query = $this->entityManager->getRepository(Usuario::class)->createQueryBuilder(Usuario::alias)
            ->join(Usuario::alias . '.tipo', Tipo::ALIAS)
            ->where(Tipo::ALIAS . '.codigo=:codigo')
            ->setParameter('codigo', $codigo)->getquery()->getResult();
        return $query;
    }

    //TODO: Tiene que devolver los Usuario que tengan asociado el administrador
    public function findUsuarioByAdmin($idAdmin)
    {
        $query = $this->entityManager->getRepository(Usuario::class)->createQueryBuilder(Usuario::alias)
            ->join(Usuario::alias . '.admin', Administrador::ALIAS)
            ->where(Administrador::ALIAS . '.id=:idAdmin')
            ->setParameter('idAdmin', $idAdmin)->getquery()->getResult();
        return $query;
    }

    //Todo: funcion para buscar la condición del formulario que se pide en el FILTRO:

    public function filter($tipo = null, $administrador = null, $codigo = null)
    {
        $query = $this->entityManager->getRepository(Usuario::class)->createQueryBuilder(Usuario::alias);
        if ($tipo) {
            $query->andwhere(Usuario::alias . '.tipo=:type')
                ->orderBy(Usuario::alias . '.id', 'DESC')
                ->setParameter('type', $tipo->getId());
        }
        if ($administrador) {
            $query->join(Usuario::alias . '.admin', Administrador::ALIAS)
                ->andwhere(Administrador::ALIAS . '.id=:idAdmin')
                ->orderBy(Usuario::alias . '.id', 'ASC')
                ->setParameter('idAdmin', $administrador->getId());
        }
        if ($codigo) {
            $query->join(Usuario::alias . '.admin', Administrador::ALIAS)
                ->join(Usuario::alias . '.tipo', Tipo::ALIAS)
                ->where(Tipo::ALIAS . '.codigo=:codigo')
                ->setParameter('codigo', $codigo)->getquery()->getResult();
        }
        return $query->getquery()->getResult();
    }
}