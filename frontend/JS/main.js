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

// === CARRUSEL DE RESEÑAS ===
document.addEventListener("DOMContentLoaded", () => {
    const carousel = document.getElementById("reviewsCarousel");
    const prevBtn = document.querySelector(".carousel-btn-prev");
    const nextBtn = document.querySelector(".carousel-btn-next");
    const dotsContainer = document.getElementById("carouselDots");
    
    if (!carousel || !prevBtn || !nextBtn || !dotsContainer) {
        return; // Si no existe el carrusel, salir
    }

    const cards = carousel.querySelectorAll(".review-card");
    const totalCards = cards.length;
    let currentIndex = 0;
    let autoScrollInterval = null;
    const autoScrollDelay = 5000; // 5 segundos

    // Crear dots
    for (let i = 0; i < totalCards; i++) {
        const dot = document.createElement("button");
        dot.classList.add("carousel-dot");
        if (i === 0) dot.classList.add("active");
        dot.setAttribute("aria-label", `Ir a reseña ${i + 1}`);
        dot.addEventListener("click", () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }

    const dots = dotsContainer.querySelectorAll(".carousel-dot");

    function updateCarousel() {
        const translateX = -currentIndex * 100;
        carousel.style.transform = `translateX(${translateX}%)`;
        
        // Actualizar dots
        dots.forEach((dot, index) => {
            if (dot) {
                dot.classList.toggle("active", index === currentIndex);
            }
        });
    }

    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
        resetAutoScroll();
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalCards;
        updateCarousel();
        resetAutoScroll();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalCards) % totalCards;
        updateCarousel();
        resetAutoScroll();
    }

    function startAutoScroll() {
        autoScrollInterval = setInterval(nextSlide, autoScrollDelay);
    }

    function stopAutoScroll() {
        if (autoScrollInterval) {
            clearInterval(autoScrollInterval);
            autoScrollInterval = null;
        }
    }

    function resetAutoScroll() {
        stopAutoScroll();
        startAutoScroll();
    }

    // Event listeners
    nextBtn.addEventListener("click", nextSlide);
    prevBtn.addEventListener("click", prevSlide);

    // Pausar auto-scroll al hacer hover
    const carouselContainer = carousel.closest(".reviews-carousel-container");
    if (carouselContainer) {
        carouselContainer.addEventListener("mouseenter", stopAutoScroll);
        carouselContainer.addEventListener("mouseleave", startAutoScroll);
    }

    // Iniciar auto-scroll
    startAutoScroll();

    // Inicializar posición
    updateCarousel();
});
