const loginForm = document.getElementById("loginForm");
const errorElement = document.getElementById("error");

loginForm.addEventListener("submit", (event) => {
    event.preventDefault(); // Prevent default form submission

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Basic validation (replace with actual authentication logic)
    if (username === "user" && password === "password") {
        // Successful login
        alert("Login successful!");
        // Redirect to the intended page or perform other actions
    } else {
        // Invalid credentials
        errorElement.textContent = "Invalid username or password.";
    }
});
