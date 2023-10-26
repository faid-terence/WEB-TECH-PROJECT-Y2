
document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector("form");
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const apiUrl = "http://localhost:3000/auth/login";

    // Create a data object to send with the POST request
    const data = {
      email: email,
      password: password,
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
        // Handle the response from the server
        if (data.success) {
          // Successful login, you can redirect or perform other actions here
          window.location.href = "./StudentDashboard.html";
        } else {
          // Display an error message or take appropriate action
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
});
