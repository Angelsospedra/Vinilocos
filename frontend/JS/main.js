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


document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("modalResena");
    const closeBtn = document.querySelector(".close-modal");
    const viniloIdInput = document.getElementById("modalViniloId");
    const botonesResenas = document.querySelectorAll(".btn-resenas");

    botonesResenas.forEach(btn => {
        btn.addEventListener("click", () => {
            viniloIdInput.value = btn.dataset.viniloId;
            modal.style.display = "flex";
        });
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });

});
