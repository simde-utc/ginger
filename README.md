ginger
======

Outil de gestion des cotisants

La configuration de la base de données se fait dans build/conf. Il faut copier le fichier `ginger-conf.dist.php` en `ginger-conf.php` et modifier les paramètres SQL à l'intérieur.

La structure de la base vide est dans `build/conf/schema.sql` (ou utiliser `./propel-gen insert-sql` - cela vide toutes les données !).

Il faut également ajouter l'URL de l'API Accounts dans le fichier `config.php` (modèle `config.dist.php`).

Pour récupérer propel, faire à la racine :

    git submodule init
    git submodule update

Pour installer doctrine :
    curl -s http://getcomposer.org/installer | php
    php composer.phar install

Pour faire fonctionner le script `propel-gen`, il faut installer phing :

    pear channel-discover pear.phing.info
    sudo pear install phing/phing

Pour reconstruire les classes à partir du modèle :

    ./propel-gen

Après un changement du schéma dans `schema.xml`, pour générer une migration :

    ./propel-gen diff

Pour appliquer cette migration (penser à commit le fichier php que propel créé dans build/ pour les autres) :

    ./propel-gen migrate