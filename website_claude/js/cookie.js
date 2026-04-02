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
