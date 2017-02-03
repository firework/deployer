(function() {
    var showDialogButton = document.querySelector('#fire'),
        formDeploy = document.querySelector('form'),
        serverSelect = document.querySelector('#select-server'),
        branchSelect = document.querySelector('#select-branch'),
        taskSelect = document.querySelector('#select-task'),
        progressBar = document.querySelector('#progress-bar');

    if (showDialogButton) {
        var dialog = new DeployerConfirmDialog();

        showDialogButton.addEventListener('click', function(event) {
            event.preventDefault();

            if(serverSelect.value === "-1") {
                serverSelect.parentNode.classList.add('is-invalid');
                return;
            } else {
                serverSelect.parentNode.classList.remove('is-invalid');
            }

            if(taskSelect.value === "-1") {
                taskSelect.parentNode.classList.add('is-invalid');
                return;
            } else {
                taskSelect.parentNode.classList.remove('is-invalid');
            }

            if(branchSelect.value === "-1") {
                branchSelect.parentNode.classList.add('is-invalid');
                return;
            } else {
                branchSelect.parentNode.classList.remove('is-invalid');
            }

            dialog.showModal(function() {
                formDeploy.submit();
            }.bind(this));
        }.bind(this));
    }

    if(serverSelect) {
        serverSelect.addEventListener("change", function() {
            fillBranches(serverSelect.value);
        }.bind(this));
    }

    function fillBranches(serverId) {
        progressBar.className = 'is-loading';
        branchSelect.disabled = true;
        axios.get('/server/' + serverId + '/branches')
            .then(function(response) {
                progressBar.className = '';
                if(response && response.data) {
                    branchSelect.options.length = 0;

                    var msg = document.createElement('option');
                    msg.innerHTML = 'Select a Branch';
                    msg.disabled = true;
                    msg.selected = true;
                    msg.value = -1;
                    branchSelect.appendChild(msg);

                    response.data.forEach(function(branch) {
                        var opt = document.createElement('option');
                        opt.innerHTML = branch;
                        opt.value = branch;
                        branchSelect.appendChild(opt);
                    }, this);
                    branchSelect.disabled = false;
                }
            }.bind(this));
    }
})();
