# CodeManager

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

Sur [CodeManager en ligne](https://www.codemanager.fr) un compte vous a été créé au préalable. Ici vous devez vous inscrire sur la page de connexion.

### Lancer le site

Tout est prêt ! Allumez votre serveur local et rendez-vous sur `localhost` pour tester notre site créé avec soin par Tom Mullier *(@TomMullier)* et Martin Delebecque *(@MartDel)*.
