/* sidebar */
let top_btn = document.querySelector("#top_btn");

top_btn.addEventListener("click", (e) => {
  e.preventDefault();
  window.scrollTo({ top: 0, behavior: "smooth" });
});
