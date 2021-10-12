/**
 *
 * @param type (info|error)
 * @param message
 * @param duration
 */
function showNotification(type, message, duration = 3000) {
    let background = (type === 'error') ? 'red' : 'green'
    let icon = (type === 'error') ? 'fa-exclamation-circle' : 'fa-check-circle'
    const notify = new Notyf({
        duration: duration,
        position: {
            x: 'right',
            y: 'bottom',
        },
        types: [
            {
                type: type,
                background: background,
                icon: {
                    className: `fas ${icon}`,
                    tagName: 'span',
                    color: '#fff'
                },
                dismissible: false
            }
        ]
    });
    notify.open({
        type: type,
        message: message
    })
}
