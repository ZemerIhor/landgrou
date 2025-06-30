document.querySelectorAll('[data-toggle]').forEach(button => {
    button.addEventListener('click', () => {
        const targetId = button.getAttribute('data-toggle');
        const answer = document.getElementById(targetId);
        const isExpanded = button.getAttribute('aria-expanded') === 'true';

        answer.classList.toggle('max-h-0');
        answer.classList.toggle('max-h-96');
        button.setAttribute('aria-expanded', !isExpanded);
    });
});
