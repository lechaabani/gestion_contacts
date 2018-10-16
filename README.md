# GestionContacts

# Projet Symfony 3.4
Gestion de contact avec systeme d'authentification

# Auteur
Hamadi Chaabani

# Fonctionnalité
- Système d'authentification avec Guard
- Lister tous les contacts
- Création d'un nouveau contact
- Mise à jour d'un contact existant
- Suppression d'un contact
- Gestion des adresses


# Installation :
    git clone https://github.com/lechaabani/gestion_contacts.git
    cd gestion_contacts
    composer install (ou php composer.phar install)

# Choisir vos paramettres :
    database_host: 127.0.0.1
    database_port: null
    database_name: gestion_contact
    database_user: xxxx
    database_password: xxxx

# Creation du BDD :
    php bin/console d:d:c

# MAJ du shema du BDD :
    php bin/console d:s:u --force

# Lancer serveur php en locale
    php bin/console server:start

# Lancer le test unitaire des services
    phpunit tests/AppBundle/Service
