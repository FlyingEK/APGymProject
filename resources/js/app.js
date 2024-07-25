
// import Alpine from 'alpinejs';
// Import Bootstrap and its dependencies
// import 'bootstrap';
import 'jquery';
import '@popperjs/core';


// window.Alpine = Alpine;
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
});


// Alpine.start();
