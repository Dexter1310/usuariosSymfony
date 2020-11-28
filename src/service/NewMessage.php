<?php

namespace App\service;

use App\Entity\Usuario;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class NewMessage
{
    private $mail;
    public $mensa;

    /**
     * NewMessage constructor.
     * @param $mail
     */
    public function __construct(MailerInterface $mail)
    {
        $this->mail = $mail;
    }

    public function getHappyMessage(): string
    {
        $messages = [
            'Bienvenido Ascetic!',
            'Es usted un nuevo miembro!',
            'welcome to ascetic!',
        ];
        $index = array_rand($messages);
        return $messages[$index];
    }

    public function sendMail(Usuario $us)
    {
        try{
        $email = (new Email())
            ->from('insorti@gmail.com')
            ->to($us->getMail())
            ->subject('new user  ascetic!')
            ->html("<h1>Usuario registrado</h1><h2>"
                . $this->getHappyMessage() . "</h2>
                    <img style='float: right;margin-right: 10%' src='https://media-exp1.licdn.com/dms/image/C4E0BAQEb-mDSHbqqPg/company-logo_200_200/0?e=2159024400&v=beta&t=sOw8k2iFVD49nwDBUCkxYv6Cn36lVAHH9ahjFcAnuhk' alt='Ascetic S.L.'>
                    <hr><h3>Datos obtenidos:</h3><ul>
                    <li><b>Nombre</b>  :" . $us->getNombre() . "</li>
                    <li><b>Correo</b>  :" . $us->getMail() . "</li>
                    <li><b>Dirección</b>  :" . $us->getAdress() . "</li>
                    <li><b>Tlf</b>:" . $us->getPhone() . "</li>
                    <li><b>Tipo</b> :" . $us->getTipo()->getNombre() . "</li>
                    <li><b>Administrador </b>:" . $us->getAdmin()->getNombre() . "</li></ul>")->attachFromPath("../public/assets/img/ascetic.png");

            $this->mail->send($email);
            $this->mensa="Bienvendo  ".$us->getNombre()."! Acabas de registrarte.Verifica tus datos en tu correo  ".$us->getMail().".";
        } catch (TransportExceptionInterface $e) {

            $this->mensa="No se ha enviado el mensaje";

        }


    }
}