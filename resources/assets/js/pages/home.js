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

            validateAndSubmitForm();
        });
    }

    if (serverSelect) {
        serverSelect.addEventListener("change", function() {
            fillBranches(serverSelect.value);
        });
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
                progressBar.classList.remove('is-loading');

                if (response && response.data) {
                    parseBranchesResponse(response.data);
                }
            });
    }

    function parseBranchesResponse (data) {
        var branches = data.branches || [];
        var tasks = data.tasks || [];

        var branchesName = branches.map(function (branch) {
            return { key: branch, value: branch };
        });

        parseSelect(branchesName, branchSelect);

        var tasksName = tasks.map(function (task) {
            return { key: task.id, value: task.name };
        });

        parseSelect(tasksName, taskSelect);
    }

    function parseSelect (items, select) {
        var defaultOpt = select.querySelector("[disabled]");

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
})();
