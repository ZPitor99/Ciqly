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
        table_infoods: [
            { nom: 'Alcool (éthanol) (g/100 g)', code: 'ALC'},
            { nom: 'Cendres (g/100 g)', code: 'ASH'},
            { nom: 'Calcium (mg/100 g)', code: 'CA'},
            { nom: 'Beta-Carotène (µg/100 g)', code: 'CARTB'},
            { nom: 'Glucides (g/100 g)', code: 'CHOAVL'},
            { nom: 'Vitamine D3 (cholécalciférol) (µg/100 g)', code: 'CHOCAL'},
            { nom: 'Cholestérol (mg/100 g)', code: 'CHOL-'},
            { nom: 'Chlorure (mg/100 g)', code: 'CLD'},
            { nom: 'Cuivre (mg/100 g)', code: 'CU'},
            { nom: 'Energie, N x facteur Jones, avec fibres (kcal/100 g)', code: 'ENERC'},
            { nom: 'Energie, Règlement UE N° 1169/2011 (kJ/100 g)', code: 'ENERC'},
            { nom: 'Energie, N x facteur Jones, avec fibres (kJ/100 g)', code: 'ENERC'},
            { nom: 'Energie, Règlement UE N° 1169/2011 (kcal/100 g)', code: 'ENERC'},
            { nom: 'Vitamine D2 (ergocalciférol) (µg/100 g)', code: 'ERGCAL'},
            { nom: 'AG 10:0, caprique (g/100 g)', code: 'F10D0'},
            { nom: 'AG 12:0, laurique (g/100 g)', code: 'F12D0'},
            { nom: 'AG 14:0, myristique (g/100 g)', code: 'F14D0'},
            { nom: 'AG 16:0, palmitique (g/100 g)', code: 'F16D0'},
            { nom: 'AG 18:0, stéarique (g/100 g)', code: 'F18D0'},
            { nom: 'AG 18:1 9c (n-9), oléique (g/100 g)', code: 'F18D1CN9'},
            { nom: 'AG 18:2 9c,12c (n-6), linoléique (g/100 g)', code: 'F18D2CN6'},
            { nom: 'AG 18:3 c9,c12,c15 (n-3), alpha-linolénique (g/100 g)', code: 'F18D3N3'},
            { nom: 'AG 20:4 5c,8c,11c,14c (n-6), arachidonique (g/100 g)', code: 'F20D4N6'},
            { nom: 'AG 20:5 5c,8c,11c,14c,17c (n-3) EPA (g/100 g)', code: 'F20D5N3'},
            { nom: 'AG 22:6 4c,7c,10c,13c,16c,19c (n-3) DHA (g/100 g)', code: 'F22D6N3'},
            { nom: 'AG 4:0, butyrique (g/100 g)', code: 'F4D0'},
            { nom: 'AG 6:0, caproïque (g/100 g)', code: 'F6D0'},
            { nom: 'AG 8:0, caprylique (g/100 g)', code: 'F8D0'},
            { nom: 'AG monoinsaturés (g/100 g)', code: 'FAMS'},
            { nom: 'AG polyinsaturés (g/100 g)', code: 'FAPU'},
            { nom: 'AG saturés (g/100 g)', code: 'FASAT'},
            { nom: 'Lipides (g/100 g)', code: 'FAT'},
            { nom: 'Fer (mg/100 g)', code: 'FE'},
            { nom: 'Fibres alimentaires (g/100 g)', code: 'FIB-'},
            { nom: 'Vitamine B9 ou Folates totaux (µg/100 g)', code: 'FOL'},
            { nom: 'Acide folique (enrichissement) (µg/100 g)', code: 'FOLAC'},
            { nom: 'Vitamine B9 ou Folates totaux, équivalents folates alimentaires, DFE (µg/100 g)', code: 'FOLDFE'},
            { nom: 'Folates intrinsèques (µg/100 g)', code: 'FOLFD'},
            { nom: 'Fructose (g/100 g)', code: 'FRUS'},
            { nom: 'Galactose (g/100 g)', code: 'GALS'},
            { nom: 'Glucose (g/100 g)', code: 'GLUS'},
            { nom: 'Iode (µg/100 g)', code: 'ID'},
            { nom: 'Potassium (mg/100 g)', code: 'K'},
            { nom: 'Lactose (g/100 g)', code: 'LACS'},
            { nom: 'Maltose (g/100 g)', code: 'MALS'},
            { nom: 'Magnésium (mg/100 g)', code: 'MG'},
            { nom: 'Manganèse (mg/100 g)', code: 'MN'},
            { nom: 'Sodium (mg/100 g)', code: 'NA'},
            { nom: 'Vitamine B3 ou PP ou Niacine (mg/100 g)', code: 'NIA'},
            { nom: 'Acides organiques (g/100 g)', code: 'OA'},
            { nom: 'Phosphore (mg/100 g)', code: 'P'},
            { nom: 'Vitamine B5 ou Acide pantothénique (mg/100 g)', code: 'PANTAC'},
            { nom: 'Polyols totaux (g/100 g)', code: 'POLYL'},
            { nom: 'Protéines, N x facteur de Jones (g/100 g)', code: 'PROCNT'},
            { nom: 'Protéines, N x 6.25 (g/100 g)', code: 'PROCNT'},
            { nom: 'Activité vitaminique A, équivalents rétinol (µg/100 g)', code: 'RAE'},
            { nom: 'Rétinol (µg/100 g)', code: 'RETOL'},
            { nom: 'Vitamine B2 ou Riboflavine (mg/100 g)', code: 'RIBF'},
            { nom: 'Sélénium (µg/100 g)', code: 'SE'},
            { nom: 'Amidon (g/100 g)', code: 'STARCH'},
            { nom: 'Saccharose (g/100 g)', code: 'SUCS'},
            { nom: 'Sucres (g/100 g)', code: 'SUGAR'},
            { nom: 'Vitamine B1 ou Thiamine (mg/100 g)', code: 'THIA'},
            { nom: 'Alpha-tocophérol (vitamine E) (mg/100 g)', code: 'TOCPHA'},
            { nom: 'Vitamine B12 (µg/100 g)', code: 'VITB12'},
            { nom: 'Vitamine B6 (mg/100 g)', code: 'VITB6-'},
            { nom: 'Vitamine C (mg/100 g)', code: 'VITC'},
            { nom: 'Vitamine D (µg/100 g)', code: 'VITD-'},
            { nom: 'Vitamine E (mg/100 g)', code: 'VITE-'},
            { nom: 'Vitamine K1 (µg/100 g)', code: 'VITK1'},
            { nom: 'Vitamine K2 (µg/100 g)', code: 'VITK2'},
            { nom: 'Eau (g/100 g)', code: 'WATER'},
            { nom: 'Zinc (mg/100 g)', code: 'ZN'},
            { nom: 'Sel chlorure de sodium (g/100 g)', code: 'NULL'}]
    }))
})
Alpine.start()

window.onload = init
function init() {
    burger();
}