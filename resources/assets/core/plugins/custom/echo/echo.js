// import Echo from 'laravel-echo';
const Echo = require('laravel-echo');
window.io = require('socket.io-client');
window.Echo = new Echo.default({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':8443',
    reconnectionAttempts: 5,
    // transports: ['websocket']
});

