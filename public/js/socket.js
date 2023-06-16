// var app = require('express')();
// var http = require('http').Server(app);
// var io = require('socket.io')(http, {
//     cors: {
//         origin: "http://localhost:3000",
//         methods: ["GET", "POST"],
//         allowedHeaders: ["abcd"],
//         credentials: false
//     }
// });
// var Redis = require('ioredis');
// var redis = new Redis();
//
//
// redis.subscribe('test-channel', function(err, count) {
// });
// redis.on('message', function(channel, message) {
//     console.log('Message Recieved: ' + message);
//     message = JSON.parse(message);
//     io.emit(channel + ':' + message.event, message.data);
// });
// http.listen(3000, function(){
//     console.log('Listening on Port 3000');
// });

var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();

function handler(req, res) {
    res.statusCode = 200;
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "X-Requested-With");
    res.header("Access-Control-Allow-Headers", "Content-Type");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    res.end('');
}

redis.subscribe('test-channel', function() {
    console.log('Logged on to test-channel.')
});

redis.on("InserUpdateDeleteEvent", function(channel, message) {
    console.log(channel + ': ' + message);

    io.emit(channel + ':' + message.event, message.data);
});

server.listen(3000, function(){
    console.log('Listening on Port 3000...');
});
