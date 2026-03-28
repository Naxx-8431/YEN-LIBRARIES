/* ══════════════════════════════════════════════
   YENEPOYA LIBRARIES — Main Controller
   main.js  | v1.0  | March 2026
══════════════════════════════════════════════ */

(function () {
  'use strict';

  /* ── Active Nav Link ─────────────────────── */
  function setActiveNav() {
    const page = location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.nav__link').forEach(a => {
      const href = a.getAttribute('href');
      if (href === page || (page === '' && href === 'index.html')) {
        a.classList.add('active');
      }
    });
  }

  /* ── Mobile Nav Burger ───────────────────── */
  function initBurger() {
    const burger = document.getElementById('burger');
    const mobileNav = document.getElementById('mobileNav');
    if (!burger || !mobileNav) return;
    burger.addEventListener('click', () => {
      burger.classList.toggle('open');
      mobileNav.classList.toggle('open');
    });
    // Close on link click
    mobileNav.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        burger.classList.remove('open');
        mobileNav.classList.remove('open');
      });
    });
  }

  /* ── Hero Carousel ───────────────────────── */
  function initHero() {
    const track  = document.querySelector('.hero__track');
    const slides = document.querySelectorAll('.hero__slide');
    const dots   = document.querySelectorAll('.hero__dot');
    const prev   = document.querySelector('.hero__btn--prev');
    const next   = document.querySelector('.hero__btn--next');
    if (!track || slides.length === 0) return;

    let current = 0;
    let timer;

    function go(idx) {
      slides[current].classList.remove('active');
      dots[current]?.classList.remove('active');
      current = (idx + slides.length) % slides.length;
      track.style.transform = `translateX(-${current * 100}%)`;
      dots[current]?.classList.add('active');
    }

    function autoplay() {
      timer = setInterval(() => go(current + 1), 5000);
    }

    function resetTimer() {
      clearInterval(timer);
      autoplay();
    }

    if (dots.length) dots[0].classList.add('active');
    autoplay();

    prev?.addEventListener('click', () => { go(current - 1); resetTimer(); });
    next?.addEventListener('click', () => { go(current + 1); resetTimer(); });
    dots.forEach((d, i) => d.addEventListener('click', () => { go(i); resetTimer(); }));

    // Pause on hover
    track.closest('.hero')?.addEventListener('mouseenter', () => clearInterval(timer));
    track.closest('.hero')?.addEventListener('mouseleave', autoplay);

    // Touch swipe
    let startX = 0;
    track.addEventListener('touchstart', e => { startX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', e => {
      const dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 50) { dx < 0 ? go(current + 1) : go(current - 1); resetTimer(); }
    });
  }

  /* ── Enquiry Sidebar ─────────────────────── */
  function initEnquiry() {
    const sidebar = document.getElementById('enquirySidebar');
    const tab     = document.getElementById('enquiryTab');
    if (!sidebar || !tab) return;
    tab.addEventListener('click', () => sidebar.classList.toggle('open'));
  }

  /* ── Sidebar Enquiry Form ────────────────── */
  function initEnquiryForm() {
    const form = document.getElementById('enquiryForm');
    if (!form) return;
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const data = new FormData(form);
      try {
        await fetch('https://library.yenepoya.edu.in/save_enquire.php', {
          method: 'POST', body: data, mode: 'no-cors'
        });
      } catch (_) {}
      form.reset();
      const btn = form.querySelector('.enquiry-submit');
      const orig = btn.textContent;
      btn.textContent = '✓ Sent!';
      setTimeout(() => { btn.textContent = orig; }, 2500);
    });
  }

  /* ── Back To Top ─────────────────────────── */
  function initBackTop() {
    const btn = document.getElementById('backTop');
    if (!btn) return;
    window.addEventListener('scroll', () => {
      btn.classList.toggle('visible', window.scrollY > 300);
    });
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  }

  /* ── Sticky Header Shadow ────────────────── */
  function initHeaderScroll() {
    const header = document.querySelector('.header');
    if (!header) return;
    window.addEventListener('scroll', () => {
      header.style.boxShadow = window.scrollY > 10
        ? '0 4px 20px rgba(40,59,106,.15)'
        : '0 2px 8px rgba(40,59,106,.10)';
    });
  }

  /* ── Page Inner Sidebar (for sub-pages) ──── */
  function initPageSidebar() {
    const links = document.querySelectorAll('.page-sidebar__link');
    if (!links.length) return;
    const sections = document.querySelectorAll('.page-section');
    
    // Default: Show ONLY the active section
    function showSection(hash) {
      if (!hash) hash = '#default-view';
      let found = false;
      
      // Highlight correct link
      links.forEach(l => {
        const isActive = l.getAttribute('href') === hash;
        l.classList.toggle('active', isActive);
      });

      // Show correct section
      sections.forEach(s => {
        if (`#${s.id}` === hash) {
          s.style.display = 'block';
          found = true;
        } else {
          s.style.display = 'none';
        }
      });
      
      // Fallback
      if (!found && sections.length) {
        // If hash wasn't found, default to the first section (or default-view if we want)
        const defaultSec = document.getElementById('default-view') || sections[0];
        if (defaultSec) {
            defaultSec.style.display = 'block';
            const link = document.querySelector(`.page-sidebar__link[href="#${defaultSec.id}"]`);
            if (link) link.classList.add('active');
        }
      }
    }

    // Initialize based on URL hash
    showSection(window.location.hash);

    // On link click
    links.forEach(l => l.addEventListener('click', e => {
      e.preventDefault();
      const hash = l.getAttribute('href');
      
      try {
        history.pushState(null, '', hash);
      } catch (err) {
        // Ignored. pushState throws a DOMException on file:// URLs locally
      }
      
      showSection(hash);
      
      // Optionally scroll to top of the inner layout or keep it sticky
      const innerLayout = document.querySelector('.inner-layout');
      if (innerLayout) {
        const topOfLayout = innerLayout.getBoundingClientRect().top + window.scrollY;
        // Only scroll if we are below the sticky header + some buffer to avoid jumping down
        if (window.scrollY > topOfLayout - 100) {
          window.scrollTo({ top: topOfLayout - 100, behavior: 'smooth' });
        }
      }
    }));
  }

  /* ── DB Logos drag-scroll ────────────────── */
  function initDbScroll() {
    const el = document.querySelector('.db-logos');
    if (!el) return;
    let isDown = false, startX, scrollLeft;
    el.addEventListener('mousedown', e => {
      isDown = true; startX = e.pageX - el.offsetLeft; scrollLeft = el.scrollLeft;
    });
    el.addEventListener('mouseleave', () => isDown = false);
    el.addEventListener('mouseup', () => isDown = false);
    el.addEventListener('mousemove', e => {
      if (!isDown) return;
      e.preventDefault();
      el.scrollLeft = scrollLeft - (e.pageX - el.offsetLeft - startX);
    });
  }

  /* ── Init ────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    setActiveNav();
    initBurger();
    initHero();
    initEnquiry();
    initEnquiryForm();
    initBackTop();
    initHeaderScroll();
    initPageSidebar();
    initDbScroll();
  });

})();
