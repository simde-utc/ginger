ginger
======

Outil de gestion des cotisants

Toute la configuration se fait dans `config.php`. Il faut copier le fichier `config.dist.php` en `config.php` et modifier les paramètres.

La structure de la base est dans `build/conf/schema.sql` (ou utiliser `./propel-gen insert-sql` - mais attention cela efface toutes les données !).

Pour installer doctrine et sa dépendance :

    curl -s https://getcomposer.org/installer | php
    php composer.phar install

Pour reconstruire les classes à partir du modèle :

    ./propel-gen

Si cela donne un problème de permission, faire :

    chmod +x vendor/propel/propel1/generator/bin/phing.php

Après un changement du schéma dans `schema.xml`, pour générer une migration :
 
    ./propel-gen diff
 
Pour appliquer cette migration (penser à commit le fichier php que propel créé dans build/ pour les autres) :
 
    ./propel-gen migrate
