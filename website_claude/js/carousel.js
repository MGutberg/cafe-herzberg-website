/**
 * Café Herzberg — Hero Carousel
 * Auto-Play, Fade-Übergang, Dots, Pause bei Hover
 */
(function () {
  'use strict';

  const AUTOPLAY_INTERVAL = 5000; // ms
  const TRANSITION_DURATION = 900; // ms — match CSS

  let currentIndex = 0;
  let autoPlayTimer = null;
  let isTransitioning = false;

  const track   = document.querySelector('.carousel-track');
  const slides  = document.querySelectorAll('.carousel-slide');
  const dots    = document.querySelectorAll('.carousel-dot');
  const progress = document.querySelector('.carousel-progress');

  if (!track || slides.length === 0) return;

  /* ---------- Core ---------- */

  function goTo(index, skipTransition = false) {
    if (isTransitioning && !skipTransition) return;
    if (index === currentIndex && !skipTransition) return;

    isTransitioning = true;

    // Deactivate current
    slides[currentIndex].classList.remove('active');
    if (dots[currentIndex]) dots[currentIndex].classList.remove('active');

    // Wrap index
    currentIndex = ((index % slides.length) + slides.length) % slides.length;

    // Activate new
    slides[currentIndex].classList.add('active');
    if (dots[currentIndex]) dots[currentIndex].classList.add('active');

    // Reset progress bar
    if (progress) {
      progress.style.transition = 'none';
      progress.style.width = '0%';
      // Force reflow
      void progress.offsetWidth;
      progress.style.transition = `width ${AUTOPLAY_INTERVAL}ms linear`;
      progress.style.width = '100%';
    }

    setTimeout(() => { isTransitioning = false; }, TRANSITION_DURATION);
  }

  function next() { goTo(currentIndex + 1); }
  function prev() { goTo(currentIndex - 1); }

  /* ---------- Auto-Play ---------- */

  function startAutoPlay() {
    stopAutoPlay();
    autoPlayTimer = setInterval(next, AUTOPLAY_INTERVAL);

    if (progress) {
      progress.style.transition = `width ${AUTOPLAY_INTERVAL}ms linear`;
      progress.style.width = '100%';
    }
  }

  function stopAutoPlay() {
    clearInterval(autoPlayTimer);
    autoPlayTimer = null;

    if (progress) {
      progress.style.transition = 'none';
      progress.style.width = '0%';
    }
  }

  /* ---------- Dots ---------- */

  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () {
      goTo(i);
      stopAutoPlay();
      startAutoPlay();
    });
  });

  /* ---------- Pause on hover ---------- */

  track.addEventListener('mouseenter', stopAutoPlay);
  track.addEventListener('mouseleave', startAutoPlay);

  /* ---------- Touch / Swipe ---------- */

  let touchStartX = 0;
  let touchStartY = 0;

  track.addEventListener('touchstart', function (e) {
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
  }, { passive: true });

  track.addEventListener('touchend', function (e) {
    const dx = e.changedTouches[0].clientX - touchStartX;
    const dy = e.changedTouches[0].clientY - touchStartY;

    // Only horizontal swipe
    if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 40) {
      if (dx < 0) next(); else prev();
      stopAutoPlay();
      startAutoPlay();
    }
  }, { passive: true });

  /* ---------- Keyboard ---------- */

  document.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowLeft')  { prev(); stopAutoPlay(); startAutoPlay(); }
    if (e.key === 'ArrowRight') { next(); stopAutoPlay(); startAutoPlay(); }
  });

  /* ---------- Init ---------- */

  goTo(0, true);
  startAutoPlay();

})();
