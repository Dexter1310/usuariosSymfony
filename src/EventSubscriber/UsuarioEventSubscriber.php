<?php


namespace App\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;



class UsuarioEventSubscriber implements EventSubscriberInterface
{
    private $em;
    /**
     * UsuarioEventSubscriber constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UsuarioEvent::NAME=> 'handleUserEnabled'
        ];
    }

    public function handleUserEnabled(UsuarioEvent $event)
    {
        $usuario=$event->getUser();
        $usuario->setEnabled(true);
        $this->em->persist($usuario);
        $this->em->flush();
        // persistir en base de datos
    }

}