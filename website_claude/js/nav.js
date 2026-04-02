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
