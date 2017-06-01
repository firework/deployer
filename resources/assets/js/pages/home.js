(function() {

    // parse query strings
    // https://stackoverflow.com/a/8486146
    var regex = /[?&]([^=#]+)=([^&#]*)/g,
        url = window.location.href,
        queryParams = {},
        match;

    while (match = regex.exec(url)) {
        queryParams[match[1]] = match[2];
    }

    var showDialogButton = document.querySelector('#fire'),
        formDeploy = document.querySelector('form'),
        serverSelect = document.querySelector('#select-server'),
        taskSelect = document.querySelector('#select-task'),
        branchSelect = document.querySelector('#select-branch'),
        progressBar = document.querySelector('#progress-bar');

    var autoSubmitForm = false;

    if (showDialogButton) {
        var dialog = new DeployerConfirmDialog();

        showDialogButton.addEventListener('click', function(event) {
            event.preventDefault();

            validateAndSubmitForm();
        });
    }

    if (serverSelect) {
        serverSelect.addEventListener("change", function() {
            fillBranches(serverSelect.value);
        });

        if (queryParams.server_id) {
            serverSelect.value = queryParams.server_id;

            fillBranches(serverSelect.value);

            if (queryParams.submit === "true") {
                autoSubmitForm = true;
            }
        }
    }

    function validateAndSubmitForm () {
        var error = false;
        var selects = [ serverSelect, taskSelect, branchSelect ];

        selects.forEach(function(select) {
            if (select.value === "-1") {
                select.parentNode.classList.add('is-invalid');
                error = true;
            } else {
                select.parentNode.classList.remove('is-invalid');
            }
        }, this);

        if (!error) {
            if (autoSubmitForm) {
                formDeploy.submit();
                return;
            }
            dialog.showModal(function() {
                formDeploy.submit();
            });
        }
    }

    function fillBranches (serverId) {
        progressBar.classList.add('is-loading');
        taskSelect.disabled = true;
        branchSelect.disabled = true;

        axios.get('/server/' + serverId + '/info')
            .then(function (response) {
                if (response && response.data) {
                    parseBranchesResponse(response.data);

                    if (autoSubmitForm) {
                        validateAndSubmitForm();
                    }
                }
            });
    }

    function parseBranchesResponse (data) {
        var branches = data.branches || [];
        var tasks = data.tasks || [];

        progressBar.classList.remove('is-loading');

        var branchesName = branches.map(function (branch) {
            return { key: branch, value: branch };
        });

        parseSelect(branchesName, branchSelect, queryParams.branch);

        var tasksName = tasks.map(function (task) {
            return { key: task.id, value: task.name };
        });

        parseSelect(tasksName, taskSelect, queryParams.task_id);
    }

    function parseSelect (items, select, activeValue) {
        var defaultOpt = select.querySelector("[disabled]");

        select.options.length = 0;

        select.appendChild(defaultOpt);

        items.forEach(function(item) {
            var opt = document.createElement('option');
            opt.innerHTML = item.value;
            opt.value = item.key;
            select.appendChild(opt);
        });

        if (activeValue) {
            select.value = activeValue;
        }

        select.disabled = false;

        select.parentNode.classList.remove('is-disabled');
    }
})();
