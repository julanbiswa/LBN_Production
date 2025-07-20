const navToggle = document.getElementById('navToggle');
  const navLinks = document.getElementById('navLinks');
  let menuOpen = false;

  navToggle.onclick = function() {
    if (!menuOpen) {
      navLinks.style.right = '0px';
      menuOpen = true;
    } else {
      navLinks.style.right = '-300px';
      menuOpen = false;
    }
  };

  const video = document.getElementById('myVideo');
  const audioToggle = document.getElementById('audioToggle');
  const audioIcon = document.getElementById('audioIcon');

  audioToggle.onclick = function() {
    video.muted = !video.muted;
    audioIcon.className = video.muted ? "fas fa-volume-mute" : "fas fa-volume-up";
  };

  // Set initial icon based on video state
  window.addEventListener('DOMContentLoaded', function() {
    audioIcon.className = video.muted ? "fas fa-volume-mute" : "fas fa-volume-up";
  });