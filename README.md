# CodeManager - Gestion de projet de développement en équipe

[CodeManager](https://www.codemanager.fr) est un site de gestion de projet informatique en équipe. Gérez *ce qu'il vous reste à faire*, fixez vous *des objectifs* et ayez *une vue d'ensemble* sur votre projet avec les divers fonctionnalités de [CodeManager](https://www.codemanager.fr).

## Les fonctionnalités :

* [x] **Gestion des tâches :** Notez, effacez, terminez.. Des idées plein la tête? Notez-les dans la section *tâches* pour ne rien oublier!
* [ ] **Les objectifs :** Pour être productif il est important de se fixer des *objectifs*. Compilez tout ce qu'il vous reste à faire ici en l'organisant sous forme d'objectifs et gérez votre projet de la meilleure des manières! *(En développement)*
* [ ] **Gestion de l'équipe :** Avoir *une bonne équipe de développement* est primordiale pour avancer le plus vite possible. Ajoutez des *membres*, gérez leurs *privilèges* et leur *rôle* dans votre projet afin que chacun puisse avoir une idée claire de sa mission. *(En développement)*
* [ ] **Discussion :** Sans une bonne *communication*, rien n'est possible! *Échangez* avec vos collaborateurs sur l'avancé du projet et les initiatives que vous souhaitez prendre. *(En développement)*
* [ ] **Liaison avec GitHub :** Liez votre projet avec *votre dépôt GitHub* pour synchronisez vos avancés et avoir *une vision globale* de votre projet. *(En développement)*

## Comment installer CodeManager en local et le tester sur son ordinateur

Le site [CodeManager](https://www.codemanager.fr) est disponible en ligne et configuré sur le serveur. Si vous souhaitez tester le code plus en détails sur votre ordinateur, suivez ces instructions :

### Cloner le dépôt sur votre machine

Dans un premier temps, il faut importer les fichiers sur votre ordinateur. Pour cela, positionnez-vous dans le dossier de travail de votre serveur local *(souvent www)* et tapez :

```
git clone https://github.com/MartDel/CodeManager
```

### Configurer la base de données

Créez une base de données nommée `codemanager` et possédant l'encodage `utf8_general_ci`. Puis importer le fichier `codemanager.sql` situé dans le dossier `public/SQL`. Générez la base de données grâce à ce fichier.

Ensuite il faut permettre au site de s'y connecter, pour cela créez un fichier nommé `Passwords.php` dans le dossier `class` du répertoire. Puis glissez-y ce code :

```php
abstract class Passwords {
    const DB_USERNAME = "NomDUtilisateur";  // Insérez ici le nom d'utilisateur
    const DB_PASSWORD = "MotDePasse";   // Insérez ici le mot de passe
}
```

**N'oubliez pas de compléter le code ci-dessus avec les informations de connexion propre à votre base de données ainsi que la balise ouvrante de php au début du code !**

Sur [CodeManager en ligne](https://www.codemanager.fr) un compte vous a été créé au préalable. En local vous devez vous inscrire vous-même sur la page *Inscription* du site.

### Lancer le site

Tout est prêt ! Allumez votre serveur local et rendez-vous sur `localhost` pour tester notre site créé avec soin par Tom Mullier *(@TomMullier)* et Martin Delebecque *(@MartDel)*.
