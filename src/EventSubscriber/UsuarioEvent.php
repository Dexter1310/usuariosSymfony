<?php


namespace App\EventSubscriber;
use App\Entity\Usuario;
use Symfony\Contracts\EventDispatcher\Event;


class UsuarioEvent extends Event
{
    public const NAME = 'user.placed';
    protected $user;
    /**
     * UsuarioEvent constructor.
     * @param  Usuario $user
     */
    public function __construct(Usuario $user)
    {
        $this->user = $user;
    }
    /**
     * @return Usuario
     */
    public function getUser()
    {
        return $this->user;
    }
}