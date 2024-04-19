import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    auth: {
        headers: {
            Accept: 'application/json',
        },
    },
});

window.Echo.connector.pusher.connection.bind('connected', () => {
    window.Echo.private('admin.all.chats')
        .listen('.message', (e) => {
            const message = e.message;
            const pathname = window.location.pathname;
            const content = message.content;
            const sender = message.sender;
            const fullPath = `/${import.meta.env.VITE_APP_ADMIN_PATH}/users/${sender.id}/chat`;

            if (fullPath === pathname) {
                return;
            }

            new FilamentNotification()
                .title(sender.name)
                .body(content)
                .info()
                .persistent()
                .actions([
                    new FilamentNotificationAction('view')
                        .label('View')
                        .button()
                        .url(fullPath),
                    new FilamentNotificationAction('undo')
                        .label('Close')
                        .color('secondary')
                        .close(),
                ])
                .send();
        });
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.log('disconnected');
    window.Echo.leave('admin.all.chats');
});
