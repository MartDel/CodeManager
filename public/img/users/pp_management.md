# On stock les photos de profile ici

Elles se présentent sous la forme `<user_id>.<extension:.jpg/.jpeg/.gif/.png>` soit par exemple: *8.png*
On peut les afficher comme ceci :

```
<img src="public/img/<?= 'users/' . $_SESSION['pp'] ?>" alt="Photo de profil" />
```

Or il est possible, à la création du compte, que **l'utilisateur ne possède pas encore de photo de profil**. Dans ce cas on écrit :

```
<img src="public/img/<?= isset($_SESSION['pp']) ? 'users/' . $_SESSION['pp'] : '<DefaultPicture>' ?>" alt="Photo de profil" />
```

où `<DefaultPicture>` est le nom ET l'extension de la photo de profil par défaut donnée à un nouvel utilisateur. Elle doit être stockée dans le dossier `~/public/img/`.
