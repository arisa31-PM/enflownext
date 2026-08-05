document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const header = document.querySelector(".js-header");
  const fv = document.querySelector(".js-fv, .p-page-fv, .p-works-single__hero");
  const ctaHook = document.querySelector(".js-cta");
  const cta = ctaHook || document.querySelector(".p-common-cta");
  const isWorksArchive = document.querySelector(".p-works-archive");
  const isWorksSingle = document.querySelector(".p-works-single");
  const pageTop = document.querySelector(".js-page-top");
  const menuButton = document.querySelector(".js-menu-button");
  const drawer = document.querySelector(".js-drawer");
  const drawerLinks = document.querySelectorAll(".js-drawer-link");
  const gradientSection = document.querySelector(".js-gradient-section");

  const setViewportVars = () => {
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    document.documentElement.style.setProperty("--scrollbar-width", `${scrollbarWidth}px`);
  };

  setViewportVars();
  window.addEventListener("resize", setViewportVars);

  body.classList.add("is-loaded");

  if (typeof Swiper !== "undefined") {
    const fvSlider = document.querySelector(".js-fv-slider");
    if (fvSlider) {
      const fvSlides = fvSlider.querySelectorAll(".swiper-slide");

      const startFvZoom = (slide) => {
        const image = slide?.querySelector(".p-fv__image");

        if (!slide || !image) {
          return;
        }

        slide.classList.remove("is-fv-zooming", "is-fv-frozen");
        image.style.animation = "none";
        image.style.transform = "scale(1)";
        image.offsetHeight;
        image.style.animation = "";
        image.style.transform = "";
        slide.classList.add("is-fv-zooming");
      };

      const freezeFvZoom = (slide) => {
        const image = slide?.querySelector(".p-fv__image");

        if (!slide || !image) {
          return;
        }

        const currentTransform = window.getComputedStyle(image).transform;
        slide.classList.remove("is-fv-zooming");
        slide.classList.add("is-fv-frozen");
        image.style.animation = "none";
        image.style.transform = currentTransform === "none" ? "scale(1)" : currentTransform;
      };

      const resetFvZoom = (swiper) => {
        swiper.slides.forEach((slide, index) => {
          if (index === swiper.activeIndex) {
            return;
          }

          const image = slide.querySelector(".p-fv__image");
          slide.classList.remove("is-fv-zooming", "is-fv-frozen");

          if (image) {
            image.style.animation = "";
            image.style.transform = "";
          }
        });
      };

      const preloadFvImages = () => {
        fvSlider.querySelectorAll(".p-fv__image").forEach((image) => {
          if (typeof image.decode === "function") {
            image.decode().catch(() => {});
          }
        });
      };

      preloadFvImages();

      if (fvSlides.length >= 2) {
        new Swiper(fvSlider, {
          effect: "fade",
          fadeEffect: {
            crossFade: true,
          },
          loop: false,
          rewind: true,
          speed: 2000,
          allowTouchMove: false,
          autoplay: {
            delay: 4000,
            disableOnInteraction: false,
          },
          on: {
            init(swiper) {
              startFvZoom(swiper.slides[swiper.activeIndex]);
            },
            slideChangeTransitionStart(swiper) {
              freezeFvZoom(swiper.slides[swiper.previousIndex]);
              startFvZoom(swiper.slides[swiper.activeIndex]);
            },
            slideChangeTransitionEnd(swiper) {
              resetFvZoom(swiper);
            },
          },
        });
      }

      window.addEventListener("load", preloadFvImages, {
        once: true,
      });
    }

    const worksSlider = document.querySelector(".js-works-slider");
    if (worksSlider) {
      const worksSwiper = new Swiper(worksSlider, {
        loop: true,
        speed: 700,
        grabCursor: true,
        slidesPerView: "auto",
        centeredSlides: true,
        slidesOffsetBefore: 0,
        spaceBetween: 26,
        autoplay: {
          delay: 2600,
          disableOnInteraction: false,
        },
        navigation: {
          nextEl: ".js-works-next",
          prevEl: ".js-works-prev",
        },
        breakpoints: {
          768: {
            centeredSlides: false,
            spaceBetween: 30,
          },
        },
      });

      const worksCards = worksSlider.querySelectorAll(".p-works__card");
      const pcMediaQuery = window.matchMedia("(min-width: 768px)");

      worksCards.forEach((card) => {
        card.addEventListener("mouseenter", () => {
          if (pcMediaQuery.matches) {
            worksSwiper.autoplay.stop();
          }
        });

        card.addEventListener("mouseleave", () => {
          if (pcMediaQuery.matches) {
            worksSwiper.autoplay.start();
          }
        });
      });
    }

    const worksRelatedSlider = document.querySelector(".js-works-related-slider");
    if (worksRelatedSlider) {
      const worksRelatedSlides = worksRelatedSlider.querySelectorAll(".p-works-single__related-item");
      const worksRelatedSwiper = new Swiper(worksRelatedSlider, {
        loop: worksRelatedSlides.length > 2,
        speed: 700,
        grabCursor: true,
        slidesPerView: "auto",
        centeredSlides: false,
        slidesOffsetBefore: 0,
        spaceBetween: 20,
        autoplay: worksRelatedSlides.length > 2 ?
          {
            delay: 2600,
            disableOnInteraction: false,
          } :
          false,
        navigation: {
          nextEl: ".js-works-related-next",
          prevEl: ".js-works-related-prev",
        },
        breakpoints: {
          768: {
            slidesOffsetBefore: 280,
            spaceBetween: 50,
          },
        },
      });

      const worksRelatedCards = worksRelatedSlider.querySelectorAll(".p-works-related-card");
      const pcMediaQuery = window.matchMedia("(min-width: 768px)");

      worksRelatedCards.forEach((card) => {
        card.addEventListener("mouseenter", () => {
          if (pcMediaQuery.matches && worksRelatedSwiper.autoplay) {
            worksRelatedSwiper.autoplay.stop();
          }
        });

        card.addEventListener("mouseleave", () => {
          if (pcMediaQuery.matches && worksRelatedSwiper.autoplay) {
            worksRelatedSwiper.autoplay.start();
          }
        });
      });
    }
  }

  const closeDrawer = () => {
    if (!menuButton || !drawer) {
      return;
    }
    menuButton.setAttribute("aria-expanded", "false");
    menuButton.setAttribute("aria-label", "メニューを開く");
    drawer.setAttribute("aria-hidden", "true");
    header?.classList.remove("is-open");
    drawer.classList.remove("is-open");
    body.classList.remove("is-drawer-open");
  };

  if (menuButton && drawer) {
    menuButton.addEventListener("click", () => {
      const isOpen = menuButton.getAttribute("aria-expanded") === "true";
      menuButton.setAttribute("aria-expanded", String(!isOpen));
      menuButton.setAttribute("aria-label", isOpen ? "メニューを開く" : "メニューを閉じる");
      drawer.setAttribute("aria-hidden", String(isOpen));
      header?.classList.toggle("is-open", !isOpen);
      drawer.classList.toggle("is-open", !isOpen);
      body.classList.toggle("is-drawer-open", !isOpen);
    });
  }

  drawerLinks.forEach((link) => {
    link.addEventListener("click", closeDrawer);
  });

  const updateScrollState = () => {
    if (body.classList.contains("is-contact-confirm")) {
      header?.classList.add("is-scrolled");
      pageTop?.classList.remove("is-visible");
      return;
    }

    const fvBottom = fv ? fv.getBoundingClientRect().bottom + window.scrollY : 70;
    const scrolledPastFv = window.scrollY > fvBottom - 80;
    const ctaPosition = cta ? cta.getBoundingClientRect().top : Number.POSITIVE_INFINITY;
    const ctaTop = cta ? ctaPosition + window.scrollY : Number.POSITIVE_INFINITY;
    const ctaThreshold = isWorksArchive || isWorksSingle ? 300 : 160;
    const isBeforeCta = ctaHook ? window.scrollY + window.innerHeight < ctaTop : ctaPosition > ctaThreshold;

    header?.classList.toggle("is-scrolled", scrolledPastFv);
    pageTop?.classList.toggle("is-visible", scrolledPastFv && isBeforeCta);
  };

  window.addEventListener("scroll", updateScrollState, {
    passive: true,
  });
  window.addEventListener("resize", updateScrollState);
  updateScrollState();

  pageTop?.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });

  const faqAccordion = document.querySelector(".js-faq-accordion");
  if (faqAccordion) {
    const faqItems = Array.from(faqAccordion.querySelectorAll(".js-faq-item"));
    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

    const getFaqTrigger = (item) => item.querySelector(".js-faq-trigger");
    const getFaqPanel = (item) => item.querySelector(".js-faq-panel");

    const openFaqItem = (item, immediate = false) => {
      const trigger = getFaqTrigger(item);
      const panel = getFaqPanel(item);

      if (!trigger || !panel) {
        return;
      }

      trigger.setAttribute("aria-expanded", "true");
      item.classList.add("is-open");
      item.classList.remove("is-collapsed");

      if (immediate || prefersReducedMotion.matches) {
        panel.hidden = false;
        panel.style.height = "auto";
        panel.style.opacity = "1";
        panel.style.overflow = "";
        panel.dataset.faqState = "open";
        return;
      }

      panel.hidden = false;
      panel.style.overflow = "hidden";
      panel.style.height = "0px";
      panel.style.opacity = "0";
      panel.offsetHeight;
      panel.dataset.faqState = "opening";

      window.requestAnimationFrame(() => {
        panel.style.height = `${panel.scrollHeight}px`;
        panel.style.opacity = "1";
      });
    };

    const closeFaqItem = (item, immediate = false) => {
      const trigger = getFaqTrigger(item);
      const panel = getFaqPanel(item);

      if (!trigger || !panel) {
        return;
      }

      trigger.setAttribute("aria-expanded", "false");
      item.classList.add("is-collapsed");
      item.classList.remove("is-open");

      if (immediate || prefersReducedMotion.matches) {
        panel.hidden = true;
        panel.style.height = "0px";
        panel.style.opacity = "0";
        panel.style.overflow = "hidden";
        panel.dataset.faqState = "closed";
        return;
      }

      panel.hidden = false;
      panel.style.overflow = "hidden";
      panel.style.height = `${panel.scrollHeight}px`;
      panel.style.opacity = "1";
      panel.offsetHeight;
      panel.dataset.faqState = "closing";

      window.requestAnimationFrame(() => {
        panel.style.height = "0px";
        panel.style.opacity = "0";
      });
    };

    const toggleFaqItem = (item) => {
      const isOpen = item.classList.contains("is-open");

      if (isOpen) {
        closeFaqItem(item);
        return;
      }

      openFaqItem(item);
    };

    faqItems.forEach((item, index) => {
      const trigger = getFaqTrigger(item);
      const panel = getFaqPanel(item);
      const isOpen = 0 === index;

      if (!trigger || !panel) {
        return;
      }

      panel.addEventListener("transitionend", (event) => {
        if (event.propertyName !== "height") {
          return;
        }

        if ("opening" === panel.dataset.faqState) {
          panel.style.height = "auto";
          panel.style.overflow = "";
          panel.dataset.faqState = "open";
          return;
        }

        if ("closing" === panel.dataset.faqState) {
          panel.hidden = true;
          panel.dataset.faqState = "closed";
        }
      });

      trigger.addEventListener("click", (event) => {
        event.stopPropagation();
        toggleFaqItem(item);
      });

      item.addEventListener("click", (event) => {
        if (event.target.closest(".js-faq-trigger, a, button, input, select, textarea, label")) {
          return;
        }

        toggleFaqItem(item);
      });

      if (isOpen) {
        openFaqItem(item, true);
        return;
      }

      closeFaqItem(item, true);
    });
  }

  document.querySelectorAll('a[href*="#"]').forEach((anchor) => {
    anchor.addEventListener("click", (event) => {
      const href = anchor.getAttribute("href");
      if (!href) {
        return;
      }

      const url = new URL(href, window.location.href);
      if (url.pathname !== window.location.pathname || !url.hash) {
        return;
      }

      const target = document.querySelector(url.hash);
      if (!target) {
        return;
      }

      event.preventDefault();
      const headerHeight = header ? header.offsetHeight : 0;
      const targetTop = target.getBoundingClientRect().top + window.scrollY - headerHeight;
      window.scrollTo({
        top: targetTop,
        behavior: "smooth",
      });
    });
  });

  if (gradientSection && "IntersectionObserver" in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-active");
          }
        });
      }, {
        threshold: 0.25,
      }
    );
    observer.observe(gradientSection);
  } else {
    gradientSection?.classList.add("is-active");
  }

  const priceSection = document.querySelector(".js-price-section");
  const priceCounts = priceSection ? priceSection.querySelectorAll(".js-price-count") : [];

  if (priceSection && priceCounts.length) {
    const formatter = new Intl.NumberFormat("ja-JP");
    const duration = 10000;
    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    const getNumber = (element, key) => {
      const value = Number(element.dataset[key]);
      return Number.isFinite(value) ? value : 0;
    };

    const setCount = (element, value) => {
      element.textContent = formatter.format(Math.round(value));
    };

    const setFinalCounts = () => {
      priceCounts.forEach((count) => {
        setCount(count, getNumber(count, "end"));
      });
    };

    const animateCounts = () => {
      const startedAt = performance.now();

      priceCounts.forEach((count) => {
        setCount(count, getNumber(count, "start"));
      });

      const update = (currentTime) => {
        const progress = Math.min((currentTime - startedAt) / duration, 1);

        priceCounts.forEach((count) => {
          const start = getNumber(count, "start");
          const end = getNumber(count, "end");
          const currentValue = start + (end - start) * progress;
          setCount(count, currentValue);
        });

        if (progress < 1) {
          requestAnimationFrame(update);
        } else {
          setFinalCounts();
        }
      };

      requestAnimationFrame(update);
    };

    if (reduceMotion) {
      setFinalCounts();
    } else if ("IntersectionObserver" in window) {
      const priceObserver = new IntersectionObserver(
        (entries, observer) => {
          entries.forEach((entry) => {
            if (!entry.isIntersecting) {
              return;
            }

            animateCounts();
            observer.unobserve(entry.target);
          });
        }, {
          threshold: 0.2,
        }
      );

      priceObserver.observe(priceSection);
    } else {
      animateCounts();
    }
  }

  const contactForms = document.querySelectorAll(".p-contact-page__form .wpcf7-form");
  const contactPageForm = document.querySelector(".p-contact-page__form");
  const contactThanksUrl = contactPageForm?.dataset.thanksUrl || "";
  let isContactConfirm = false;
  let hasContactThanksRedirected = false;

  const isTouchDevice =
    window.matchMedia("(pointer: coarse)").matches ||
    window.matchMedia("(max-width: 767px)").matches ||
    navigator.maxTouchPoints > 0;

  const decorateContactConfirmRequiredBadges = () => {
    const confirmationTable = document.querySelector(".p-contact-page #wpcf7cpcnf");

    if (!confirmationTable) {
      return;
    }

    confirmationTable.querySelectorAll("th p").forEach((label) => {
      if (label.dataset.requiredBadgeDecorated === "true") {
        return;
      }

      const rawText = label.textContent.replace(/\s+/g, " ").trim();
      const isPrivacyLabel = "プライバシーポリシーに同意する" === rawText;
      const isRequiredLabel = /\s*必須$/.test(rawText);

      if (!isPrivacyLabel && !isRequiredLabel) {
        return;
      }

      const baseText = isRequiredLabel ? rawText.replace(/\s*必須$/, "").trim() : rawText;

      label.textContent = baseText;
      label.append(" ");

      const badge = document.createElement("span");
      badge.className = "c-tag c-tag--required";
      badge.textContent = "必須";
      label.appendChild(badge);
      label.dataset.requiredBadgeDecorated = "true";
    });
  };

  const syncContactConfirmState = () => {
    const nextIsContactConfirm = Boolean(document.querySelector(".p-contact-page #wpcf7cpcnf"));

    body.classList.toggle("is-contact-confirm", nextIsContactConfirm);
    updateScrollState();

    if (nextIsContactConfirm) {
      window.requestAnimationFrame(decorateContactConfirmRequiredBadges);
    }

    if (nextIsContactConfirm && !isContactConfirm) {
      window.requestAnimationFrame(() => {
        window.scrollTo({
          top: 0,
          behavior: "auto",
        });
        window.setTimeout(() => {
          window.scrollTo({
            top: 0,
            behavior: "auto",
          });
        }, 120);
      });
    }

    isContactConfirm = nextIsContactConfirm;
  };

  if (isTouchDevice) {
    document.querySelectorAll('.p-contact-page__form .wpcf7-acceptance label').forEach((label) => {
      const checkbox = label.querySelector('input[type="checkbox"]');

      if (!checkbox) {
        return;
      }

      const blurCheckbox = () => {
        window.requestAnimationFrame(() => {
          checkbox.blur();
        });
      };

      label.addEventListener('touchend', blurCheckbox, {
        passive: true
      });
      label.addEventListener('click', blurCheckbox);
      checkbox.addEventListener('click', blurCheckbox);
    });
  }

  const contactFormContainers = document.querySelectorAll(".p-contact-page__form .wpcf7");

  contactFormContainers.forEach((container) => {
    if (!("MutationObserver" in window)) {
      return;
    }

    const observer = new MutationObserver(syncContactConfirmState);
    observer.observe(container, {
      childList: true,
      subtree: true,
    });
  });

  syncContactConfirmState();

  const isRequiredField = (field) => {
    return (
      field.required ||
      field.getAttribute("aria-required") === "true" ||
      field.classList.contains("wpcf7-validates-as-required")
    );
  };

  const isFieldComplete = (field) => {
    if (field.disabled || field.type === "hidden" || field.type === "submit" || field.type === "button" || field.type === "reset") {
      return true;
    }

    if (!isRequiredField(field)) {
      return true;
    }

    if ("checkbox" === field.type || "radio" === field.type) {
      return field.checked;
    }

    if ("select-multiple" === field.type) {
      return Array.from(field.options).some((option) => option.selected);
    }

    return "" !== String(field.value ?? "").trim();
  };

  const isFieldSetComplete = (form) => {
    const fields = form.querySelectorAll("input, select, textarea");

    return Array.from(fields).every((field) => isFieldComplete(field));
  };

  const updateContactSubmitState = (form) => {
    const submitButton = form.querySelector(".wpcf7-submit");

    if (!submitButton) {
      return;
    }

    const isComplete = isFieldSetComplete(form);

    submitButton.disabled = !isComplete;
    submitButton.setAttribute("aria-disabled", String(!isComplete));
  };

  contactForms.forEach((form) => {
    const submitButton = form.querySelector(".wpcf7-submit");

    if (!submitButton) {
      return;
    }

    const syncSubmitState = () => {
      updateContactSubmitState(form);
    };

    submitButton.disabled = true;
    submitButton.setAttribute("aria-disabled", "true");

    syncSubmitState();

    form.addEventListener("input", syncSubmitState);
    form.addEventListener("change", syncSubmitState);
    form.addEventListener("reset", () => {
      window.requestAnimationFrame(syncSubmitState);
    });
    form.addEventListener("wpcf7invalid", syncSubmitState);
    form.addEventListener("wpcf7spam", syncSubmitState);
    form.addEventListener("wpcf7mailfailed", syncSubmitState);
    form.addEventListener("wpcf7mailsent", (event) => {
      syncSubmitState();

      if (hasContactThanksRedirected || !contactThanksUrl) {
        return;
      }

      if (!event.target || !event.target.closest(".p-contact-page__form")) {
        return;
      }

      hasContactThanksRedirected = true;
      window.location.href = contactThanksUrl;
    });

    window.addEventListener("pageshow", syncSubmitState);
  });

  const privacyTexts = document.querySelectorAll(".p-contact-page__privacy-text");

  privacyTexts.forEach((privacyText) => {
    let frameId = 0;
    let privacyScrollContent = privacyText.querySelector(".p-contact-page__privacy-scroll-content");

    if (!privacyScrollContent) {
      privacyScrollContent = document.createElement("div");
      privacyScrollContent.className = "p-contact-page__privacy-scroll-content";
      privacyScrollContent.setAttribute("tabindex", "0");

      while (privacyText.firstChild) {
        privacyScrollContent.appendChild(privacyText.firstChild);
      }

      privacyText.appendChild(privacyScrollContent);
    }

    let privacyScrollbar = privacyText.querySelector(".p-contact-page__privacy-scrollbar");

    if (!privacyScrollbar) {
      privacyScrollbar = document.createElement("div");
      privacyScrollbar.className = "p-contact-page__privacy-scrollbar";
      privacyScrollbar.setAttribute("aria-hidden", "true");
      privacyScrollbar.innerHTML = '<div class="p-contact-page__privacy-scrollbar-track"></div><div class="p-contact-page__privacy-scrollbar-thumb"></div>';
      privacyText.appendChild(privacyScrollbar);
    }

    const updatePrivacyScrollbar = () => {
      if (frameId) {
        return;
      }

      frameId = window.requestAnimationFrame(() => {
        frameId = 0;

        const scrollHeight = privacyScrollContent.scrollHeight;
        const clientHeight = privacyScrollContent.clientHeight;
        const scrollTop = privacyScrollContent.scrollTop;
        const trackHeight = privacyScrollbar.clientHeight;

        if (scrollHeight <= clientHeight || 0 === trackHeight) {
          privacyText.style.setProperty("--privacy-scrollbar-thumb-top", "0px");
          privacyText.style.setProperty("--privacy-scrollbar-thumb-height", "0px");
          privacyText.style.setProperty("--privacy-scrollbar-opacity", "0");
          return;
        }

        const thumbMinHeight = 44;
        const thumbHeight = Math.min(Math.max((clientHeight / scrollHeight) * trackHeight, thumbMinHeight), trackHeight);
        const maxThumbTop = Math.max(trackHeight - thumbHeight, 0);
        const maxScrollTop = Math.max(scrollHeight - clientHeight, 1);
        const thumbTop = (scrollTop / maxScrollTop) * maxThumbTop;

        privacyText.style.setProperty("--privacy-scrollbar-thumb-top", `${thumbTop}px`);
        privacyText.style.setProperty("--privacy-scrollbar-thumb-height", `${thumbHeight}px`);
        privacyText.style.setProperty("--privacy-scrollbar-opacity", "1");
      });
    };

    privacyScrollContent.addEventListener("scroll", updatePrivacyScrollbar, {
      passive: true,
    });

    window.addEventListener("resize", updatePrivacyScrollbar);

    if (document.fonts && "ready" in document.fonts) {
      document.fonts.ready.then(updatePrivacyScrollbar).catch(() => {});
    }

    if ("ResizeObserver" in window) {
      const resizeObserver = new ResizeObserver(updatePrivacyScrollbar);
      resizeObserver.observe(privacyScrollContent);
    }

    updatePrivacyScrollbar();
  });
});