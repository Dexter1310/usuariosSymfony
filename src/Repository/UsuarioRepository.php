<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


/**
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }
    public function findUserType($tipo): array
    {
        //Todo: ejemplo de createQuery()
//        return  $this->getEntityManager()->createQuery(
//            'SELECT usu.id,usu.nombre,usu.mail
//                  FROM App\Entity\Usuario usu
//                   WHERE usu.tipo =:type')
//            ->setParameter('type',$tipo)
//            ->getResult();
        //Todo: ejemplo de createQueryBuilder()
        $consulta=$this->getEntityManager()->getRepository(Usuario::class)->createQueryBuilder(Usuario::alias);
        return $consulta
            ->where(Usuario::alias.'.tipo=:type')
            ->setParameter('type',$tipo)->getQuery()->execute();

    }

    // /**
    //  * @return Usuario[] Returns an array of Usuario objects
    //  *./
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usuario
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
