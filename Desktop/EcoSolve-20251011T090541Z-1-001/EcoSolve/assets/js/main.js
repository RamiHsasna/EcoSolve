/**
 * Template Name: Landify
 * Template URL: https://bootstrapmade.com/landify-bootstrap-landing-page-template/
 * Updated: Aug 04 2025 with Bootstrap v5.3.7
 * Author: BootstrapMade.com
 * License: https://bootstrapmade.com/license/
 */

(function () {
  "use strict";

  /**
   * Apply .scrolled class to the body as the page is scrolled down
   */
  function toggleScrolled() {
    const selectBody = document.querySelector("body");
    const selectHeader = document.querySelector("#header");
    if (
      !selectHeader.classList.contains("scroll-up-sticky") &&
      !selectHeader.classList.contains("sticky-top") &&
      !selectHeader.classList.contains("fixed-top")
    )
      return;
    window.scrollY > 100
      ? selectBody.classList.add("scrolled")
      : selectBody.classList.remove("scrolled");
  }

  document.addEventListener("scroll", toggleScrolled);
  window.addEventListener("load", toggleScrolled);

  /**
   * Mobile nav toggle
   */
  const mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");

  function mobileNavToogle() {
    document.querySelector("body").classList.toggle("mobile-nav-active");
    mobileNavToggleBtn.classList.toggle("bi-list");
    mobileNavToggleBtn.classList.toggle("bi-x");
  }
  if (mobileNavToggleBtn) {
    mobileNavToggleBtn.addEventListener("click", mobileNavToogle);
  }

  /**
   * Hide mobile nav on same-page/hash links
   */
  document.querySelectorAll("#navmenu a").forEach((navmenu) => {
    navmenu.addEventListener("click", () => {
      if (document.querySelector(".mobile-nav-active")) {
        mobileNavToogle();
      }
    });
  });

  /**
   * Toggle mobile nav dropdowns
   */
  document.querySelectorAll(".navmenu .toggle-dropdown").forEach((navmenu) => {
    navmenu.addEventListener("click", function (e) {
      e.preventDefault();
      this.parentNode.classList.toggle("active");
      this.parentNode.nextElementSibling.classList.toggle("dropdown-active");
      e.stopImmediatePropagation();
    });
  });

  /**
   * Scroll top button
   */
  let scrollTop = document.querySelector(".scroll-top");

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100
        ? scrollTop.classList.add("active")
        : scrollTop.classList.remove("active");
    }
  }
  scrollTop.addEventListener("click", (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });

  window.addEventListener("load", toggleScrollTop);
  document.addEventListener("scroll", toggleScrollTop);

  /**
   * Animation on scroll function and init
   */
  function aosInit() {
    AOS.init({
      duration: 600,
      easing: "ease-in-out",
      once: true,
      mirror: false,
    });
  }
  window.addEventListener("load", aosInit);

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: ".glightbox",
  });

  /**
   * Init swiper sliders
   */
  function initSwiper() {
    document.querySelectorAll(".init-swiper").forEach(function (swiperElement) {
      let config = JSON.parse(
        swiperElement.querySelector(".swiper-config").innerHTML.trim()
      );

      if (swiperElement.classList.contains("swiper-tab")) {
        initSwiperWithCustomPagination(swiperElement, config);
      } else {
        new Swiper(swiperElement, config);
      }
    });
  }

  window.addEventListener("load", initSwiper);

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /*
   * Pricing Toggle
   */

  const pricingContainers = document.querySelectorAll(
    ".pricing-toggle-container"
  );

  pricingContainers.forEach(function (container) {
    const pricingSwitch = container.querySelector(
      '.pricing-toggle input[type="checkbox"]'
    );
    const monthlyText = container.querySelector(".monthly");
    const yearlyText = container.querySelector(".yearly");

    pricingSwitch.addEventListener("change", function () {
      const pricingItems = container.querySelectorAll(".pricing-item");

      if (this.checked) {
        monthlyText.classList.remove("active");
        yearlyText.classList.add("active");
        pricingItems.forEach((item) => {
          item.classList.add("yearly-active");
        });
      } else {
        monthlyText.classList.add("active");
        yearlyText.classList.remove("active");
        pricingItems.forEach((item) => {
          item.classList.remove("yearly-active");
        });
      }
    });
  });

  /**
   * Frequently Asked Questions Toggle
   */
  document
    .querySelectorAll(
      ".faq-item h3, .faq-item .faq-toggle, .faq-item .faq-header"
    )
    .forEach((faqItem) => {
      faqItem.addEventListener("click", () => {
        faqItem.parentNode.classList.toggle("faq-active");
      });
    });

  /**
   * Correct scrolling position upon page load for URLs containing hash links.
   */
  window.addEventListener("load", function (e) {
    if (window.location.hash) {
      if (document.querySelector(window.location.hash)) {
        setTimeout(() => {
          let section = document.querySelector(window.location.hash);
          let scrollMarginTop = getComputedStyle(section).scrollMarginTop;
          window.scrollTo({
            top: section.offsetTop - parseInt(scrollMarginTop),
            behavior: "smooth",
          });
        }, 100);
      }
    }
  });

  /**
   * Navmenu Scrollspy
   */
  let navmenulinks = document.querySelectorAll(".navmenu a");

  function navmenuScrollspy() {
    navmenulinks.forEach((navmenulink) => {
      if (!navmenulink.hash) return;
      let section = document.querySelector(navmenulink.hash);
      if (!section) return;
      let position = window.scrollY + 200;
      if (
        position >= section.offsetTop &&
        position <= section.offsetTop + section.offsetHeight
      ) {
        document
          .querySelectorAll(".navmenu a.active")
          .forEach((link) => link.classList.remove("active"));
        navmenulink.classList.add("active");
      } else {
        navmenulink.classList.remove("active");
      }
    });
  }
  window.addEventListener("load", navmenuScrollspy);
  document.addEventListener("scroll", navmenuScrollspy);

 /**
 * Notifications Dynamiques (Corrigé)
 */
