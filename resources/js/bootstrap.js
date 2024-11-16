import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Create a new instance of Echo
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true
});


// Check if window.userId is defined (i.e., user is authenticated)
if (window.userId) {
    // Subscribe to the private channel for the authenticated user
    window.Echo.private('user.' + window.userId)
        .listen('MessageSent', (event) => {
            console.log('New message received:', event.message);
            // Handle new message and update UI as needed
        });
} else {
    console.log('User is not authenticated.');
}

