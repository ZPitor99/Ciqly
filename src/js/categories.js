import '@fontsource/sora/300.css';
import '@fontsource/sora/400.css';
import '@fontsource/sora/500.css';
import '@fontsource/sora/600.css';
import '@fontsource/sora/700.css';
import '@fontsource/lora/400.css';
import '@fontsource/lora/600.css';
import '@fontsource/lora/400-italic.css';

import '../css/style_commun.css'
import {burger} from "./partage.js";
import Alpine from "alpinejs";

window.Alpine = Alpine
document.addEventListener('alpine:init', () => {
    Alpine.data('groupe_content', () => ({
        groupeSelectionne: null,
        sousGroupeSelectionne: '',
        sousSousGroupeSelectionne: '',

        sousGroupeCourant: [],
        sousSousGroupeCourant: [],

        groupeToSousGroupe: {
            "0": [
                {"id": "viande-1", "nom": "Viandes crues"},
                {"id": "viande-2", "nom": "Viandes cuites"},
                {"id": "viande-3", "nom": "Poissons"}
            ],
            "1": [{"id": "viande-1", "nom": "Viandes crues"}]
        },
        sousGroupeToSousSousGroupe: {
            "viande-1": [
                {"id": "boeuf", "nom": "Bœuf"},
                {"id": "porc", "nom": "Porc"}
            ]
        },

        async init() {
            try {
                //const data1 = await fetch('json1');
                //this.groupeData = await data1.json();

                //const data2 = await fetch('json2');
                //this.groupeData = await data2.json();

                //fetch("/api/groupe_content").then(res => res.json()).then(data => this.data = data);
                console.log("Initializing...");
            }catch(err) {
                console.log('Erreur de chargement du JSON via API',err);
            }

        },

        selectGroupe(index) {
            this.groupeSelectionne = index;
            this.sousGroupeSelectionne = '';
            this.sousSousGroupeSelectionne = '';
            this.sousSousGroupesCourant = [];

            // Charger les sous-groupes correspondants
            if (this.groupeToSousGroupe && this.groupeToSousGroupe[index]) {
                this.sousGroupesCourant = this.groupeToSousGroupe[index];
            } else {
                this.sousGroupesCourant = [];
            }
        },

        // Chargement des sous-sous-groupes
        loadSousSousGroupes() {
            if (this.sousGroupeSelectionne === '') {
                this.sousSousGroupesCourant = [];
                this.sousSousGroupeSelectionne = '';
                return;
            }

            if (this.sousGroupeToSousSousGroupe && this.sousGroupeToSousSousGroupe[this.sousGroupeSelectionne]) {
                this.sousSousGroupesCourant = this.sousGroupeToSousSousGroupe[this.sousGroupeSelectionne];
            } else {
                this.sousSousGroupesCourant = [];
            }

            this.sousSousGroupeSelectionne = '';
        }
    }))
})
Alpine.start()


window.onload = init
function init() {
    burger()

    let artc = document.getElementsByClassName('cat-card');
    for (let i = 0; i < artc.length; i++) {
        artc[i].addEventListener('click', (e) => {
            let artc_to_remove = document.getElementsByClassName('cat-card');
            for (let i = 0; i < artc_to_remove.length; i++) {
                artc_to_remove[i].classList.remove('cat-card-selected')
            }
            artc[i].classList.add('cat-card-selected');
        })
    }
}
