export function burger(){
    /*
    Fonction pour le menu de navigation hamburger.
    */

    const hamburger = document.querySelector('.nav__hamburger');
    const navLinks = document.querySelector('.nav__links');
    const navCta = document.querySelector('.nav__cta');

    hamburger.addEventListener('click', () => {
        const isOpen = hamburger.getAttribute('aria-expanded') === 'true';

        hamburger.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
        navLinks.classList.toggle('nav__links--open');
        navCta.classList.toggle('nav__cta--open');
    });
}