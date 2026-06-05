import '../css/app.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('darkMode', () => ({
    currentTab: 'learner',
    dark: localStorage.getItem('darkMode') === 'true' ||
        (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    init() {
        this.$watch('dark', val => {
            this.applyDark(val);
        });
        this.applyDark(this.dark);
    },
    applyDark(val) {
        if (val) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        localStorage.setItem('darkMode', val);
    },
    toggle() {
        this.dark = !this.dark;
    },
}));

Alpine.start();
