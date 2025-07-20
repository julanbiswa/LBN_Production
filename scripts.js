// Add animation to CTA button
    const ctaButton = document.querySelector('.cta-button');
    ctaButton.addEventListener('mouseover', () => {
        ctaButton.style.transform = 'translateY(-3px)';
    });
    ctaButton.addEventListener('mouseout', () => {
        ctaButton.style.transform = 'translateY(0)';
    });

    // Form submission handling
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Add your form submission logic here
            alert('Thank you for your message! We will get back to you soon.');
            contactForm.reset();
        });
    }

    // Add animation to service cards on scroll
    const observerOptions = {
        threshold: 0.2
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.service-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        observer.observe(card);
    });
    
    // JavaScript for Hamburger Menu Toggle
const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');
  let menuOpen = false;

  navToggle.onclick = function() {
    if (!menuOpen) {
      navLinks.style.right = '5px';
      menuOpen = true;
    } else {
      navLinks.style.right = '-300px';
      menuOpen = false;
    }
  };






