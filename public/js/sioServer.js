
// const server = require('https').createServer();
// const io = require('socket.io')(server);
// io.on('connection', client => {
//     client.on('event', data => { /* … */ });
//     client.on('disconnect', () => { /* … */ });
// });
// server.listen(3000);

// const nsp = io.of("/admin");
// nsp.on("connect", socket => {});


var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io')(server);

app.use(express.static(__dirname + '/node_modules'));
app.get('/', function(req, res,next) {
    res.sendFile(__dirname + '/index.html');
});

server.listen(4200);
