<?php

namespace AppBundle\Service;

class ValiderEmail
{
   /**
    * Valider email
    */
    public function ValiderEmail($email)
    {
        // Vérifie si la chaine ressemble à un email
        return preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $email) ?? 'Cet email est correct.' ?? 'Cet email a un format non adapté.';
    }
}
