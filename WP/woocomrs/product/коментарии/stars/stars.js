






  /*rating*/
  const stars = document.querySelectorAll(".rating__star");
  let resultInput = document.querySelector('.resut__rating'); /* получаю resultInput */
  stars.value = 1;
  for (const star of stars) {
    star.addEventListener("click", () => {
      for (const s of stars) {
        s.classList.remove("active");
      }

      star.classList.add("active");

      const { rate } = star.dataset;
      star.parentNode.dataset.rateTotal = rate;
     
      resultInput.value = rate  /* передаю валуе */
      console.log(resultInput.value)
      console.log(resultInput);
    });
  }
