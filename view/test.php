<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Test Modal</title>
        <link rel="stylesheet" type="text/css" href="public/CSS/modals.css" />
    </head>
    <body>
        <button type="button" onclick="test()">Tester modal</button>
        <button type="button" onclick="test2()">Tester modal 2</button>

        <div id="modals" style="display:none;">
            <modal id="test1">
                <h1 style="text-align:center;">test</h1>
                <button class="close-modal">close</button>
            </modal>
            <modal id="test2">
                <h1 style="text-align:center;">test2</h1>
                <button class="close-modal">close</button>
            </modal>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script type="text/javascript" src="public/JS/modal.js"></script>
        <script type="text/javascript" src="public/JS/app.js"></script>
    </body>
</html>
