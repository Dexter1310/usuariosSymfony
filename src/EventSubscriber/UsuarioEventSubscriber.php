<?php


namespace App\EventSubscriber;

use App\service\NewMessage;
use App\service\ServiceUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;


class UsuarioEventSubscriber implements EventSubscriberInterface
{
    private $em;
    private $mailer;

    /**
     * UsuarioEventSubscriber constructor.
     * @param $em
     * @param $mailer
     */
    public function __construct(EntityManagerInterface $em,NewMessage $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UsuarioEvent::NAME=> 'handleUserEnabled',
            UsuarioEvent::USERMAIL=>'sendMail',
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
    public function sendMail(UsuarioEvent $event)
    {

      $this->mailer->sendMail($event->getUser());
    }

}