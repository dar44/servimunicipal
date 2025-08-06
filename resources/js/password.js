
document.addEventListener("DOMContentLoaded", () => {
  const passwordInput = document.getElementById('password');
  const togglePassword = document.getElementById('togglePassword');
  const toggleIcon = document.getElementById('togglePasswordIcon');

  togglePassword.addEventListener("click", () => {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    toggleIcon.classList.toggle('bi-eye');
    toggleIcon.classList.toggle('bi-eye-slash');
  })
})