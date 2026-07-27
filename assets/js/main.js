// =============================
// main.js — Aldernorth Capital
// =============================

document.addEventListener('DOMContentLoaded', () => {

  /**
   * ======================
   * 1. Navbar Toggle (Mobile)
   * ======================
   */
  const navToggler = document.querySelector('[data-nav-toggler]');
  const navbar = document.getElementById('navbar');
  const body = document.body;

  if (navToggler && navbar) {
    navToggler.addEventListener('click', () => {
      const isActive = navbar.classList.contains('navbar-mobile-active');
      if (!isActive) {
        navbar.classList.add('navbar-mobile-active');
        body.style.overflow = 'hidden';
        setTimeout(() => navbar.classList.add('appear'), 10);
        navToggler.classList.add('active');
      } else {
        navbar.classList.remove('appear');
        navToggler.classList.remove('active');
        setTimeout(() => {
          navbar.classList.remove('navbar-mobile-active');
          body.style.overflow = '';
        }, 400);
      }
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (
        navbar.classList.contains('navbar-mobile-active') &&
        !navbar.contains(e.target) &&
        !navToggler.contains(e.target)
      ) {
        navbar.classList.remove('appear');
        navToggler.classList.remove('active');
        setTimeout(() => {
          navbar.classList.remove('navbar-mobile-active');
          body.style.overflow = '';
        }, 400);
      }
    });

    // Close on resize to desktop
    window.addEventListener('resize', () => {
      if (window.innerWidth > 992) {
        navbar.classList.remove('appear', 'navbar-mobile-active');
        navToggler.classList.remove('active');
        body.style.overflow = '';
      }
    });
  }


  /**
   * ======================
   * 2. Header Scroll Effect
   * ======================
   */
  const header = document.querySelector('.header');
  if (header) {
    window.addEventListener('scroll', () => {
      header.classList.toggle('scrolled', window.scrollY > 10);
    });
  }


  /**
   * ======================
   * 3. Interactive Cards
   * ======================
   */
  const interactiveCards = document.querySelectorAll('.platform-card, .testimonial-card');
  interactiveCards.forEach(card => {
    card.addEventListener('mousemove', e => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      card.style.setProperty('--x', `${x}px`);
      card.style.setProperty('--y', `${y}px`);
    });

    card.addEventListener('mouseleave', () => {
      card.style.setProperty('--x', '50%');
      card.style.setProperty('--y', '50%');
    });
  });


  /**
   * ======================
   * 4. FAQ Accordion
   * ======================
   */
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const button = item.querySelector('.faq-question');
    const answer = item.querySelector('.faq-answer');
    const icon = button.querySelector('i');

    button.addEventListener('click', () => {
      const isOpen = item.classList.contains('active');

      if (isOpen) {
        item.classList.remove('active');
        answer.style.maxHeight = null;
        button.setAttribute('aria-expanded', 'false');
        icon.classList.replace('uil-minus', 'uil-plus');
      } else {
        item.classList.add('active');
        answer.style.maxHeight = '0px';
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            answer.style.maxHeight = answer.scrollHeight + 'px';
          });
        });
        button.setAttribute('aria-expanded', 'true');
        icon.classList.replace('uil-plus', 'uil-minus');
      }
    });
  });


  /**
   * ======================
   * 5. Scroll Animations + CountUp Stats
   * ======================
   */
  const animatedElements = document.querySelectorAll('[data-appear], [data-appear-left], [data-appear-right], [data-appear-stagger]');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          if (entry.target.hasAttribute('data-appear-stagger')) {
            const parent = entry.target.parentElement;
            const siblings = parent.querySelectorAll('[data-appear-stagger]');
            siblings.forEach((el, i) => {
              setTimeout(() => el.classList.add('appear'), i * 300);
              observer.unobserve(el);
            });
          } else {
            entry.target.classList.add('appear');
            observer.unobserve(entry.target);
          }
        }
      });
    }, { threshold: 0.7 });

    animatedElements.forEach(el => observer.observe(el));
  } else {
    animatedElements.forEach(el => el.classList.add('appear'));
  }

  // Target any element with a data-count (the "Our Numbers" spans use data-count
  // without the .stat-number class, so the old selector matched nothing).
  const statNumbers = document.querySelectorAll('[data-count]');
  function animateCountUp(el, target, duration = 2000) {
    let startTime = null;
    const step = (timestamp) => {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      const value = Math.floor(progress * target);
      el.textContent = value.toLocaleString();
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const target = parseInt(el.getAttribute('data-count'), 10);
          if (!el.classList.contains('counted')) {
            el.classList.add('counted');
            animateCountUp(el, target);
          }
          observer.unobserve(el);
        }
      });
    }, { threshold: 0.6 });
    statNumbers.forEach(el => observer.observe(el));
  }

}); // end DOMContentLoaded block 1



/**
 * ======================
 * 6. Smartsupp Live Chat Integration
 * ======================
 */
(function() {
  try {
    // Prevent duplicate loading
    if (window.smartsupp) return;

    window._smartsupp = window._smartsupp || {};
    window._smartsupp.key = 'acee1c8fc66bb651454e92b288dd5ddf2d428cc2';

    // Create Smartsupp script dynamically
    const s = document.createElement('script');
    s.type = 'text/javascript';
    s.charset = 'utf-8';
    s.async = true;
    s.src = 'https://www.smartsuppchat.com/loader.js?';
    
    // Append to head safely
    const firstScript = document.getElementsByTagName('script')[0];
    firstScript.parentNode.insertBefore(s, firstScript);

    console.log('✅ Smartsupp chat loaded');
  } catch (err) {
    console.error('❌ Smartsupp failed to load:', err);
  }
})();
