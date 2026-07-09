import '@fontsource/sora/300.css';
import '@fontsource/sora/400.css';
import '@fontsource/sora/500.css';
import '@fontsource/sora/600.css';
import '@fontsource/sora/700.css';
import '@fontsource/lora/400.css';
import '@fontsource/lora/600.css';
import '@fontsource/lora/400-italic.css';

import '../css/style_commun.css'
import { burger } from './partage.js';
import Alpine from 'alpinejs'

window.Alpine = Alpine
document.addEventListener('alpine:init', () => {
    Alpine.data('infoods', () => ({
        table_infoods: [],

        init() {
            this.loadJSON();
        },

        loadJSON() {
            let request = new XMLHttpRequest();
            request.open('GET', '/static/data_flat/table_infoods.json');
            request.send();
            request.onreadystatechange = () => {
                if (request.readyState === 4 && request.status === 200) {
                    this.table_infoods = JSON.parse(request.responseText);
                }
            }
        }

    }))
})
Alpine.start()

window.onload = init
function init() {
    burger();
}