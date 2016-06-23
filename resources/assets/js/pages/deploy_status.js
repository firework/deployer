var pathArray = window.location.pathname.split('/');
var socket = io('http://'+ window.location.host +':3000');

var divOutput =  document.getElementById('output');
var spanStatus = document.getElementById('status');

socket.on('deploy-outputs.' + pathArray[2], function(data){
    divOutput.innerHTML += data.output;
    spanStatus.className = 'status status-' + data.deploy.status;
    spanStatus.innerHTML = data.deploy.status.charAt(0).toUpperCase() + data.deploy.status.slice(1);
});
