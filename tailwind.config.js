import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Inter"', ...defaultTheme.fontFamily.sans],
                display: ['"Inter"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                apple: {
                    primary: '#0066cc',
                    focus: '#0071e3',
                    ink: '#1d1d1f',
                    'ink-muted': '#7a7a7a',
                    canvas: '#ffffff',
                    parchment: '#f5f5f7',
                    'surface-1': '#272729',
                    'surface-2': '#2a2a2c',
                    hairline: '#e0e0e0',
                }
            },
            boxShadow: {
                'apple-product': 'rgba(0, 0, 0, 0.22) 3px 5px 30px 0px',
            }
        },
    },

    plugins: [forms],
};
