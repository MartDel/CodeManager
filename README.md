# CodeManager - Gestion de projet de développement en équipe

**CodeManager** est un site de gestion de projet informatique en équipe. Gérez *ce qu'il vous reste à faire*, fixez vous *des objectifs* et ayez *une vue d'ensemble* sur votre projet avec les divers fonctionnalités de **CodeManager**.

## Les fonctionnalités :

* [ ] **Gestion des tâches :** Notez, effacez, terminez.. Des idées plein la tête? Notez-les dans la section *tâches* pour ne rien oublier! *(En développement)*
* [ ] **Les objectifs :** Pour être productif il est important de se fixer des *objectifs*. Compilez tout ce qu'il vous reste à faire ici en l'organisant sous forme d'objectifs et gérez votre projet de la meilleur des manières! *(En développement)*
* [ ] **Gestion de l'équipe :** Avoir *une bonne équipe de développement* est primordiale pour avancer le plus vite possible. Ajoutez des *membres*, gérez leurs *privilèges* et leur *rôle* dans votre projet afin que chacun puisse avoir une idée claire de sa mission. *(En développement)*
* [ ] **Discussion :** Sans une bonne *communication*, rien n'est possible! *Échangez* avec vos collaborateurs sur l'avancé du projet et les initiatives que vous souhaitez prendre. *(En développement)*
* [ ] **Liaison avec GitHub :** Liez votre projet avec *votre dépôt GitHub* pour synchronisez vos avancés et avoir *une vision globale* de votre projet. *(En développement)*

## Télécharger et installer *Imagick* pour PHP >= 7.0 sur Ubuntu

Pour la gestion des photos de profil, CodeManager a besoin de la librairie *Imagick* pour rogner les photos.
L'installation se passe en 2 étapes :

* Installer *Imagick* pour PHP >= 7.0 sur son ordinateur : `sudo apt-get install php-imagick`
* Redémarrer Apache (ici il s'agit d'*apache2*) : `sudo service apache2 reload`

Et voilà, l'installation est terminée !

## Fichier ignoré : *class/Passwords.php*

Pour faire fonctionner le site grâce à la base de données il faut obligatoirement ajouter un fichier appelé `Passwords.php` dans le dossier *class* à la racine du projet. Créez-le et glissez-y ce code :

```php
abstract class Passwords {
    // Database config
    const DB_USERNAME = '<DB-login>'; // Remplacer <DB-login> par le login de votre base de données
    const DB_PASSWORD = '<DB-password>'; // Remplacer <DB-password> par le mot de passe de votre base de données
}
```
