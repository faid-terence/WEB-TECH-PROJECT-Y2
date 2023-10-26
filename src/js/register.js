document.addEventListener("DOMContentLoaded", function () {
  const registrationForm = document.querySelector("form");
  registrationForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const fullName = document.getElementById("full-names").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirm-password").value;
    const gender = document.querySelector("input[name='gender']:checked").value;

    if (password !== confirmPassword) {
      alert("Password and confirmation password do not match.");
      return;
    }

    const apiUrl = "http://localhost:3000/auth/register";

    const data = {
      name: fullName,
      email: email,
      password: password,
      gender: gender,
    };

    fetch(apiUrl, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("User Created Successfully");
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
});
