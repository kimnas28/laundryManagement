const openBtn = document.getElementById("openLogin");
const popup = document.querySelector(".form-popup");
const closeBtn = document.querySelector(".close-btn");

openBtn.addEventListener("click", (e) => {
    e.preventDefault();
    popup.style.display = "block";
});

closeBtn.addEventListener("click", () => {
    popup.style.display = "none";
});

document.addEventListener('DOMContentLoaded', function () {
   
    const togglePassword = document.querySelector('.toggle-password');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
    });

    
document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        const trimmedData = data.trim();
        console.log("Server response (trimmed):", `"${trimmedData}"`);
        if (trimmedData.toLowerCase() === "success") {
            window.location.href = 'mainpage.php';
        } else {
            document.getElementById("errorMsg").innerText = trimmedData;
        }
    })
    .catch(err => {
        console.error('Error during login:', err);
    });
});

});


  


