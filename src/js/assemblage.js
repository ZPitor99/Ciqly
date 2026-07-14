import '@fontsource/sora/300.css';
import '@fontsource/sora/400.css';
import '@fontsource/sora/500.css';
import '@fontsource/sora/600.css';
import '@fontsource/sora/700.css';
import '@fontsource/lora/400.css';
import '@fontsource/lora/600.css';
import '@fontsource/lora/400-italic.css';

import '../css/style_commun.css'
import '../css/style_assemblage.css'
import { burger } from './partage.js';
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()

window.onload = init
function init() {
    burger();
}

function panierAction(action, l, id) {
    fetch('/action_panier_assemblage', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({action,id})
    })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Erreur');
                return;
            }

            const ligne = document.getElementById(l);
            if (!ligne) return;

            switch (action) {
                case 'reset': {
                    const input = ligne.querySelector('input[type="number"]');
                    input.value = 0;
                    // Synchro avec le x-model d'Alpine
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                    break;
                }

                case 'supprimer':
                    ligne.remove();
                    if (!document.querySelector('.assemblage-div')){
                        location.reload();
                    }
                    break;

                case 'monter': {
                    const prev = ligne.previousElementSibling;
                    if (prev && prev.classList.contains('assemblage-div')) {
                        ligne.parentNode.insertBefore(ligne, prev);
                    }
                    break;
                }

                case 'descendre': {
                    const next = ligne.nextElementSibling;
                    if (next && next.classList.contains('assemblage-div')) {
                        ligne.parentNode.insertBefore(next, ligne);
                    }
                    break;
                }
            }
        })
        .catch(err => console.error(err));
}
window.panierAction = panierAction;