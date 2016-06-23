var dialog = document.querySelector('dialog'),
    showDialogButton = document.querySelector('#fire'),
    formDeploy = document.querySelector('form');

if (! dialog.showModal) {
    dialogPolyfill.registerDialog(dialog);
}

showDialogButton.addEventListener('click', function() {
    dialog.showModal();
});

dialog.querySelector('.close').addEventListener('click', function() {
    dialog.close();
});

dialog.querySelector('.accept').addEventListener('click', function() {
    formDeploy.submit();
});
