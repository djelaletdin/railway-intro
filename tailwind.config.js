import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    safelist: [
        // Add Font Awesome classes you'll use
        'fa-bolt',
        'fa-fire',
        'fa-heart',
        'fa-shield',
        'fa-sparkles',
        // Add more as needed...
    ],
    theme: {
        extend: {
            colors: {
                'railway': '#010861'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    darkMode: 'false',
    plugins: [forms],
};