/**
 * Notifications Dynamiques (Version Complétée et Fixée)
 */
const notificationBtn = document.querySelector('.btn-notification');
const notifBox = document.getElementById('notif-box');
const notifList = document.getElementById('notif-list');
const notifBadge = document.getElementById('notif-badge');
const notifCount = document.getElementById('notif-count');
const closeNotif = document.getElementById('close-notif');

console.log('Debug: Bouton trouvé ?', notificationBtn);
console.log('Debug: Boîte trouvée ?', notifBox);

// Fonction pour charger les notifications (fetch depuis backend)
async function loadNotifications(silent = false) {  // silent=true pour refresh sans spinner
  const userCity = localStorage.getItem('userCity') || 'Sfax';
  const userId = localStorage.getItem('userId') || 1;  // Dynamique, set après login
  console.log('Debug: Ville utilisateur:', userCity, 'ID:', userId);

  if (!notifList) {
    console.error('Erreur: notifList non trouvé');
    return;
  }

  if (!silent) {
    notifList.innerHTML = `
      <div class="loading-notif text-center py-3">
        <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
        <small class="d-block text-muted mt-1">Chargement des opportunités à ${userCity}...</small>
      </div>
    `;
  }

  try {
    const response = await fetch(`/EcoSolve/backend/get_notifications.php?city=${encodeURIComponent(userCity)}&user_id=${userId}`);
    console.log('Debug: Réponse fetch:', response.status);
    if (!response.ok) {
      throw new Error('Erreur HTTP: ' + response.status);
    }
    const notifications = await response.json();

    if (notifications.length === 0) {
      notifList.innerHTML = '<p class="text-center text-muted py-3">Aucune nouvelle opportunité dans votre zone.</p>';
      updateBadge(0);
      return;
    }

    let html = '';
    let unreadCount = 0;
    notifications.forEach(notif => {
      const isUnread = !notif.read;  // Basé sur backend
      if (isUnread) unreadCount++;
      html += `
        <a href="#opportunite-${notif.id}" onclick="markAsRead(${notif.id}); return false;" 
           class="notification-item d-flex align-items-start p-3 border-bottom ${isUnread ? 'unread' : ''}"
           style="${isUnread ? 'background-color: rgba(0,123,255,0.1);' : ''}">
          <div class="notification-icon me-3">
            <i class="bi bi-bell text-primary fs-4"></i>
          </div>
          <div class="notification-content flex-grow-1">
            <h6 class="mb-1 text-truncate">${notif.titre || notif.title}</h6>
            <p class="mb-1 text-muted small text-truncate">${notif.description.substring(0, 80)}${notif.description.length > 80 ? '...' : ''}</p>
            <small class="text-muted">${notif.date}</small>
          </div>
          ${isUnread ? '<span class="badge bg-primary ms-auto">Nouveau</span>' : ''}
        </a>
      `;
    });

    notifList.innerHTML = html;
    updateBadge(unreadCount);
    console.log('Debug: Notifications chargées:', notifications.length);
  } catch (error) {
    console.error('Erreur fetch notifications:', error);
    notifList.innerHTML = '<p class="text-center text-muted py-3">Erreur de chargement. Réessayez plus tard.</p>';
    updateBadge(0);
  }
}

// Mise à jour du badge (dynamique)
function updateBadge(count) {
  if (!notifCount || !notifBadge) return;
  notifCount.textContent = count;
  notifBadge.textContent = count > 99 ? '99+' : count;
  notifBadge.style.display = count > 0 ? 'block' : 'none';
  console.log('Debug: Badge mis à jour à', count);
}

// Fonction markAsRead (séparée)
async function markAsRead(id) {
  const userId = localStorage.getItem('userId') || 1;
  try {
    const response = await fetch('/EcoSolve/backend/mark_read.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `notif_id=${id}&user_id=${userId}`
    });
    if (response.ok) {
      loadNotifications(true);  // Refresh silencieux (sans spinner)
      console.log('Debug: Notif marquée lue:', id);
    }
  } catch (e) {
    console.error('Erreur mark read:', e);
  }
}

// Toggle du dropdown
if (notificationBtn && notifBox) {
  notificationBtn.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    console.log('Debug: Clic sur bouton détecté !');
    notifBox.classList.toggle('show');
    
    if (notifBox.classList.contains('show')) {
      loadNotifications();  // Full load au clic
    }
  });
} else {
  console.error('Erreur: Bouton ou boîte non trouvés !');
}

// Fermer avec le bouton X
if (closeNotif) {
  closeNotif.addEventListener('click', function(e) {
    e.preventDefault();
    notifBox.classList.remove('show');
    console.log('Debug: Fermé via bouton X');
  });
}

// Fermer si clic dehors
document.addEventListener('click', function(e) {
  if (!notifBox.contains(e.target) && !notificationBtn.contains(e.target)) {
    notifBox.classList.remove('show');
    console.log('Debug: Fermé via clic dehors');
  }
});

// Charge initiale pour badge seulement (optimisation : count_only au load)
window.addEventListener('load', function() {
  const userCity = localStorage.getItem('userCity') || 'Sfax';
  const userId = localStorage.getItem('userId') || 1;
  fetch(`/EcoSolve/backend/get_notifications.php?city=${encodeURIComponent(userCity)}&user_id=${userId}&count_only=1`)
    .then(res => res.json())
    .then(data => updateBadge(data.unread_count || 0))
    .catch(() => updateBadge(0));
});
})();
