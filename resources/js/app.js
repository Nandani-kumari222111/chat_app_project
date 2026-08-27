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
console.log("User ID: "+window.userId);

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
    })
    .listen('.user.typing', (e) => {
        if (window.receiverId != e.sender_id) return;

        const indicator = document.getElementById('typingIndicator');
        if (!indicator) return;

        if (e.is_typing) {
            indicator.style.display = 'block';
        } else {
            indicator.style.display = 'none';
        }
    });

// Presence channel — tracks who is online
    window.Echo.join('presence-online')
    .here((users) => {
        users.forEach(u => updateOnlineBadge(u.id, true));
    })
    .joining((user) => {
        updateOnlineBadge(user.id, true);
        if (window.receiverId == user.id) updateReceiverStatus(true);
    })
    .leaving((user) => {
        updateOnlineBadge(user.id, false);
        if (window.receiverId == user.id) updateReceiverStatus(false);
    });

function updateOnlineBadge(userId, isOnline) {
    const el = document.querySelector(`[data-user-id="${userId}"] .online-badge`);
    if (!el) return;
    if (isOnline) {
        el.innerHTML = '🟢 Online';
        el.className = 'online-badge text-success';
    } else {
        el.innerHTML = '⚫ Offline';
        el.className = 'online-badge text-secondary';
    }
}

function updateReceiverStatus(isOnline) {
    const el = document.getElementById('receiverOnlineStatus');
    if (!el) return;
    if (isOnline) {
        el.innerHTML = '🟢 Online';
        el.className = 'text-success';
    } else {
        el.innerHTML = '⚫ Offline';
        el.className = 'text-secondary';
    }
}

    





    