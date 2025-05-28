import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ":" + window.laravel_echo_port
});



// import Echo from 'laravel-echo';
// import io from 'socket.io-client';
//
// // Configuración global de Socket.IO
// window.io = io;
//
// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     host: `${window.location.hostname}:6001`,
//     transports: ['websocket'],
//     withCredentials: true,
//     autoConnect: true,
//     reconnection: true,
//     reconnectionAttempts: Infinity
// });
//
