<?php

namespace App\Controller;

use App\Entity\Administrador;
use App\Form\AdministradorType;
use App\service\ServiceUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdministradorController extends AbstractController
{
    private $serviceUser;

    /**
     * AdministradorController constructor.
     * @param $serviceUser
     */
    public function __construct(ServiceUser $serviceUser)
    {
        $this->serviceUser = $serviceUser;
    }
//Todo:listado del administrador
    /**
     * @Route("/administrador/", name="administrador")
     */
    public function index()
    {
        $admin=$this->serviceUser->findAdmin();
        return $this->render('administrador/index.html.twig',['busqueda'=>$admin,'mensaje'=>'','controller_name'=>'Administradores']);
    }
//Todo guardar el administrador en BD
    /**
     * @Route("/saveAdmin", name="adAdmin" , methods={"POST","GET"})
     */
    public function adAdmin(Request $request)
    {
        $form = $this->createForm(AdministradorType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $admin = $form->getData();
            $this->serviceUser->persistAdmin($admin);
            return $this->redirectToRoute('administrador',['message'=>"Administrador insertado correctamente"]);
        }
        $admin=new Administrador();
        return $this->render('administrador/newAdmin.html.twig',
            ['formulAdmin' => $form->createView(),'titulo'=>"Agregar administrador",'usuAdmin'=>$admin->setNombre("Inroduzca nombre completo")]);

    }
//Todo: encontrar Admin por id al pulsar en la fila
    /**
     * @Route("/administrador/{id}", name="admin_show", methods={"GET"})
     * @ParamConverter("administrador", class="App\Entity\Administrador")
     */
    public function showAdmin(Administrador $administrador)
    {
        $adID = $administrador->getId();

        if (!$adID) {
            throw $this->createNotFoundException(
                'No Admin found for id '.$adID
            );
        }
        return $this->redirectToRoute('administrador',['message'=>'Administrador : '.$administrador->getNombre().'.']);
    }
//Todo: eliminar el administrador por id:
    /**
     * @Route("/deleteAdmin/{id}/",  name="deleteAdmin",methods={"GET"})
     * @ParamConverter("admin", class="App\Entity\Administrador")
     */
    public function deleteAdmin(Administrador $admin)
    {
        $ide = $admin->getId();
        $this->serviceUser->removeAdmin($admin);
        return $this->redirectToRoute('administrador',['message'=>'Eliminado con id:'.$ide.' eliminado']);
    }
//Todo:Actualizar el administrador por id
    /**
     * @Route("/updateAdmin/{id}", requirements={"id" = "^\d+$"}, name="updateAdmin", methods={"POST","GET"})
     * @ParamConverter("admin", class="App\Entity\Administrador")
     */
    public function updateAdmin(Administrador $admin,Request $request)
    {

        $formAdmin = $this->createForm(AdministradorType::class, $admin);
        if ($request->getMethod() == 'POST') {
            $formAdmin->handleRequest($request);
            if ($formAdmin->isSubmitted() && $formAdmin->isValid()) {
                $ad = $formAdmin->getData();
                $this->serviceUser->persistAdmin($ad);
                return $this->redirectToRoute('administrador', ['message' =>'Administrador '.$admin->getNombre().' actualizado con id:'.$admin->getId()]);
            }
        }
        return $this->render('administrador/newAdmin.html.twig', [ 'usuAdmin'=>$admin, 'formulAdmin'=>$formAdmin->createView(),'titulo'=>'Actualizar Administrador']
        );
    }


}
