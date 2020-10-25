<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Test Modal</title>
        <link rel="stylesheet" type="text/css" href="public/CSS/template/modals.css" />
        <link rel="stylesheet" type="text/css" href="public/CSS/template/message.css">

        <!-- Ionicons -->
        <!-- <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script> -->
        <script type="module" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule="" src="https://unpkg.com/ionicons@5.2.3/dist/ionicons/ionicons.js"></script>
    </head>
    <body>
        <button type="button" onclick="testModal()">Tester modal</button>
        <button type="button" onclick="error()">Message d'erreur</button>
        <button type="button" onclick="info()">Message d'info</button>

        <div id="modals" style="display:none;">
            <modal id="test1">
                <h1 style="text-align:center;">test</h1>
                <button class="close-modal">close</button>
            </modal>
        </div>

        <aside id="message" class="message">
            <h1 id="title">Titre</h1>
            <p id="content"><strong>Message:</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <div class="interact">
                <button type="button" id="close_message">&times;</button>
                <button type="button" id="action" style="display:flex;">
                    <ion-icon name="eye"></ion-icon>
                </button>
            </div>
        </aside>

        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script type="text/javascript" src="public/JS/modal.js"></script>
        <script type="text/javascript" src="public/JS/message.js"></script>
        <script type="text/javascript" src="public/JS/app.js"></script>
    </body>
</html>
