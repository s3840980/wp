// Function to handle dropdown navigation
function navigateToPage(page) {
    if (page) {
        window.location.href = page;
    }
}

// Function to confirm deletion
function confirmDeletion() {
    return confirm("Are you sure you want to delete this item?");
}

// Validation for Add Pet form
function validateAddPetForm() {
    const petName = document.getElementById("petName").value;
    const petType = document.getElementById("petType").value;
    const description = document.getElementById("petDescription").value;
    const age = document.getElementById("petAge").value;
    const location = document.getElementById("petLocation").value;
    const image = document.getElementById("petImage").value;

    if (!petName || !petType || !description || !age || !location || !image) {
        alert("Please fill in all required fields.");
        return false;
    }

    if (age <= 0) {
        alert("Please enter a valid age for the pet.");
        return false;
    }

    return true;
}

// Form validation for registration
function validateRegistrationForm() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (!username || !password || !confirmPassword) {
        alert("All fields are required.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}

// Initialize carousel functionality if present on the page
document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".carousel");
    if (carousel) {
        // Automatically cycle the carousel every 5 seconds
        carousel.carousel({
            interval: 5000
        });
    }

    // Attach form validation if Add Pet form is present
    const addForm = document.querySelector(".pet-form");
    if (addForm) {
        addForm.onsubmit = validateAddPetForm;
    }

    // Attach form validation if Registration form is present
    const registrationForm = document.querySelector("#registration-form");
    if (registrationForm) {
        registrationForm.onsubmit = validateRegistrationForm;
    }

    // Add delete confirmation if Delete button is present
    const deleteButtons = document.querySelectorAll(".delete-button");
    deleteButtons.forEach(button => {
        button.onclick = confirmDeletion;
    });
});
