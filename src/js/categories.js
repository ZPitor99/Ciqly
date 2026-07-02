import '@fontsource/sora/300.css';
import '@fontsource/sora/400.css';
import '@fontsource/sora/500.css';
import '@fontsource/sora/600.css';
import '@fontsource/sora/700.css';
import '@fontsource/lora/400.css';
import '@fontsource/lora/600.css';
import '@fontsource/lora/400-italic.css';

import '../css/style_commun.css'
import { burger } from "./partage.js";
import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('groupe_content', () => ({
        // Référentiels chargés une seule fois
        groupeToSousGroupe: {},
        sousGroupeToSousSousGroupe: {},

        // Sélection courante
        groupeSelectionne: null,
        sousGroupeSelectionne: 'all',
        sousSousGroupeSelectionne: 'all',

        // Listes affichées dans les <select>
        sousGroupesCourant: [],
        sousSousGroupesCourant: [],

        async init() {
            try {
                const res1 = await fetch('/api', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ method: 'groupeToSousGroupe', params: {} })
                });
                const data1 = await res1.json();
                console.log(data1);
                this.groupeToSousGroupe = data1.result ?? data1;

                const res2 = await fetch('/api', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ method: 'sousGroupeToSousSousGroupe', params: {} })
                });
                const data2 = await res2.json();
                console.log(data2);
                this.sousGroupeToSousSousGroupe = data2.result ?? data2;
            } catch (err) {
                console.log('Erreur de chargement du JSON via API', err);
            }
        },

        // Appelé au clic sur une carte de groupe
        selectGroupe(index) {
            this.groupeSelectionne = index;
            this.sousGroupeSelectionne = 'all';
            this.sousSousGroupeSelectionne = 'all';

            this.sousGroupesCourant = this.groupeToSousGroupe[index] ?? [];

            // "Tous" par défaut → on précharge l'agrégat des sous-sous-groupes
            this.loadSousSousGroupes();
        },

        // Recalcule la liste des sous-sous-groupes selon le sous-groupe choisi
        loadSousSousGroupes() {
            if (this.sousGroupeSelectionne === 'all') {
                // Tous les sous-sous-groupes de tous les sous-groupes du groupe sélectionné
                const agregat = new Map(); // dédoublonne par id au cas où
                for (const sg of this.sousGroupesCourant) {
                    const liste = this.sousGroupeToSousSousGroupe[sg.id] ?? [];
                    for (const ssg of liste) {
                        agregat.set(ssg.id, ssg);
                    }
                }
                this.sousSousGroupesCourant = Array.from(agregat.values());
            } else {
                this.sousSousGroupesCourant =
                    this.sousGroupeToSousSousGroupe[this.sousGroupeSelectionne] ?? [];
            }

            this.sousSousGroupeSelectionne = 'all';
        }
    }));
});

Alpine.start();

window.onload = init;
function init() {
    burger();
}