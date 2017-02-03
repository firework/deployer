(function() {
    var showDialogButton = document.querySelector('#fire'),
        formDeploy = document.querySelector('form');

    if (showDialogButton) {
        var dialog = new DeployerConfirmDialog();

        showDialogButton.addEventListener('click', function() {
            dialog.showModal(function() {
                formDeploy.submit();
            }.bind(this));
        }.bind(this));
    }
})();
