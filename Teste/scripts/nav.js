document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.nav-links');
    const main = document.querySelector('main');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navLinks.classList.toggle('active');
        main.style.overflow = navLinks.classList.contains('active') ? 'hidden' : 'auto';
    });

    // Modificar o comportamento dos links da navbar
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            
            // Se for um link interno (começa com #), use smoothScroll
            if (href.startsWith('#')) {
                e.preventDefault();
                smoothScroll(href, 1000);
            }
            // Para links externos, deixe o comportamento padrão
            // Não é necessário fazer nada aqui, o navegador lidará com a navegação

            // Fechar o menu hamburguer se estiver aberto
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
            main.style.overflow = 'auto';
        });
    });
});

// Função smoothScroll (mantenha a mesma que está no seu arquivo main.js)
function smoothScroll(target, duration) {
    var targetElement = document.querySelector(target);
    var targetPosition = targetElement.getBoundingClientRect().top;
    var startPosition = window.pageYOffset;
    var startTime = null;

    function animation(currentTime) {
        if (startTime === null) startTime = currentTime;
        var timeElapsed = currentTime - startTime;
        var run = ease(timeElapsed, startPosition, targetPosition, duration);
        window.scrollTo(0, run);
        if (timeElapsed < duration) requestAnimationFrame(animation);
    }

    function ease(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t + b;
        t--;
        return -c / 2 * (t * (t - 2) - 1) + b;
    }

    requestAnimationFrame(animation);
}
