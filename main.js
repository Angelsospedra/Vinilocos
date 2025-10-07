const vinylBtn = document.getElementById('menuToggle');
const sidebar = document.getElementById('sidebar');

vinylBtn.addEventListener('click', () => {
  sidebar.classList.toggle('open');
  vinylBtn.classList.toggle('active');
});
