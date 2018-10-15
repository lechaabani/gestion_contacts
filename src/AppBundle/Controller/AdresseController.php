<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Adresse;
use AppBundle\Form\AdresseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/adresse")
 */
class AdresseController extends Controller
{
    /**
     * @Route("/{id}/new", requirements={"id"="\d+"}, name="ajouter_adresse")
     */
    public function creationAction(Request $request, $id)
    {
        $contact = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Contact')
            ->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('No such contact');
        }

        if($contact->getUser() !== $this->getUser()){
            throw $this->createAccessDeniedException('Impossible de modifier des contacts qui ne vous appartiennent pas');
        }

        $adresse = new Adresse();
        $form  = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->persist($adresse);
            $adresse->setContact($contact);
            $contact->addAdresse($adresse);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('voir_contact', ['id' => $contact->getId()]);
        }


        return $this->render('contact/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/modifier/{addressId}", requirements={"id"="\d+", "addressId"="\d+"}, name="modifier_adresse")
     */
    public function modifierAction(Request $request, $id, $addressId)
    {

        $contact = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Contact')
            ->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('No such contact');
        }

        if($contact->getUser() !== $this->getUser()){
            throw $this->createAccessDeniedException('Impossible de modifier des contacts qui ne vous appartiennent pas');
        }

        $adresse = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Adresse')
            ->find($addressId);

        if (!$adresse) {
            throw $this->createNotFoundException('No such address');
        }

        if (!$adresse) {
            throw $this->createNotFoundException('No such address');
        }

        $form  = $this->createForm(AdresseType::class, $adresse);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('voir_contact', ['id' => $id]);
        }

        return $this->render('contact/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/{id}/supprimer/{addressId}",
     *         requirements={"id"="\d+", "addressId"="\d+"},
     *         name="supprimer_adresse")
     */
    public function supprimerAction(Request $request, $id, $addressId)
    {
        $contact = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Contact')
            ->find($id);

        if (!$contact) {
            throw $this->createNotFoundException('No such contact');
        }

        if($contact->getUser() !== $this->getUser()){
            throw $this->createAccessDeniedException('Impossible de modifier des contacts qui ne vous appartiennent pas');
        }

        $address = $this->getDoctrine()->getRepository('AppBundle:Adresse')->find($addressId);

        if (!$address) {
            throw $this->createNotFoundException('Address not found');
        }

        $contact->removeAdresse($address);

        $entitymanager = $this->getDoctrine()->getManager();

        $entitymanager->remove($address);
        $entitymanager->flush();

        return $this->redirectToRoute('voir_contact', ['id' => $contact->getId()]);
    }

}
