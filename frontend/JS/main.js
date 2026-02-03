// Configuración del Backend URL para Railway
const BACKEND_URL = 'https://vinilocos-production.up.railway.app';

document.addEventListener("DOMContentLoaded", function() {
  const vinylBtn = document.getElementById("menuToggle");
  const sidebar = document.getElementById("sidebar");

  if (vinylBtn && sidebar) {
    vinylBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      vinylBtn.classList.add("active");
      setTimeout(() => {
        vinylBtn.classList.remove("active");
      }, 600); // 1 segundo
    });
  } else {
    console.error("No se encontró el botón o el sidebar.");
  }
});
