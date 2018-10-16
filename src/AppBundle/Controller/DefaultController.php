<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

  /**
   * @Route("/")
   */
    public function indexAction()
    {
        return $this->redirectToRoute('liste_contact');
    }

    /**
     * @Route("/valider/email", name="valider_email")
     */
      public function validerEmailAction(Request $request)
      {
          $email = $request->query->get('email');
          $result =  $this->container->get('valider.email')->validerEmail($email);
          return new Response(
              $result,
              Response::HTTP_OK,
              array('content-type' => 'text/html')
          );
      }
}
