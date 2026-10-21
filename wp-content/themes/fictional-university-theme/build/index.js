class MobileMenu {
  constructor() {
    this.menu = document.querySelector(".site-header__menu");
    this.openButton = document.querySelector(".site-header__menu-trigger");
    this.events();
  }

  events() {
    this.openButton.addEventListener("click", () => this.openMenu());
  }

  openMenu() {
    this.openButton.classList.toggle("fa-bars");
    this.openButton.classList.toggle("fa-window-close");
    this.menu.classList.toggle("site-header__menu--active");
  }
}

class HeroSlider {
  constructor() {
    if (!document.querySelector(".hero-slider")) return;

    const slideCount = document.querySelectorAll(".hero-slider__slide").length;
    let bullets = "";
    for (let i = 0; i < slideCount; i++) {
      bullets += `<button class="slider__bullet glide__bullet" data-glide-dir="=${i}"></button>`;
    }
    document.querySelector(".glide__bullets").insertAdjacentHTML("beforeend", bullets);

    new Glide(".hero-slider", {
      type: "carousel",
      perView: 1,
      autoplay: 3000
    }).mount();
  }
}

new MobileMenu();
new HeroSlider();