(function (){
    var deleteButtons = document.querySelectorAll('.delete-button');

    if (deleteButtons) {
        var dialog = new DeployerConfirmDialog();
        var selectedUrl = '';

        deleteButtons.forEach(function(element) {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                selectedUrl = element.href;
                dialog.showModal(function() {
                    console.log(selectedUrl);
                    window.location = selectedUrl;
                }.bind(this));
            }.bind(this), false);
        }, this);
    }
})();
