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
import ApexCharts from 'apexcharts';
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()

function initGraphique() {
    const emplacement = document.getElementById('chart');
    if (!emplacement) return;

    const brut = JSON.parse(emplacement.dataset.graphique);

    // On lit directement le CSS(style_commun.css) pour que le graphique reste cohérent si la charte évolue.
    const racine = getComputedStyle(document.documentElement);
    const jeton = (nom, repli) => racine.getPropertyValue(nom).trim() || repli;
    const ink       = jeton('--ink', '#1A2433');
    const inkMid    = jeton('--ink-mid', '#3D4F66');
    const inkSoft   = jeton('--ink-soft', '#7A8FA8');
    const border    = jeton('--border', 'rgba(26,36,51,0.09)');
    const sandDark  = jeton('--sand-dark', '#C9A88A');
    const fontBody  = jeton('--font-body', 'Sora').replace(/['"]/g, '');
    const palette = [inkSoft, sandDark, sandDark, sandDark];

    const noms = Object.keys(brut);
    const pourcentages = [];
    const actuels = [];
    const recommandes = [];

    noms.forEach((nom) => {
        const recommandee = Number(brut[nom].recommandee);
        const calculee = Number(brut[nom].calculee);
        const pourcentage = recommandee > 0
            ? Math.min(100, (calculee / recommandee) * 100)
            : 0;

        pourcentages.push(Math.round(pourcentage * 10) / 10);
        actuels.push(calculee);
        recommandes.push(recommandee);
        console.log(brut[nom]);
    });

    const options = {
        chart: {
            type: 'bar',
            height: 380,
            toolbar: { show: false },
            fontFamily: `${fontBody}, sans-serif`,
            background: 'transparent',
            animations: { easing: 'easeinout', speed: 500 }
        },
        series: [{
            name: 'Progression',
            data: pourcentages
        }],
        xaxis: {
            categories: noms.map(n => n.charAt(0).toUpperCase() + n.slice(1)),
            labels: {
                style: { fontSize: '14px', fontWeight: 600, colors: inkMid }
            },
            axisBorder: { color: border },
            axisTicks: { color: border }
        },
        yaxis: {
            max: 100,
            labels: {
                formatter: (v) => `${v}%`,
                style: { colors: inkSoft, fontSize: '12px' }
            }
        },
        plotOptions: {
            bar: {
                distributed: true,
                columnWidth: '48%',
                borderRadius: 8,
                borderRadiusApplication: 'end'
            }
        },
        colors: palette,
        legend: { show: false },
        dataLabels: { enabled: false },
        grid: {
            borderColor: border,
            strokeDashArray: 4,
            padding: { left: 8, right: 8 }
        },

        // Tooltip interactif : valeur actuelle + recommandée
        tooltip: {
            custom: function ({ dataPointIndex }) {
                const nom = noms[dataPointIndex];
                const actuel = actuels[dataPointIndex];
                const recommande = recommandes[dataPointIndex];
                const pct = pourcentages[dataPointIndex];

                return `
                    <div style="
                        font-family:${fontBody},sans-serif;
                        background:#fff;
                        border:1px solid ${border};
                        border-radius:12px;
                        box-shadow:0 8px 32px rgba(26,36,51,0.12);
                        padding:0.65rem 0.9rem;
                    ">
                        <div style="font-weight:600; color:${ink}; text-transform:capitalize; margin-bottom:2px;">
                            ${nom}
                        </div>
                        <div style="font-size:0.8rem; color:${inkMid};">
                            ${actuel} / ${recommande} &nbsp;·&nbsp; <strong>${pct}%</strong>
                        </div>
                    </div>
                `;
            }
        }
    };

    const chart = new ApexCharts(emplacement, options);
    chart.render();
}
document.addEventListener('DOMContentLoaded', initGraphique);


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