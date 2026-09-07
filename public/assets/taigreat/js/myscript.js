var swiper = new Swiper(".index_swiper", {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  loopFillGroupWithBlank: true,
  effect: 'fade',
  fadeEffect: {
    crossFade: true
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});


var navscroll = window.innerWidth < 767 ? -30 : 50;
gsap.to(".in_b_title", {
  yPercent: navscroll,
  ease: "none",
  scrollTrigger: {
    trigger: ".index_swiper .swiper-slide",
    start: "top 100px",
    end: "+=800",
    scrub: true
  },
});

gsap.to(".in_p_box", {
  yPercent: 30,
  ease: "power1.inOut",
  scrollTrigger: {
    trigger: ".in_p_bg",
    scrub: true
  },
});




var topScroll = window.innerWidth < 991 ? 30 : -50;

gsap.to(".in_p_box2", {
  yPercent: topScroll,
  ease: "power1.inOut",
  scrollTrigger: {
    trigger: ".in_p_bg",
    scrub: true
  },
});


function animateFrom(elem, direction) {
  direction = direction || 1;
  var x = 0,
    y = direction * 100;
  if (elem.classList.contains("gs_reveal_fromLeft")) {
    x = -100;
    y = 0;
  } else if (elem.classList.contains("gs_reveal_fromRight")) {
    x = 100;
    y = 0;
  }
  elem.style.transform = "translate(" + x + "px, " + y + "px)";
  elem.style.opacity = "0";
  gsap.fromTo(elem, {
    x: x,
    y: y,
    autoAlpha: 0
  }, {
    duration: 1.25,
    x: 0,
    y: 0,
    autoAlpha: 1,
    ease: "expo",
    overwrite: "auto"
  });
}

function hide(elem) {
  gsap.set(elem, {
    autoAlpha: 0
  });
}

document.addEventListener("DOMContentLoaded", function() {
  gsap.registerPlugin(ScrollTrigger);

  gsap.utils.toArray(".gs_reveal").forEach(function(elem) {
    hide(elem); // assure that the element is hidden when scrolled into view

    ScrollTrigger.create({
      trigger: elem,
      onEnter: function() {
        animateFrom(elem)
      },
      onEnterBack: function() {
        animateFrom(elem, -1)
      },
      onLeave: function() {
        hide(elem)
      } // assure that the element is hidden when scrolled into view
    });
  });
});


var topScroll2 = window.innerWidth < 991 ? 0 : -50;
gsap.to(".in_s_pa", {
  scrollTrigger: {
    trigger: ".in_s_img",
    scrub: 0.5,
    start: "top bottom",
    end: "bottom -300%",
    ease: "power2.inOut"
  },
  y: topScroll2+"%"
});


gsap.to(".in_s_box b", {
  yPercent: 30,
  ease: "power1.inOut",
  scrollTrigger: {
    trigger: ".in_s_box",
    scrub: true
  },
});