
document.addEventListener('DOMContentLoaded', function() {


    Pusher.logToConsole = true;

    if (Notification.permission !== "granted") {
        Notification.requestPermission();
    }


        Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log("HI");
                console.log(notification.message);
                swal.fire({
                    title: notification.title,
                    text: notification.message,
                    icon: 'info',
                    confirmButtonText: 'Ok',
                    customClass: {
                        confirmButton: 'btn redBtn',
                    },
                })
               // showWebNotification(notification.title , notification.message);
                addNotificationToDropdown(notification.title, notification.message, notification.check_in_code, notification.datetime);
            });
    
});
           
function showWebNotification(title,message) {
    if (Notification.permission === "granted") {
        new Notification(title, {
            body: message,
            // icon: '/path/to/icon.png'
        });
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                new Notification(title, {
                    body: message,
                    // icon: '/path/to/icon.png'
                });
            }
        });
    }
}

function addNotificationToDropdown(title, message, checkInCode, datetime) {
    const notificationsList = document.getElementById('notificationsList');

    // Create the notification item container
    const notificationItem = document.createElement('li');
    notificationItem.className = 'notification-item';

    // Create the icon element
    const icon = document.createElement('i');
    icon.className = 'bi bi-exclamation-circle text-warning';

    // Create the notification content container
    const content = document.createElement('div');

    // Create and set the title element
    const titleElement = document.createElement('h6');
    titleElement.textContent = title;

    // Create and set the message element
    const messageElement = document.createElement('p');
    messageElement.html = message ;

    // Create and set the datetime element
    const datetimeElement = document.createElement('p');
    datetimeElement.textContent = datetime;

    // Append the title, message, and datetime to the content container
    content.appendChild(titleElement);
    content.appendChild(messageElement);
    content.appendChild(datetimeElement);

    // Append the icon and content to the notification item
    notificationItem.appendChild(icon);
    notificationItem.appendChild(content);

    // Insert the notification item at the beginning of the notifications list
    notificationsList.insertBefore(notificationItem, notificationsList.firstChild);

    // Update notification count
    const notificationsCount = document.getElementById('notificationsCount');
    notificationsCount.textContent = parseInt(notificationsCount.textContent) + 1;

}