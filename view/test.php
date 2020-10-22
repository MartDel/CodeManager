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

        <aside class="modal" aria-hidden="true" role="dialog" aria-modal="false" style="display: none;" id="test">
            <div class="modal-wrapper">
                <h1>test</h1>
                <button type="button" class="close-modal">close</button>
            </div>
        </aside>
        <aside class="modal" aria-hidden="true" role="dialog" aria-modal="false" style="display: none;" id="test2">
            <div class="modal-wrapper">
                <h1>test2</h1>
                <button type="button" class="close-modal">close</button>
            </div>
        </aside>

        <script type="text/javascript" src="public/JS/Modal.js"></script>
        <script type="text/javascript" src="public/JS/app.js"></script>
    </body>
</html>
