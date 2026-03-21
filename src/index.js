import '@fontsource/sora/300.css';
import '@fontsource/sora/400.css';
import '@fontsource/sora/500.css';
import '@fontsource/sora/600.css';
import '@fontsource/sora/700.css';
import '@fontsource/lora/400.css';
import '@fontsource/lora/600.css';
import '@fontsource/lora/400-italic.css';

import './css/style_commun.css'
import './css/style_index.css'
import Alpine from 'alpinejs'
import { burger } from '/js/partage';

window.Alpine = Alpine
Alpine.start()

let langue = "fr"

window.onload = init
function init(){
    document.getElementById("trad").addEventListener('click', (event) => {
        traduire()
    })
    burger()
}


function traduire(){
    langue = (langue === "fr") ? "en" : "fr";
}