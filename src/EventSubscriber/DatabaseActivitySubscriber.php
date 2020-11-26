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
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        if ($this->isUsuario($args->getObject())) {
            /** @var Usuario $usuario */
            $usuario = $args->getObject();
            $usuario->setEnabled(true);
            // No hace falta hacer persist ni flush, porqué el evento prePersist se lanza antes de que doctrine los ejecute
        }
    }


    private function isUsuario($entity)
    {
        return $entity instanceof Usuario;
    }
}



