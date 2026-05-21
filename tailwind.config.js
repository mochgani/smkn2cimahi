import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                bg: {
                    DEFAULT: '#fafaf8',
                    alt: '#f4f2ec',
                },
                ink: {
                    DEFAULT: '#0a0a0a',
                    soft: '#1a1a1a',
                },
                accent: {
                    DEFAULT: '#0d6e3f',
                    dark: '#095530',
                    light: '#fcd34d',
                },
                muted: {
                    DEFAULT: '#6b6b66',
                    soft: '#3a3a36',
                },
                line: {
                    DEFAULT: '#d4d0c5',
                    soft: '#e8e6e0',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                mono: ['"JetBrains Mono"', 'ui-monospace', 'SF Mono', 'monospace'],
            },
            maxWidth: {
                page: '1280px',
            },
            spacing: {
                page: '56px',
            },
            letterSpacing: {
                tightest: '-0.02em',
                tighter: '-0.01em',
                mono: '0.05em',
                'mono-wide': '0.08em',
            },
        },
    },

    plugins: [forms],
};
