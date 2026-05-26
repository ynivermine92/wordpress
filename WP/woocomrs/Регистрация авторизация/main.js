/* при клике меняет блоки регестрацию , или авторизацию */

document.addEventListener("DOMContentLoaded", function () {
  const login = document.querySelector(".auth-login");
  const register = document.querySelector(".auth-register");

  document
    .querySelector(".js-show-register")
    ?.addEventListener("click", function (e) {
      e.preventDefault();
      login.classList.remove("active");
      register.classList.add("active");
    });

  document
    .querySelector(".js-show-login")
    ?.addEventListener("click", function (e) {
      e.preventDefault();
      register.classList.remove("active");
      login.classList.add("active");
    });
});
