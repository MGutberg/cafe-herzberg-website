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
/**
 * Café Herzberg — Cookie Banner (DSGVO)
 * Speichert Zustimmung in localStorage
 */
(function () {
  'use strict';

  const STORAGE_KEY = 'herzberg_cookie_consent';

  const banner      = document.getElementById('cookie-banner');
  const btnAccept   = document.getElementById('cookie-accept');
  const btnMinimal  = document.getElementById('cookie-minimal');

  if (!banner) return;

  function hideBanner() {
    banner.classList.remove('visible');
  }

  function showBanner() {
    // Small delay so page can paint first
    setTimeout(function () {
      banner.classList.add('visible');
    }, 800);
  }

  function accept(type) {
    localStorage.setItem(STORAGE_KEY, type);
    hideBanner();
  }

  // Check existing consent
  const existing = localStorage.getItem(STORAGE_KEY);

  if (!existing) {
    showBanner();
  }

  if (btnAccept) {
    btnAccept.addEventListener('click', function () { accept('all'); });
  }

  if (btnMinimal) {
    btnMinimal.addEventListener('click', function () { accept('minimal'); });
  }

})();
/**
 * Café Herzberg — Navigation
 * Sticky-Header, Mobile-Menu, Smooth-Scroll, Active-Links
 */
(function () {
  'use strict';

  const header      = document.querySelector('.site-header');
  const hamburger   = document.querySelector('.nav-hamburger');
  const mobileMenu  = document.querySelector('.nav-mobile');
  const mobileClose = document.querySelector('.nav-mobile-close');
  const mobileLinks = document.querySelectorAll('.nav-mobile a');
  const navLinks    = document.querySelectorAll('.nav-links a[href^="#"]');

  /* ---------- Sticky Header ---------- */

  function updateHeader() {
    if (!header) return;
    if (window.scrollY > 60) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();

  /* ---------- Mobile Menu ---------- */

  function openMenu() {
    if (!mobileMenu || !hamburger) return;
    mobileMenu.classList.add('open');
    hamburger.classList.add('open');
    document.body.style.overflow = 'hidden';
    mobileMenu.setAttribute('aria-hidden', 'false');
  }

  function closeMenu() {
    if (!mobileMenu || !hamburger) return;
    mobileMenu.classList.remove('open');
    hamburger.classList.remove('open');
    document.body.style.overflow = '';
    mobileMenu.setAttribute('aria-hidden', 'true');
  }

  if (hamburger) hamburger.addEventListener('click', openMenu);
  if (mobileClose) mobileClose.addEventListener('click', closeMenu);

  mobileLinks.forEach(function (link) {
    link.addEventListener('click', closeMenu);
  });

  // Close on ESC
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeMenu();
  });

  /* ---------- Active Nav Link on Scroll ---------- */

  const sections = document.querySelectorAll('section[id], div[id]');

  function updateActiveLink() {
    let current = '';
    sections.forEach(function (section) {
      const sectionTop = section.offsetTop - 100;
      if (window.scrollY >= sectionTop) {
        current = section.id;
      }
    });

    navLinks.forEach(function (link) {
      link.classList.remove('active');
      if (link.getAttribute('href') === '#' + current) {
        link.classList.add('active');
      }
    });
  }

  window.addEventListener('scroll', updateActiveLink, { passive: true });

  /* ---------- Menu Tabs ---------- */

  const tabs   = document.querySelectorAll('.menu-tab');
  const panels = document.querySelectorAll('.menu-panel');

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      const target = this.dataset.tab;

      tabs.forEach(function (t) { t.classList.remove('active'); });
      panels.forEach(function (p) { p.classList.remove('active'); });

      this.classList.add('active');
      const panel = document.getElementById('menu-' + target);
      if (panel) panel.classList.add('active');
    });
  });

  /* ---------- Gallery Lightbox ---------- */

  const galleryItems = document.querySelectorAll('.gallery-item');
  const lightbox     = document.getElementById('lightbox');
  const lightboxImg  = document.getElementById('lightbox-img');
  const lightboxClose = document.getElementById('lightbox-close');

  function openLightbox(src, alt) {
    if (!lightbox || !lightboxImg) return;
    lightboxImg.src = src;
    lightboxImg.alt = alt || '';
    lightbox.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    if (!lightbox) return;
    lightbox.classList.remove('open');
    document.body.style.overflow = '';
  }

  galleryItems.forEach(function (item) {
    item.addEventListener('click', function () {
      const img = this.querySelector('img');
      if (img) openLightbox(img.src, img.alt);
    });

    // Keyboard support
    item.setAttribute('tabindex', '0');
    item.setAttribute('role', 'button');
    item.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        const img = this.querySelector('img');
        if (img) openLightbox(img.src, img.alt);
      }
    });
  });

  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);

  if (lightbox) {
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) closeLightbox();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && lightbox && lightbox.classList.contains('open')) {
      closeLightbox();
    }
  });

})();
