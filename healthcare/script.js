document.querySelector("#know-more").addEventListener("click", function(e) {
    e.preventDefault();

    const targetId = this.getAttribute("href").substring(1); // Get the target ID
    const target = document.getElementById(targetId); // Find the target element by ID

    if (target) {
        target.scrollIntoView({ behavior: "smooth" });
    }
});

// Function to open the popup
function openPopup() {
    document.querySelector('.popup-container').style.display = 'block';
}

// Function to close the popup
function closePopup() {
    document.querySelector('.popup-container').style.display = 'none';
}