var pathArray = window.location.pathname.split('/');
var socket = io('http://'+ window.location.host +':3000');

socket.on('output-channel:' + pathArray[2], function(data){
    document.getElementById('output').innerHTML += data.output.replace(/(?:\r\n|\r|\n)/g, '<br/>');
    document.getElementById('status').className = 'status status-' + data.status;
    document.getElementById('status').innerHTML = data.status.charAt(0).toUpperCase() + data.status.slice(1);
});
