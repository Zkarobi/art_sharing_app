document.addEventListener("DOMContentLoaded", () => {
    console.log("Login validation script is loaded."); // Debugging

    const form = document.querySelector("form"); // Target the form
    const errorContainer = document.querySelector(".errors"); // Error container
    const errorList = errorContainer.querySelector("ul");

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
        const password = document.getElementById("password").value;

        // Validate username
        if (!username) {
            errors.push("Username is required.");
        }

        // Validate password
        if (!password) {
            errors.push("Password is required.");
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
