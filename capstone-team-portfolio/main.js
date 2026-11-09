(function () {
  'use strict';

  var root = document.documentElement;
  var themeButton = document.querySelector('[data-theme-toggle]');
  var menuButton = document.querySelector('.menu-toggle');
  var navigation = document.querySelector('.primary-nav');

  function applyTheme(theme) {
    var selectedTheme = theme === 'light' ? 'light' : 'dark';
    root.setAttribute('data-theme', selectedTheme);
    if (themeButton) {
      var isDark = selectedTheme === 'dark';
      themeButton.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
      themeButton.setAttribute('title', isDark ? 'Switch to light mode' : 'Switch to dark mode');
      var label = themeButton.querySelector('.theme-toggle-label');
      if (label) label.textContent = isDark ? 'Light' : 'Dark';
    }
  }

  // The inline head script has already chosen saved mode or the system preference.
  applyTheme(root.getAttribute('data-theme'));

  if (themeButton) {
    themeButton.addEventListener('click', function () {
      var nextTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      applyTheme(nextTheme);
      try {
        window.localStorage.setItem('ctp-theme', nextTheme);
      } catch (error) {
        // The theme still changes for the current page when storage is unavailable.
      }
    });
  }

  if (menuButton && navigation) {
    menuButton.addEventListener('click', function () {
      var open = navigation.classList.toggle('is-open');
      document.body.classList.toggle('nav-open', open);
      menuButton.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    navigation.addEventListener('click', function (event) {
      if (event.target.closest('a')) {
        navigation.classList.remove('is-open');
        document.body.classList.remove('nav-open');
        menuButton.setAttribute('aria-expanded', 'false');
      }
    });
  }

  var filterButtons = document.querySelectorAll('.project-filter');
  var projectCards = document.querySelectorAll('.project-card');
  if (filterButtons.length && projectCards.length) {
    filterButtons.forEach(function (button) {
      button.addEventListener('click', function () {
        var filter = button.getAttribute('data-filter') || 'all';
        filterButtons.forEach(function (item) {
          var active = item === button;
          item.classList.toggle('is-active', active);
          item.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
        projectCards.forEach(function (card) {
          var categories = (card.getAttribute('data-categories') || '').split(/\s+/).filter(Boolean);
          var visible = filter === 'all' || categories.indexOf(filter) !== -1;
          card.hidden = !visible;
          card.setAttribute('aria-hidden', visible ? 'false' : 'true');
        });
      });
    });
  }

  var counters = document.querySelectorAll('[data-counter]');
  function animateCounter(element) {
    if (element.getAttribute('data-counted') === 'true') return;
    element.setAttribute('data-counted', 'true');
    var target = parseInt(element.getAttribute('data-counter'), 10) || 0;
    var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reducedMotion || target === 0) {
      element.textContent = String(target);
      return;
    }
    var duration = 900;
    var start = null;
    function tick(timestamp) {
      if (!start) start = timestamp;
      var progress = Math.min((timestamp - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3);
      element.textContent = String(Math.round(target * eased));
      if (progress < 1) window.requestAnimationFrame(tick);
    }
    window.requestAnimationFrame(tick);
  }
  if ('IntersectionObserver' in window && counters.length) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.35 });
    counters.forEach(function (counter) {
      counter.textContent = '0';
      observer.observe(counter);
    });
  } else {
    counters.forEach(animateCounter);
  }

  var contactType = document.getElementById('ctp_contact_type');
  var memberField = document.querySelector('.contact-member-field');
  var memberSelect = document.getElementById('ctp_member_id');
  function updateContactRecipientField() {
    if (!contactType || !memberField || !memberSelect) return;
    var individual = contactType.value === 'individual';
    memberField.hidden = !individual;
    memberSelect.required = individual;
    if (!individual) memberSelect.value = '';
  }
  if (contactType) {
    contactType.addEventListener('change', updateContactRecipientField);
    updateContactRecipientField();
  }
}());
