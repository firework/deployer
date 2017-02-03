(function() {
    var showDialogButton = document.querySelector('#fire'),
        formDeploy = document.querySelector('form'),
        serverSelect = document.querySelector('#select-server'),
        taskSelect = document.querySelector('#select-task'),
        branchSelect = document.querySelector('#select-branch'),
        progressBar = document.querySelector('#progress-bar');

    if (showDialogButton) {
        var dialog = new DeployerConfirmDialog();

        showDialogButton.addEventListener('click', function(event) {

            event.preventDefault();

            var error = false;
            var selects = [ serverSelect, taskSelect, branchSelect ];

            selects.forEach(function(select) {
                if(select.value === "-1") {
                    select.parentNode.classList.add('is-invalid');
                    error = true;
                } else {
                    select.parentNode.classList.remove('is-invalid');
                }
            }, this);

            if(!error) {
                dialog.showModal(function() {
                    formDeploy.submit();
                });
            }

        });
    }

    if(serverSelect) {
        serverSelect.addEventListener("change", function() {
            fillBranches(serverSelect.value);
        });
    }

    function fillBranches(serverId) {
        progressBar.classList.add('is-loading');
        branchSelect.disabled = true;

        axios.get('/server/' + serverId + '/branches')
            .then(function(response) {

                progressBar.classList.remove('is-loading');

                if(response && response.data) {
                    var defaultOpt = branchSelect.querySelector("[disabled]");

                    branchSelect.options.length = 0;

                    branchSelect.appendChild(defaultOpt);

                    response.data.forEach(function(branch) {
                        var opt = document.createElement('option');
                        opt.innerHTML = branch;
                        opt.value = branch;
                        branchSelect.appendChild(opt);
                    });

                    branchSelect.disabled = false;

                }
            });
    }
})();
