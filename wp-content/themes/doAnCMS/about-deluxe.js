// about-deluxe.js
(function () {
    // Simple reveal on scroll using IntersectionObserver
    const reveals = document.querySelectorAll('.reveal');
    const obsOptions = { root: null, rootMargin: '0px', threshold: 0.15 };

    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                // optional: unobserve to avoid repeated work
                observer.unobserve(entry.target);
            }
        });
    }, obsOptions);

    reveals.forEach(r => revealObserver.observe(r));

    // Simple parallax for header on desktop (subtle)
    const hero = document.querySelector('[data-parallax]');
    if (hero && window.innerWidth > 900) {
        window.addEventListener('scroll', () => {
            const sc = window.scrollY;
            // adjust multiplier for effect strength
            const y = Math.round(sc * 0.25);
            hero.style.backgroundPosition = `center calc(50% + ${y}px)`;
        }, { passive: true });
    }

})();
