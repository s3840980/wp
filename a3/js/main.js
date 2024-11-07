function validateAddPetForm() {
    const petName = document.getElementById("petname").value;
    const petType = document.getElementById("type").value;
    const description = document.getElementById("description").value;
    const age = document.getElementById("age").value;
    const location = document.getElementById("location").value;
    const image = document.getElementById("image").value;

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


document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".carousel-item");
    let currentIndex = 0;

    function showSlide(index) {
        items.forEach((item, i) => {
            item.classList.toggle("active", i === index);
        });
    }

    document.querySelector(".carousel-control-next").addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % items.length;
        showSlide(currentIndex);
    });

    document.querySelector(".carousel-control-prev").addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        showSlide(currentIndex);
    });

    showSlide(currentIndex);
});
