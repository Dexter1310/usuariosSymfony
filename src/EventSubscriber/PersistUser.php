<?php


namespace App\EventSubscriber;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
class PersistUser
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
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        if($entity instanceof Usuario) {
            dump('persist usuario');die();
        }
//        $this->entityManager = $args->getObjectManager();
    }

    public function postUpdate(Usuario $user, LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();
        if($entity instanceof Usuario) {
            dump('persist usuario');die();
        }
    }
}