function showTab(id) {
  document.querySelectorAll('.tab').forEach(tab => {
    tab.classList.remove('active');
  });
  document.getElementById(id).classList.add('active');

  document.querySelectorAll('.menu a').forEach(link => {
    link.classList.remove('active');
  });
  event.target.classList.add('active');
}
