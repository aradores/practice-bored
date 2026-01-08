export const notifications = () => ({
    notification: null,
    interval: null,
    init() {
        window.addEventListener('notify', ({ detail }) => this.add(detail.title, detail.message, detail.type));
    },
    add(title, message = '', type = 'success') {
        if (this.notification) {
            this.remove();
        }

        this.notification = {
            title: title,
            message: message,
            type: type,
            visible: true
        }
    },
    remove() {
        clearInterval(this.interval);
        this.notification = null
    }
})

export const notify = function (Alpine) {
    Alpine.magic('notify', () => (title, message, type) =>
        window.dispatchEvent(new CustomEvent('notify', {
            detail: { title, message, type }
        }))
    )
}