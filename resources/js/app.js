const navToggle = document.querySelector('[data-nav-toggle]');
const drawer = document.querySelector('[data-nav-drawer]');

navToggle?.addEventListener('click', () => {
    const open = drawer?.classList.toggle('is-open');
    navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
});

document.querySelectorAll('[data-filter]').forEach((button) => {
    button.addEventListener('click', () => {
        const filter = button.dataset.filter;

        document.querySelectorAll('[data-filter]').forEach((item) => {
            item.classList.toggle('is-active', item === button);
        });

        document.querySelectorAll('[data-project]').forEach((card) => {
            card.classList.toggle('is-hidden', filter !== 'all' && card.dataset.project !== filter);
        });
    });
});
