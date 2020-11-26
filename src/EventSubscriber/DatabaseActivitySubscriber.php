<?php


namespace App\EventSubscriber;
use Doctrine\Common\EventSubscriber;
use App\Entity\Usuario;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DatabaseActivitySubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }
    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('remove', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

       $em= $args->getObjectManager();
        if ($entity instanceof Usuario) {
            $entity->setEnabled(1);
            $em->persist($entity);
            $em->flush();
        }

    }
}



