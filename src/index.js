import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

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

let langue = "fr"

window.onload = init

function init(){
    document.getElementById("trad").addEventListener('click', (event) => {
        traduire()
    })
}


function traduire(){
    langue = (langue === "fr") ? "en" : "fr";
}