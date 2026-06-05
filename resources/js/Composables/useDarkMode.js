import { ref, watch, onMounted } from 'vue';

const isDark = ref(false);

export function useDarkMode() {
    onMounted(() => {
        const stored = localStorage.getItem('darkMode');
        if (stored !== null) {
            isDark.value = stored === 'true';
        } else {
            isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        applyTheme();
    });

    watch(isDark, () => {
        applyTheme();
    });

    function applyTheme() {
        if (isDark.value) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        localStorage.setItem('darkMode', isDark.value);
    }

    function toggle() {
        isDark.value = !isDark.value;
    }

    return { isDark, toggle };
}
