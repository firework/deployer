(function() {

    var showDialogButton = document.querySelector('#fire'),
        formDeploy = document.querySelector('form'),
        serverSelect = document.querySelector('#select-server'),
        taskSelect = document.querySelector('#select-task'),
        branchSelect = document.querySelector('#select-branch'),
        progressBar = document.querySelector('#progress-bar'),
        getUrlButton = document.querySelector('#get-url');

    if (showDialogButton) {
        var dialog = new DeployerConfirmDialog();

        showDialogButton.addEventListener('click', function(event) {
            event.preventDefault();

            validateAndSubmitForm();
        });
    }

    if (getUrlButton) {
        getUrlButton.addEventListener('click', function(event) {
            event.preventDefault();

            getUrlButtonClicked();
        });
    }

    if (serverSelect) {
        serverSelect.addEventListener('change', function() {
            fillBranches(serverSelect.value);
        });
    }

    function validateSelects () {
        var validation = true;
        var selects = [ serverSelect, taskSelect, branchSelect ];

        selects.forEach(function(select) {
            if (select.value === '-1') {
                validation = false;
                select.parentNode.classList.add('is-invalid');

                return;
            }

            select.parentNode.classList.remove('is-invalid');
        });

        if (! validation) {
            snackbarMessage('All fields are mandatory');
        }

        return validation;
    }

    function validateAndSubmitForm () {
        if (validateSelects()) {
            dialog.showModal(function() {
                formDeploy.submit();
            });

            return;
        }
    }

    function fillBranches (serverId) {
        progressBar.classList.add('is-loading');
        taskSelect.disabled = true;
        branchSelect.disabled = true;

        var route = laroute.route('server.info', {
            server: serverId,
        });

        axios.get(route)
            .then(function (response) {
                if (response && response.data) {
                    parseBranchesResponse(response.data);
                }
            })
            .catch(function() {
                snackbarMessage('An error occurred');
            })
            .finally(function() {
                progressBar.classList.remove('is-loading');
            });
    }

    function parseBranchesResponse (data) {
        var branches = data.branches || [];
        var tasks = data.tasks || [];

        var branchesName = branches.map(function (branch) {
            return {
                key: branch,
                value: branch,
            };
        });

        parseSelect(branchesName, branchSelect);

        var tasksName = tasks.map(function (task) {
            return {
                key: task.id,
                value: task.name,
            };
        });

        parseSelect(tasksName, taskSelect);
    }

    function parseSelect (items, select) {
        var defaultOpt = select.querySelector('[disabled]');

        select.options.length = 0;

        select.appendChild(defaultOpt);

        items.forEach(function(item) {
            var opt = document.createElement('option');
            opt.innerHTML = item.value;
            opt.value = item.key;
            select.appendChild(opt);
        });

        select.disabled = false;
    }

    function getUrlButtonClicked () {
        if (validateSelects()) {
            var route = laroute.route('get.deploy', {
                server_id: serverSelect.value,
                task_id: taskSelect.value,
                branch: branchSelect.value,
            });

            clipboard.writeText(route);
            snackbarMessage('Copied to clipboard.');

            return;
        }
    }
})();
