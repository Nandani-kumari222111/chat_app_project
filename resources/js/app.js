import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
console.log("App.js Loaded");
console.log(window.Echo);

window.Echo.private('chat.' + window.userId)
    .listen('MessageSent', (e) => {

        console.log("Message Received:", e);

        // Sirf current open chat ka message dikhana
        if (window.receiverId != e.sender_id) {
            return;
        }

        let messages = document.getElementById('messages');

        if (e.message_type === 'image') {

    messages.innerHTML += `
        <div class="text-start mb-2">
            <img src="/storage/${e.message}" width="300" height="250">
        </div>
    `;

} else {

    messages.innerHTML += `
        <div class="text-start mb-2">
            <span class="btn btn-light border">
                ${e.message}
            </span>
        </div>
    `;

}

        let chatBody = document.getElementById('chatBody');
        chatBody.scrollTop = chatBody.scrollHeight;

    });

    





    