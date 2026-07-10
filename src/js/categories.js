import '@fontsource/sora/300.css';
import '@fontsource/sora/400.css';
import '@fontsource/sora/500.css';
import '@fontsource/sora/600.css';
import '@fontsource/sora/700.css';
import '@fontsource/lora/400.css';
import '@fontsource/lora/600.css';
import '@fontsource/lora/400-italic.css';

import '../css/style_commun.css'
import '../css/style_aliments_liste.css'
import { burger } from "./partage.js";
import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('groupe_content', (groupeInitial = null, sousGroupeInitial = 'all', sousSousGroupeInitial = 'all') => ({
        groupeToSousGroupe: {},
        sousGroupeToSousSousGroupe: {},

        groupeSelectionne: groupeInitial,
        sousGroupeSelectionne: sousGroupeInitial,
        sousSousGroupeSelectionne: sousSousGroupeInitial,

        sousGroupesCourant: [],
        sousSousGroupesCourant: [],

        async init() {
            try {
                const res1 = await fetch('/api', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ method: 'groupeToSousGroupe', params: {} })
                });
                this.groupeToSousGroupe = (await res1.json()).result ?? {};
                console.log(this.groupeToSousGroupe);

                const res2 = await fetch('/api', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ method: 'sousGroupeToSousSousGroupe', params: {} })
                });
                this.sousGroupeToSousSousGroupe = (await res2.json()).result ?? {};

                // Si un groupe est déjà sélectionné (retour depuis l'URL),
                // on reconstruit les listes de selects correspondantes
                if (this.groupeSelectionne !== null) {
                    this.sousGroupesCourant = [...(this.groupeToSousGroupe[this.groupeSelectionne] ?? [])]
                        .sort((a, b) => a.nom.localeCompare(b.nom, 'fr', { sensitivity: 'base' }));
                    this.recalculerSousSousGroupes();
                }
            } catch (err) {
                console.error('Erreur de chargement du JSON via API', err);
            }
        },

        selectGroupe(index) {
            this.groupeSelectionne = index;
            this.sousGroupeSelectionne = 'all';
            this.sousSousGroupeSelectionne = 'all';

            this.sousGroupesCourant = [...(this.groupeToSousGroupe[index] ?? [])]
                .sort((a, b) => a.nom.localeCompare(b.nom, 'fr', { sensitivity: 'base' }));

            this.recalculerSousSousGroupes();
        },

        loadSousSousGroupes() {
            this.recalculerSousSousGroupes();
            this.sousSousGroupeSelectionne = 'all';
        },

        recalculerSousSousGroupes() {
            if (this.sousGroupeSelectionne === 'all') {
                const agregat = new Map();
                for (const sg of this.sousGroupesCourant) {
                    const liste = this.sousGroupeToSousSousGroupe[sg.id] ?? [];
                    for (const ssg of liste) agregat.set(ssg.id, ssg);
                }
                this.sousSousGroupesCourant = Array.from(agregat.values())
                    .sort((a, b) => a.nom.localeCompare(b.nom, 'fr', { sensitivity: 'base' }));
            } else {
                this.sousSousGroupesCourant = [...(this.sousGroupeToSousSousGroupe[this.sousGroupeSelectionne] ?? [])]
                    .sort((a, b) => a.nom.localeCompare(b.nom, 'fr', { sensitivity: 'base' }));
            }
        }
    }));
});

Alpine.start();

window.onload = init;
function init() {
    burger();
}