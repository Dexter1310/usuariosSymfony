<?php

namespace App\Controller;
use App\Entity\Tipo;
use App\Repository\UsuarioRepository;
use App\service\NewMessage;
use App\Entity\Usuario;
use App\Form\UsuType;
use App\service\ServiceUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Con1Controller extends AbstractController
{
    /** @var NewMessage $men */
    private $men;
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;
    /** @var ServiceUser $serviceUser */
    private $serviceUser;

    /**
     * Con1Controller constructor.
     * @param $men
     * @param $entityManager
     * @param $serviceUser
     */
    public function __construct(NewMessage $men,EntityManagerInterface $entityManager,ServiceUser $serviceUser)
    {
        $this->men = $men;
        $this->entityManager = $entityManager;
        $this->serviceUser = $serviceUser;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(){
//        $t=$this->men->sendMail();
//        $t=$this->json(['username' => 'jane.doe','apellidos'=>'orti']);
//        $this->addFlash('mensaje',$t);
        return $this->render('con1/index.html.twig');
    }

    /**  crear
     * @Route("/pagina2/", name="pagina2", methods={"POST","GET"} )
     */
    public function pagina2(Request $request)
    {
        $form = $this->createForm(UsuType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Usuario $user */
            $user = $form->getData();
            $this->serviceUser->persistUser($user);
            return $this->redirectToRoute('pagina3');
        }
        return $this->render(
            'con1/pagina2.html.twig',
            [
                'variable2' => 'Agregar usuario',
                'formul' => $form->createView(),
            ]
        );

    }
    /** visualizar
     * @Route("/pagina3/", name="pagina3")
     */

    public function pagina3Action(Request $request)
    {
        $usuario=$this->serviceUser->findUser();
        /** @var  $number int */
     $number=null;
        $form = $this->createFormBuilder()->add('tipo',ChoiceType::class, [
            'choices' => [
                'Administradores' => [
                    'jefe' => 1,
                    'cliente' => 2,
                    'empleado'=>3,
                ],
            ],
        ])->add('Filtrar',SubmitType::class)->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
//                $this->serviceUser->persistUser($user);
//                $this->addFlash(
//                    'success','Usuario '.$usuario->getNombre().' actualizado.'
//                );
//                $userCreate='Usuario '.$usuario->getNombre().' actualizado.';

                $user=implode($user);
                $number=$user;

            }
        }
        $usua=$this->entityManager->getRepository(Usuario::class)->findUserType($number);

        return $this->render('con1/pagina3.html.twig',['busqueda'=>$usuario,'mensaje'=>'','usua'=>$usua,'mens'=>$number,'formulari'=>$form->createView()]);
    }

    /**  Actualizar
     * @Route("/pagina4/{id}", requirements={"id" = "^\d+$"}, name="update", methods={"POST","GET"})
     * @ParamConverter("usuario", class="App\Entity\Usuario")
     */
    public function actualizar(Usuario $usuario,Request $request)
    {
        /**
         * Al método createForm, se le puede pasar el objeto con el que inicializar el formulario.
         * En este caso inicializamos el formulario UsuType, con los valores del objeto $usuario
         */
        $form = $this->createForm(UsuType::class, $usuario);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData();
                $this->serviceUser->persistUser($user);
                $this->addFlash(
                    'success','Usuario '.$usuario->getNombre().' actualizado.'
                );
                $userCreate='Usuario '.$usuario->getNombre().' actualizado.';
                return $this->redirectToRoute('pagina3', ['mensaje' => $userCreate]);
            }
        }

        return $this->render('con1/pagina4.html.twig', ['variable2' => 'Actualizar', 'usuario'=>$usuario, 'formul'=>$form->createView()]
        );
    }
    /**  Eliminar
     * @Route("/pagina3/{id}/", requirements={"id" = "^\d+$"}, name="borrar")
     * @ParamConverter("usuario", class="App\Entity\Usuario")
     */
    public function borrar(Usuario $usuario)
    {
        /**
         * Guardo el id del usuario en la variable, antes de borrarlo (de otro modo, no tendria acceso al valor)
         */
        $ide = $usuario->getId();
        $this->serviceUser->removeUser($usuario);
        return $this->redirectToRoute('pagina3',['mensaje'=>'Usuario con id:'.$ide.' eliminado']);
    }
//    Todo: encontrar usuario por id
    /**
     * @Route("/user/{id}", name="user_show")
     * @ParamConverter("usuario", class="App\Entity\Usuario")
     */
    public function show(Usuario $usuario)
    {
        $us = $usuario->getId();
        if (!$us) {
            throw $this->createNotFoundException(
                'No User found for id '.$us
            );
        }
        return $this->redirectToRoute('pagina3',['mensaje'=>'Usuario: '.$usuario->getNombre().'.']);

    }
    /**
     * @Route("/user/{type}", name="userType", methods={"POST"})
     */
//    public function showUseType($type)
//    {
//
//
//
//        return $this->redirectToRoute('pagina3',['mensaje'=>'Usuario: '.$usuario->getNombre().'.']);
//
//    }



//    /**
//     * @Route("/crear/", name="pagina4")
//     */
//
///// TODO:MODO PRUEBA : crear manualmente desde la vista /crear desde la url
//    public function  crear()
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $usuari = new Usuario('Pablo', "pablo@gmail.com", "Santmonica", 699594539);
//        $tipo = new Tipo('jefe',2);
//        $usuari->setTipo($tipo);
//        $entityManager->persist($usuari);
//        $entityManager->flush();
//        return $this->render('con1/succes.html.twig');
//
//    }

}