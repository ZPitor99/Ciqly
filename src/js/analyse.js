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
import hljs from 'highlight.js/lib/core';
import pgsql from 'highlight.js/lib/languages/pgsql';
hljs.registerLanguage('pgsql', pgsql);
import 'highlight.js/styles/atom-one-dark.min.css';
//import 'highlight.js/styles/vs2015.css';
//import 'highlight.js/styles/base16/danqing.min.css';

window.onload = init
function init() {
    burger()

    const id1 = "req1";
    const req_sql1 = `-- Skyline : maximiser teneur_valeur et maximiser code_confiance
    SELECT
        reff.const_nom_fr,
        trv.alim_code,
        alm.alim_nom_fr,
        trv.teneur_valeur,
        trv.code_confiance
    FROM
        (
            SELECT
                C1.alim_code,
                C1.const_code,
                C1.teneur_valeur,
                C1.code_confiance
            FROM
                ciqly_data.composition C1
            WHERE
                C1.code_confiance IS NOT NULL
              AND NOT EXISTS (
                SELECT
                    1
                FROM
                    ciqly_data.composition C2
                WHERE
                    C2.const_code = C1.const_code -- même constituant
                  AND C2.teneur_valeur >= C1.teneur_valeur -- teneur meilleur ou égal
                  AND C2.code_confiance <= C1.code_confiance -- indice_confiance meilleur ou égal
                  AND (
                    C2.teneur_valeur > C1.teneur_valeur
                        OR C2.code_confiance < C1.code_confiance
                    ) -- et un des deux surpasse
            )
        ) trv
            INNER JOIN ciqly_data.constituants reff ON reff.const_code = trv.const_code
            INNER JOIN ciqly_data.aliments alm ON alm.alim_code = trv.alim_code
    ORDER BY
        reff.const_nom_fr,
        trv.alim_code,
        trv.code_confiance DESC;`;

    sql_bloc_code(id1, req_sql1);
    hljs.highlightAll();
}
function sql_bloc_code(identifiant, req_sql){
    const req = document.getElementById(identifiant);
    const pre = document.createElement("pre");
    const cde = document.createElement("code");

    cde.className = "language-pgsql";
    cde.textContent = req_sql;

    pre.appendChild(cde);
    req.appendChild(pre);
}