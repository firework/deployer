var server = require('http').Server();
var io = require('socket.io')(server);
require('dotenv').config();

var Redis = require('ioredis');
var redis = new Redis();

redis.psubscribe('*');

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    io.emit(channel, message.data);
});

server.listen(process.env.SOCKET_PORT);

server.on('listening', function () {
    console.log('Socket server listening successfully on port ' + process.env.SOCKET_PORT);
});
