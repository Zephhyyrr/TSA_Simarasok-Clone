document.getElementById('togglePassword').addEventListener('click', function (e) {
    const passwordInput = document.getElementById('floatingPassword');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    this.querySelector('i').classList.toggle('fa-eye');
    this.querySelector('i').classList.toggle('fa-eye-slash');
});
