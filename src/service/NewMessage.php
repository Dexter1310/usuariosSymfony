<?php

namespace App\service;
//use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
//
//class NewMessage
//{
//    private $mensaje;
//    private $mailer;
//
//    /**
//     * NewMessage constructor.
//     * @param $logger
//     * @param $mailer
//     */
//    public function __construct(NewMessage $mensaje, MailerInterface $mailer)
//    {
//        $this->mensaje = $mensaje;
//        $this->mailer = $mailer;
//    }
//
//    public function getHappyMessage(): string
//    {
//        $messages = [
//            'Esto es un mensaje de prueba!',
//            'Después paso al controller!',
//            'Great work! Keep going!',
//        ];
//        //ramdom
//        $index = array_rand($messages);
//        return $messages[$index];
//    }
//
////    public function sendMail(){
////        $email = (new Email())
////            ->from('admin@example.com')
////            ->to('manager@example.com')
////            ->subject('Site update just happened!')
////            ->text('Someone just updated the site. We told them: '.$this->getHappyMessage());
////
////        $this->mailer->send($email);
////        return "Mensaje enviado:";
////    }
//
//
//}



class NewMessage
{

    public function getHappyMessage(): string
    {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }
    public function sendMail(){
//        $email = (new Email())
//            ->from('admin@example.com')
//            ->to('manager@example.com')
//            ->subject('Site update just happened!')
//            ->text('Someone just updated the site. We told them: '.$this->getHappyMessage());
//
//        $this->mailer->send($email);
       $text= $this->getHappyMessage();
        return "Mensaje enviado:".$text;
    }
}