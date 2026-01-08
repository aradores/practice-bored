document.addEventListener('alpine:init', () => {
    Alpine.store('left_sidebar', {
        is_minimized: false,

        toggleSidebarSize() {
            this.is_minimized = !this.is_minimized;
        }
    });
});