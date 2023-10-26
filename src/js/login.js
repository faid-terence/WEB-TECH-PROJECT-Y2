document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector("form");
  loginForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const apiUrl = "http://localhost:3000/auth/login";
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
      .then((response) => {
        console.log("Response:", response);
        return response.json();
      })
      .then((data) => {
        console.log("Data:", data);

        if (data && data.success) {
          window.location.href = "src/pages/StudentDashboard.html";
        } else if (data && data.message) {
          alert(data.message);
        } else {
          alert("Unknown error occurred.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while processing your request.");
      });
  });
});
