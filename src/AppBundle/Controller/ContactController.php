<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/contact")
 */
class ContactController extends Controller
{

    /**
     * @Route("/", name="liste_contact")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        $contacts = $this->getDoctrine()->getRepository('AppBundle:contact')->findBy(['user' => $user], ['prenom' => 'ASC']);
        return $this->render('contact/index.html.twig',['contacts' => $contacts]);

    }

    /**
     * @Route("/new", name="ajouter_contact")
     */
    public function creationAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $contact->setUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($contact);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('voir_contact', ['id' => $contact->getId()]);
        }
        return $this->render('contact/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modify",requirements={"id"="\d+"}, name="modifier_contact")
     */
    public function modifierAction(Request $request, $id)
    {
        $contact = $this
            ->getDoctrine()
            ->getRepository('AppBundle:contact')
            ->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('No such contact');
        }

        if ($contact->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Impossible de modifier des contacts qui ne vous appartiennent pas');
        }

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('voir_contact', ['id' => $contact->getId()]);
        }

        return $this->render('contact/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}",requirements={"id"="\d+"}, name="voir_contact")
     */
    public function voirAction(Request $request, $id)
    {
        $contact = $this->getDoctrine()->getRepository('AppBundle:contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact n\'existe pas');
        }

        if ($contact->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Impossible de voir des contacts qui ne vous appartiennent pas');
        }

        return $this->render('contact/voir.html.twig',['contact' => $contact]);
    }

    /**
     * @Route ("/{id}/delete",requirements={"id"="\d+"}, name="supprimer_contact")
     */
    public function supprimerAction(Request $request, $id)
    {
        $contact = $this->getDoctrine()->getRepository('AppBundle:contact')->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found');
        }

        if ($contact->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Impossible de supprimer des contacts qui ne vous appartiennent pas');
        }

        $entitymanager = $this->getDoctrine()->getManager();

        $entitymanager->remove($contact);
        $entitymanager->flush();

        return $this->redirectToRoute("liste_contact");
    }

}
