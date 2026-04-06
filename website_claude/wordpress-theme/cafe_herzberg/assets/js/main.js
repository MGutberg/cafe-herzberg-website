/**
 * Café Herzberg — Main JS
 * Carousel + Cookie Banner + Navigation
 */

/* ============================================================
   CAROUSEL
   ============================================================ */
(function () {
  'use strict';
  var AUTOPLAY_INTERVAL = 5000;
  var TRANSITION_DURATION = 900;
  var currentIndex = 0;
  var autoPlayTimer = null;
  var isTransitioning = false;

  var track   = document.querySelector('.carousel-track');
  var slides  = document.querySelectorAll('.carousel-slide');
  var dots    = document.querySelectorAll('.carousel-dot');
  var progress = document.querySelector('.carousel-progress');

  if (!track || slides.length === 0) return;

  function goTo(index, skipTransition) {
    if (isTransitioning && !skipTransition) return;
    if (index === currentIndex && !skipTransition) return;
    isTransitioning = true;
    slides[currentIndex].classList.remove('active');
    if (dots[currentIndex]) dots[currentIndex].classList.remove('active');
    currentIndex = ((index % slides.length) + slides.length) % slides.length;
    slides[currentIndex].classList.add('active');
    if (dots[currentIndex]) dots[currentIndex].classList.add('active');
    if (progress) {
      progress.style.transition = 'none';
      progress.style.width = '0%';
      void progress.offsetWidth;
      progress.style.transition = 'width ' + AUTOPLAY_INTERVAL + 'ms linear';
      progress.style.width = '100%';
    }
    setTimeout(function () { isTransitioning = false; }, TRANSITION_DURATION);
  }

  function next() { goTo(currentIndex + 1); }
  function prev() { goTo(currentIndex - 1); }

  function startAutoPlay() {
    stopAutoPlay();
    autoPlayTimer = setInterval(next, AUTOPLAY_INTERVAL);
    if (progress) {
      progress.style.transition = 'width ' + AUTOPLAY_INTERVAL + 'ms linear';
      progress.style.width = '100%';
    }
  }

  function stopAutoPlay() {
    clearInterval(autoPlayTimer);
    autoPlayTimer = null;
    if (progress) { progress.style.transition = 'none'; progress.style.width = '0%'; }
  }

  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () { goTo(i); stopAutoPlay(); startAutoPlay(); });
  });

  track.addEventListener('mouseenter', stopAutoPlay);
  track.addEventListener('mouseleave', startAutoPlay);

  var touchStartX = 0, touchStartY = 0;
  track.addEventListener('touchstart', function (e) {
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
  }, { passive: true });
  track.addEventListener('touchend', function (e) {
    var dx = e.changedTouches[0].clientX - touchStartX;
    var dy = e.changedTouches[0].clientY - touchStartY;
    if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 40) {
      if (dx < 0) next(); else prev();
      stopAutoPlay(); startAutoPlay();
    }
  }, { passive: true });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowLeft')  { prev(); stopAutoPlay(); startAutoPlay(); }
    if (e.key === 'ArrowRight') { next(); stopAutoPlay(); startAutoPlay(); }
  });

  goTo(0, true);
  startAutoPlay();
})();

/* ============================================================
   COOKIE BANNER
   ============================================================ */
(function () {
  'use strict';
  var STORAGE_KEY = 'herzberg_cookie_consent';
  var banner     = document.getElementById('cookie-banner');
  var btnAccept  = document.getElementById('cookie-accept');
  var btnMinimal = document.getElementById('cookie-minimal');

  if (!banner) return;

  function hideBanner() { banner.classList.remove('visible'); }
  function showBanner() { setTimeout(function () { banner.classList.add('visible'); }, 800); }
  function accept(type) { localStorage.setItem(STORAGE_KEY, type); hideBanner(); }

  if (!localStorage.getItem(STORAGE_KEY)) showBanner();
  if (btnAccept)  btnAccept.addEventListener('click',  function () { accept('all'); });
  if (btnMinimal) btnMinimal.addEventListener('click', function () { accept('minimal'); });
})();

/* ============================================================
   NAVIGATION
   ============================================================ */
(function () {
  'use strict';
  var header      = document.querySelector('.site-header');
  var hamburger   = document.querySelector('.nav-hamburger');
  var mobileMenu  = document.querySelector('.nav-mobile');
  var mobileClose = document.querySelector('.nav-mobile-close');
  var mobileLinks = document.querySelectorAll('.nav-mobile a');
  var navLinks    = document.querySelectorAll('.nav-links a[href*="#"]');

  function updateHeader() {
    if (!header) return;
    if (window.scrollY > 60) header.classList.add('scrolled');
    else header.classList.remove('scrolled');
  }
  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();

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
  mobileLinks.forEach(function (l) { l.addEventListener('click', closeMenu); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });

  // Menu Tabs
  var tabs   = document.querySelectorAll('.menu-tab');
  var panels = document.querySelectorAll('.menu-panel');
  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var target = this.dataset.tab;
      tabs.forEach(function (t) { t.classList.remove('active'); });
      panels.forEach(function (p) { p.classList.remove('active'); });
      this.classList.add('active');
      var panel = document.getElementById('menu-' + target);
      if (panel) panel.classList.add('active');
    });
  });

  // Gallery Lightbox
  var galleryItems  = document.querySelectorAll('.gallery-item');
  var lightbox      = document.getElementById('lightbox');
  var lightboxImg   = document.getElementById('lightbox-img');
  var lightboxClose = document.getElementById('lightbox-close');

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
      var img = this.querySelector('img');
      if (img) openLightbox(img.src, img.alt);
    });
    item.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        var img = this.querySelector('img');
        if (img) openLightbox(img.src, img.alt);
      }
    });
  });

  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
  if (lightbox) {
    lightbox.addEventListener('click', function (e) { if (e.target === lightbox) closeLightbox(); });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && lightbox && lightbox.classList.contains('open')) closeLightbox();
  });
})();
