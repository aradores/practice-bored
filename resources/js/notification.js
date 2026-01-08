export const notifications = () => ({
    notification: null,
    interval: null,
    init() {
        window.addEventListener('notify', ({ detail }) => this.add(detail.title, detail.message, detail.type));
    },
    add(title, message = '', type = 'success') {
        if (this.notification) {
            clearTimeout(this.interval);
            this.notification = null;
        }

        this.notification = {
            title: title,
            message: message,
            type: type,
            visible: false
        }

        this.$nextTick(() => {
            this.notification.visible = true;
        });

        this.interval = setTimeout(() => {
            this.remove();
        }, 3000);
    },
    remove() {
        this.notification.visible = false;

        setTimeout(() => {
            this.notification = null;
        }, 300);
    }
})

export const notify = function (Alpine) {
    Alpine.magic('notify', () => (title, message, type) =>
        window.dispatchEvent(new CustomEvent('notify', {
            detail: { title, message, type }
        }))
    )
}