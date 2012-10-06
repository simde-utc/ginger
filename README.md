ginger
======

Outil de gestion des cotisants

La configuration de la base de données se fait dans build/conf. Il faut copier le fichier `ginger-conf.dist.php` en `ginger-conf.php` et modifier les paramètres SQL à l'intérieur.

La structure de la base vide est dans `build/conf/schema.sql`.

Pour récupérer propel, faire à la racine:

  git submodule init
  git submodule update
