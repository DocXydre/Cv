////
//// ENTRYPOINT
////
export const initNav = () => {
  initBurgerMenuButton();
  initMenuCloseButton();
  initSearchButton();
};

////
//// SUB INIT
////
const initBurgerMenuButton = () => {
  let burgerButton = document.querySelector("#burger");

  if (burgerButton) {
    burgerButton.addEventListener("click", (e) => {
      e.preventDefault();
      let body = document.querySelector("body");
      body.classList.toggle("menuopen");
      const menuResponsive = document.getElementById("mobileMenu");
      menuResponsive.classList.toggle("open");
    });
  }
};

const initMenuCloseButton = () => {
  let closeButton = document.querySelector("#mobileMenu .close-link");
  if (closeButton) {
    closeButton.addEventListener("click", (e) => {
      e.preventDefault();
      const body = document.querySelector("body");
      body.classList.toggle("menuopen");
      const menuResponsive = document.querySelector("#mobileMenu");
      menuResponsive.classList.toggle("open");
    });
  }
};

const initSearchButton = () => {
  let searchButton = document.querySelector("#search");

  if (searchButton) {
    searchButton.addEventListener("click", (e) => {
      e.preventDefault();

      let searchForm = document.querySelector("div.searchbar");
      searchForm.classList.toggle("open");
      document.getElementById("searchinput").focus();
    });
  }
};
