const navToggle = document.querySelector('[data-nav-toggle]');
const drawer = document.querySelector('[data-nav-drawer]');

const setDrawerOpen = (open) => {
    drawer?.classList.toggle('is-open', open);
    navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    navToggle.setAttribute('aria-label', open ? '關閉選單' : '開啟選單');
};

navToggle?.addEventListener('click', () => {
    setDrawerOpen(navToggle.getAttribute('aria-expanded') !== 'true');
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && navToggle?.getAttribute('aria-expanded') === 'true') {
        setDrawerOpen(false);
        navToggle.focus();
    }
});

drawer?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setDrawerOpen(false));
});

document.addEventListener('click', (event) => {
    if (navToggle?.getAttribute('aria-expanded') === 'true' && !event.target.closest('.site-header')) {
        setDrawerOpen(false);
    }
});

window.matchMedia('(min-width: 901px)').addEventListener('change', (event) => {
    if (event.matches && navToggle) {
        setDrawerOpen(false);
    }
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

// Keep topic changes manual so visitors can read at their own pace.
document.querySelectorAll('[data-hero]').forEach((hero) => {
    const steps = hero.querySelectorAll('[data-hero-step]');
    const panels = hero.querySelectorAll('[data-hero-panel]');
    const images = hero.querySelectorAll('[data-hero-image]');
    hero.querySelector('[data-hero-controls]').hidden = false;

    steps.forEach((step) => {
        step.addEventListener('click', () => {
            const index = step.dataset.heroStep;
            steps.forEach((button) => button.setAttribute('aria-pressed', String(button === step)));
            panels.forEach((panel) => { panel.hidden = panel.dataset.heroPanel !== index; });
            images.forEach((image) => { image.hidden = image.dataset.heroImage !== index; });
        });
    });
});
