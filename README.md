ginger
======

Outil de gestion des cotisants

Installation
------------

Installer propel et sa dépendance :

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

Modifier la configuration Mysql (copier les fichiers du git en retirant le .dist) :
* `buildtime-conf.xml`
* `build.properties`

Ajouter l'URL vers Accounts :
* `config.php`

Reconstruire les classes et la config :

    ./propel-gen

Si cela donne un problème de permission, faire :

    chmod +x vendor/propel/propel1/generator/bin/phing.php

Remplir les tables (ATTENTION cela efface toutes les données) :

    ./propel-gen insert-sql

Migrations
----------

Après un changement du schéma dans `schema.xml`, pour générer une migration :
 
    ./propel-gen diff
 
Pour appliquer cette migration (penser à commit le fichier php que propel créé dans build/ pour les autres) :
 
    ./propel-gen migrate
