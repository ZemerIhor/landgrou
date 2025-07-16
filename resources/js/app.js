import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

function initApp () {
    window.Swiper = Swiper;
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
}

document.addEventListener("DOMContentLoaded", initApp);
document.addEventListener("livewire:navigated", initApp);
document.addEventListener("livewire:init", initApp);
document.addEventListener("livewire:update", initApp);


