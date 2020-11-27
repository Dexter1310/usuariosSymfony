<?php


namespace App\EventSubscriber;
use App\Entity\Usuario;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UsuarioEventSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::postUpdate,
        ];
    }
    public function postUpdate(LifecycleEventArgs $args): void
    {
        if ($this->isUsuario($args->getObject())) {
            /** @var Usuario $usuario */
            $usuario = $args->getObject();
            $usuario->setEnabled(1);
            print_r('Usuario modificado estos son los datos obtenidos:<br><hr>
            Nombre : '.$usuario->getNombre().
            '<br>Dirección : '.$usuario->getAdress().
                '<br>Phone : '.$usuario->getPhone().
                '<br>Administrador  : '.$usuario->getAdmin()->getNombre().
                '<br>Tipo : '.$usuario->getTipo()->getnombre().
                '<br>Mail : '.$usuario->getMail().
                '<br><b>Enabled: '.$usuario->isEnabled().'</b><br><hr>
                <a href="/pagina3">Torna</a>');die();
        }
    }
    private function isUsuario($entity)
    {
        return $entity instanceof Usuario;
    }
}