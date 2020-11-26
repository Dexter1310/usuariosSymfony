<?php

namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;


class Con1ControllerSubscriber  implements EventSubscriberInterface
{
    private $twig;
    /**
     * Con1ControllerSubscriber constructor.
     * @param $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    //Todo:evento al encontrar la ruta específica añadiendo al twig una variable global
    public function onRequestEvent(RequestEvent $event)
    {
        if($event->getRequest()->getRequestUri()=="/pagina3/"){
            $this->twig->addGlobal('menu',"Menu de configuración");
//            dump($event);
//            die();
        }
}
    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onRequestEvent',
        ];
    }
}
