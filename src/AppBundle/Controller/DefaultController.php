<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

  /**
   * @Route("/")
   */
    public function indexAction()
    {
        return $this->redirectToRoute('liste_contact');
    }
}
