WP Idea Stream Reloaded
=======================

Bienvenue
---------

Ce plugin Wordpress est une extension du plugin original **"WP Idea Stream"** écrit par **iMath** (http://imath.owni.fr/2011/05/30/wp-idea-stream/), permettant de pouvoir ajouter la fonctionnalité de "user feedback" ou plus communément appellé "boîte à idée" à votre instance Wordpress 3.x.

Je souhaitais améliorer le plugin en m'inspirant du système UserVoice Feedback (http://uservoice.com/) et de son interface.

Cette version ajoute et modifie les points suivant du plugin original :

* Possibilité de poster des idées sans être connecté ou inscrit (option paramétrable dans l'administration)
* Remplacement du système de notation par étoile avec un système de vote unique (via le plugin Vote It Up)
* Refonte de l'interface de paramétrage d'options

Il a été testé avec la dernière version en date de Wordpress (à savoir la 3.3), et est fonctionnel. Il se peut toutefois qu'il subiste des bugs, et je vous invite à les faire remonter via le tracker de GitHub.

Ce plugin est livré **tel-quel**, j'assure un support et un suivi des corrections au plugin mais je ne saurais être responsable des problèmes liés à une installation qui aurait endommagé votre instance Wordpress. Par prudence, testez-le dans un projet local, personnalisez-le si vous le souhaitez et importez-le dans votre site en production.

N'hésitez pas à réagir, postez un message sur le tracker GitHub (https://github.com/maxgranier/wp-idea-stream-reloaded/issues)


INSTALLATION
------------

1. Clonez ce dépot ou récupérez le zip et placez le dans votre répertoire plugins : _/wp-content/plugins/wp-idea-stream_
2. Téléchargez et dézippez le plugin **[Vote It Up](http://wordpress.org/extend/plugins/vote-it-up/)** dans le répertoire _/wp-content/plugins/vote-it-up_
3. Dans votre admin Wordpress, activez les plugins WP Idea Stream et Vote It Up
4. Paramétrez vos permaliens pour les mettre à jour avec les url du plugin WP Idea Stream
5. Configurez le plugin **WP Idea Stream** et **Vote It Up** selon vos besoins (création de catégories, design, etc...)
6. Profitez!

FACULTATIF : Vous pouvez écraser les templates du plugin actuel (optimisé pour le thème TwentyEleven) en créant vos propres fichiers thèmes :

* all-ideas.php
* best-ideas.php
* category-ideas.php
* featured-ideas.php
* idea-author.php
* new-idea.php
* single-idea.php
* tag-ideas.php

Pour une documentation plus détaillée du fonctionnement du plugin, consultez la page d'iMath (http://imath.owni.fr/2011/05/30/wp-idea-stream/).

