window.onload = function () {
    Echo.private('admin.all.chats')
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
};
