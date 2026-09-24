const sidebar = document.querySelector('[data-console-sidebar]');
const toggle = document.querySelector('[data-console-toggle]');

toggle?.addEventListener('click', () => {
    sidebar?.classList.toggle('is-open');
});

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

const linkList = document.querySelector('[data-link-list]');
const addLink = document.querySelector('[data-add-link]');

addLink?.addEventListener('click', () => {
    const rows = linkList.querySelectorAll('.console-link-row');
    const index = rows.length;
    const row = document.createElement('div');
    row.className = 'console-link-row';
    row.innerHTML = `
        <input type="url" name="links[${index}][url]" placeholder="https://">
        <input type="text" name="links[${index}][label]" placeholder="顯示文字">
        <button type="button" data-remove-link>移除</button>
    `;
    addLink.before(row);
});

linkList?.addEventListener('click', (event) => {
    const button = event.target.closest('[data-remove-link]');

    if (!button) {
        return;
    }

    button.closest('.console-link-row')?.remove();
});
