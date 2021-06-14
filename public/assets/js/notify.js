/**
 *
 * @param type (info|error)
 * @param message
 */
function showNotification(type, message) {
    let background = (type === 'error') ? 'red' : 'green'
    let icon = (type === 'error') ? 'fa-exclamation-circle' : 'fa-check-circle'
    const notify = new Notyf({
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
