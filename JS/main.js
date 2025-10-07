document.addEventListener("DOMContentLoaded", function() {
  const vinylBtn = document.getElementById("menuToggle");
  const sidebar = document.getElementById("sidebar");

  if (vinylBtn && sidebar) {
    vinylBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      vinylBtn.classList.toggle("active");
    });
  } else {
    console.error("No se encontró el botón o el sidebar.");
  }
});
