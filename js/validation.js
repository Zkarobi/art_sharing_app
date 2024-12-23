document.addEventListener("DOMContentLoaded", () => {
    console.log("Validation script is loaded."); // Debugging

    const form = document.querySelector("form"); // Target the form
    const errorContainer = document.querySelector(".errors"); // Error container
    const errorList = errorContainer ? errorContainer.querySelector("ul") : null;

    if (!form) {
        console.error("Form element not found!");
        return;
    }
    if (!errorContainer) {
        console.error(".errors container not found!");
        return;
    }
    if (!errorList) {
        console.error("Error list <ul> inside .errors container not found!");
        return;
    }

    form.addEventListener("submit", (event) => {
        console.log("Submit button clicked"); // Debugging

        // Clear previous errors
        errorList.innerHTML = "";

        let errors = [];

        // Retrieve form values
        const username = document.getElementById("username").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        // Validate username
        if (username.length < 3) {
            errors.push("Username must be at least 3 characters long.");
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errors.push("Please enter a valid email address.");
        }

        // Validate password
        if (password.length < 6) {
            errors.push("Password must be at least 6 characters long.");
        }

        // Validate confirm password
        if (password !== confirmPassword) {
            errors.push("Passwords do not match.");
        }

        // Display errors
        if (errors.length > 0) {
            event.preventDefault(); // Stop form submission
            console.log("Validation errors:", errors); // Debugging

            // Append error messages to the errorList
            errors.forEach((error) => {
                const li = document.createElement("li");
                li.textContent = error;
                errorList.appendChild(li);
            });

            // Ensure the error container is visible
            errorContainer.style.display = "block";
        } else {
            console.log("Form submission passed validation!");
        }
    });
});
