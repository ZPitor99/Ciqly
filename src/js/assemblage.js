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

/**
 * Lit les jetons de couleurs/police directement dans le CSS (style_commun.css)
 * pour que les graphiques restent cohérents si la charte évolue.
 * @param extra permet de demander des jetons supplémentaires propres à un graphique donné :
 * @returns {{[p: string]: *, ink: *, inkMid: *, inkSoft: *, border: *, fontBody: *}}
 */
function lireJetons(extra = {}) {
    const racine = getComputedStyle(document.documentElement);
    const jeton = (nom, repli) => racine.getPropertyValue(nom).trim() || repli;

    return {
        ink:      jeton('--ink', '#1A2433'),
        inkMid:   jeton('--ink-mid', '#3D4F66'),
        inkSoft:  jeton('--ink-soft', '#7A8FA8'),
        border:   jeton('--border', 'rgba(26,36,51,0.09)'),
        fontBody: jeton('--font-body', 'Sora').replace(/['"]/g, ''),
        ...Object.fromEntries(
            Object.entries(extra).map(([cle, [nomCss, repli]]) => [cle, jeton(nomCss, repli)])
        )
    };
}


/**
 * Récupère et parse le JSON stocké dans data-graphique d'un élément.
 * Retourne null si l'élément n'existe pas, pour permettre un `return` anticipé.
 * @param idElement
 * @returns {{emplacement: HTMLElement, brut: any}|null}
 */
function lireDonneesGraphique(idElement) {
    const emplacement = document.getElementById(idElement);
    if (!emplacement) return null;
    return { emplacement, brut: JSON.parse(emplacement.dataset.graphique) };
}

/**
 * Construit le HTML commun des bulles de tooltip ApexCharts.
 * @param fontBody
 * @param border
 * @param contenu
 * @param centre
 * @returns {string}
 */
function boiteTooltip(fontBody, border, contenu, centre = false) {
    return `
        <div style="
            font-family:${fontBody},sans-serif;
            background:#fff;
            border:1px solid ${border};
            border-radius:12px;
            box-shadow:0 8px 32px rgba(26,36,51,0.12);
            padding:0.65rem 0.9rem;
            ${centre ? 'text-align:center;' : ''}
        ">
            ${contenu}
        </div>
    `;
}

function initGraphique() {
    const donnees = lireDonneesGraphique('chart');
    if (!donnees) return;
    const { emplacement, brut } = donnees;

    const { ink, inkMid, inkSoft, border, fontBody, sandDark } = lireJetons({
        sandDark: ['--sand-dark', '#C9A88A']
    });
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

                const contenu = `
                    <div style="font-weight:600; color:${ink}; text-transform:capitalize; margin-bottom:2px;">
                        ${nom}
                    </div>
                    <div style="font-size:0.8rem; color:${inkMid};">
                        ${actuel} / ${recommande} &nbsp;·&nbsp; <strong>${pct}%</strong>
                    </div>
                `;
                return boiteTooltip(fontBody, border, contenu);
            }
        }
    };

    const chart = new ApexCharts(emplacement, options);
    chart.render();
}

function initGraphiqueEau() {
    const donnees = lireDonneesGraphique('chart-eau');
    if (!donnees) return;
    const { emplacement, brut } = donnees;
    // Format attendu : { "poids_total_g": 620, "eau_g": 450 }

    const { ink, inkMid, inkSoft, border, fontBody, bleuEau } = lireJetons({
        bleuEau: ['--eau', '#378ADD']
    });

    const poidsTotal = Number(brut.poids_total_g);
    const eau = Number(brut.eau_g);
    const pourcentage = poidsTotal > 0
        ? Math.round((eau / poidsTotal) * 1000) / 10
        : 0;

    const options = {
        chart: {
            type: 'radialBar',
            height: 320,
            fontFamily: `${fontBody}, sans-serif`,
            background: 'transparent',
            animations: { easing: 'easeinout', speed: 500 }
        },
        series: [pourcentage],
        labels: ['Eau'],
        colors: [bleuEau],
        plotOptions: {
            radialBar: {
                startAngle: 0,
                endAngle: 360,
                hollow: { size: '65%' },
                track: {
                    background: border,
                    strokeWidth: '100%'
                },
                dataLabels: {
                    name: {
                        show: true,
                        fontSize: '13px',
                        color: inkSoft,
                        offsetY: -8
                    },
                    value: {
                        fontSize: '28px',
                        fontWeight: 600,
                        color: ink,
                        offsetY: 4,
                        formatter: (v) => `${v}%`
                    }
                }
            }
        },
        stroke: { lineCap: 'round' },

        tooltip: {
            custom: function () {
                const contenu = `
                    <div style="font-weight:600; color:${ink}; margin-bottom:4px;">
                        Eau
                    </div>
                    <div style="font-size:0.85rem; color:${inkMid};">
                        ${eau} g
                    </div>
                `;
                return boiteTooltip(fontBody, border, contenu, true);
            }
        }
    };

    const chart = new ApexCharts(emplacement, options);
    chart.render();

    // Ajout du texte "450 / 620 g" sous le pourcentage, en overlay HTML
    const sousTexte = document.createElement('div');
    sousTexte.textContent = `${eau} / ${poidsTotal} g`;
    sousTexte.style.cssText = `
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, 28px);
        font-size:13px;
        font-weight:400;
        color:${inkMid};
        font-family:${fontBody}, sans-serif;
        pointer-events:none;
    `;
    emplacement.style.position = 'relative';
    emplacement.appendChild(sousTexte);
}
document.addEventListener('DOMContentLoaded', initGraphiqueEau);
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