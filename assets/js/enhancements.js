/* ══════════════════════════════════════════════
   YENEPOYA LIBRARIES — UX Enhancements
   enhancements.js  | v1.0  | April 2026
   Modules: ChatbotHandler, ImageModal, EventAccordion
══════════════════════════════════════════════ */

(function () {
  'use strict';

  /* ─────────────────────────────────────────────
     1. ChatbotHandler — Close on Outside Click
     ───────────────────────────────────────────── */
  const ChatbotHandler = {
    init() {
      const chatWindow = document.getElementById('chatWindow');
      const chatFab = document.querySelector('.chat-fab');
      if (!chatWindow || !chatFab) return;

      // Close on click outside
      document.addEventListener('click', (e) => {
        if (!chatWindow.classList.contains('open')) return;

        const isInsideChat = chatWindow.contains(e.target);
        const isToggleBtn = chatFab.contains(e.target);

        if (!isInsideChat && !isToggleBtn) {
          chatWindow.classList.remove('open');
        }
      });

      // Close on ESC key
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && chatWindow.classList.contains('open')) {
          chatWindow.classList.remove('open');
        }
      });
    }
  };


  /* ─────────────────────────────────────────────
     2. ImageModal — Poster Click → Popup Viewer
     ───────────────────────────────────────────── */
  const ImageModal = {
    overlay: null,
    img: null,
    closeBtn: null,

    init() {
      this._createModal();
      this._bindAll();
    },

    _createModal() {
      // Avoid duplicates
      if (document.getElementById('imageModalOverlay')) {
        this.overlay = document.getElementById('imageModalOverlay');
        this.img = this.overlay.querySelector('.image-modal__img');
        this.closeBtn = this.overlay.querySelector('.image-modal__close');
        return;
      }

      this.overlay = document.createElement('div');
      this.overlay.className = 'image-modal__overlay';
      this.overlay.id = 'imageModalOverlay';
      this.overlay.innerHTML = `
        <button class="image-modal__close" aria-label="Close image viewer">&times;</button>
        <img class="image-modal__img" src="" alt="Event poster preview">
      `;
      document.body.appendChild(this.overlay);

      this.img = this.overlay.querySelector('.image-modal__img');
      this.closeBtn = this.overlay.querySelector('.image-modal__close');
    },

    _bindAll() {
      // Bind clickable posters
      document.querySelectorAll('.event-photos img, .event-card__poster img').forEach(img => {
        img.style.cursor = 'pointer';
        img.addEventListener('click', (e) => {
          e.stopPropagation();
          this.open(img.src, img.alt);
        });
      });

      // Close on overlay click (outside image)
      this.overlay.addEventListener('click', (e) => {
        if (e.target === this.overlay) this.close();
      });

      // Close button
      this.closeBtn.addEventListener('click', () => this.close());

      // Close on ESC
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && this.overlay.classList.contains('open')) {
          this.close();
        }
      });
    },

    open(src, alt) {
      this.img.src = src;
      this.img.alt = alt || 'Event poster';
      this.overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    },

    close() {
      this.overlay.classList.remove('open');
      document.body.style.overflow = '';
    }
  };


  /* ─────────────────────────────────────────────
     3. EventAccordion — Expand/Collapse All Events
     ───────────────────────────────────────────── */
  const EventAccordion = {
    init() {
      // Convert dynamic event-list-items into accordion format
      this._convertDynamicEvents();

      // One-at-a-time behavior for all styled-accordion groups
      document.querySelectorAll('.styled-accordion').forEach(accordion => {
        const details = accordion.querySelectorAll('details');
        details.forEach(detail => {
          detail.addEventListener('toggle', () => {
            if (detail.open) {
              // Close others in the same group
              details.forEach(other => {
                if (other !== detail && other.open) {
                  other.removeAttribute('open');
                }
              });
            }
          });
        });
      });
    },

    _convertDynamicEvents() {
      // Find dynamic event containers that need conversion
      const dynamicContainers = document.querySelectorAll('.events-grid--dynamic');
      dynamicContainers.forEach(container => {
        const items = container.querySelectorAll('.event-accordion-item');
        items.forEach(item => {
          const details = item.querySelector('details');
          if (details) {
            // Already in accordion format from PHP, just need toggle behavior
            details.addEventListener('toggle', () => {
              if (details.open) {
                // Close others
                container.querySelectorAll('details').forEach(other => {
                  if (other !== details && other.open) {
                    other.removeAttribute('open');
                  }
                });
              }
            });
          }
        });
      });
    }
  };


  /* ─────────────────────────────────────────────
     4. HomepageEventCards — Image hover + modal
     ───────────────────────────────────────────── */
  const HomepageEventCards = {
    init() {
      // Bind poster overlays on homepage event cards
      document.querySelectorAll('.event-card__poster').forEach(poster => {
        poster.addEventListener('click', (e) => {
          e.preventDefault();
          e.stopPropagation();
          const img = poster.querySelector('img');
          if (img && img.src) {
            ImageModal.open(img.src, img.alt);
          }
        });
      });
    }
  };


  /* ─── Init on DOM Ready ─────────────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    ChatbotHandler.init();
    ImageModal.init();
    EventAccordion.init();
    HomepageEventCards.init();
  });

})();
