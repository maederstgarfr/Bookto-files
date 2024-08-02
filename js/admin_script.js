let navbarr = document.querySelector(".navbar");
let acountbox = document.querySelector(".account-box");

document.getElementById("user-btn").onclick = () => {
  acountbox.classList.toggle("active");

  console.log("actived, user btn");
};

document.getElementById("menu-btn").onclick = () => {
  navbarr.classList.toggle("hide");
  console.log("actived, menu btn");
};

Window.onscroll = () => {
  navbarr.classList.remove("active");
  acountbox.classList.remove("active");
};
document.querySelector("#close_update").onclick = () => {
  document.querySelector(".edit_products_form").style.display = "none";
  window.location.href = "admin_products.php";
};
