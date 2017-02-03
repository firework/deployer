function DeployerConfirmDialog() {

    this.dialog = document.querySelector('dialog');

    if (! this.dialog.showModal) {
        dialogPolyfill.registerDialog(this.dialog);
    }

    this.callback = function () {
        console.log('callback original')
    };

    this.showModal = function (callback) {
        this.callback = callback;
        this.dialog.showModal();
    }.bind(this);

    this.dialog.querySelector('.close').addEventListener('click', function() {
        this.dialog.close();
    }.bind(this));

    this.dialog.querySelector('.accept').addEventListener('click', function() {
        this.callback.call();
    }.bind(this));

    return {
        showModal: this.showModal,
        callback: this.callback
    };
}
