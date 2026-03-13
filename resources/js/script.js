// Create floating particles
function createParticles() {
    const container = document.getElementById("particles-container");
    const particleCount = 50;

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement("div");
        particle.classList.add("particle");

        // Random position
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;

        // Random size
        const size = Math.random() * 4 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;

        // Random animation delay
        particle.style.animationDelay = `${Math.random() * 15}s`;

        // Random animation duration
        const duration = Math.random() * 10 + 10;
        particle.style.animationDuration = `${duration}s`;

        container.appendChild(particle);
    }
}

// Countdown timer
function updateCountdown() {
    const reunionDate = new Date("December 21, 2150 18:00:00").getTime();
    const now = new Date().getTime();
    const timeLeft = reunionDate - now;

    // Calculate days, hours, minutes, seconds
    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
        (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
    );
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    // Update display
    document.getElementById("days").textContent = days
        .toString()
        .padStart(2, "0");
    document.getElementById("hours").textContent = hours
        .toString()
        .padStart(2, "0");
    document.getElementById("minutes").textContent = minutes
        .toString()
        .padStart(2, "0");
    document.getElementById("seconds").textContent = seconds
        .toString()
        .padStart(2, "0");
}

// Mobile menu toggle
document.getElementById("menu-toggle").addEventListener("click", function () {
    document.getElementById("main-nav").classList.toggle("active");
});

// Form submission
document
    .getElementById("registration-form")
    .addEventListener("submit", function (e) {
        e.preventDefault();

        // Get form values
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;

        // In a real application, you would send this data to a server
        // For now, we'll show an alert
        alert(
            `Thank you ${name}! Your registration for REUNION 2150 has been received. A neural confirmation has been sent to ${email}.`,
        );

        // Reset form
        document.getElementById("registration-form").reset();
    });

// Smooth scrolling for navigation links
document.querySelectorAll("nav a").forEach((link) => {
    link.addEventListener("click", function (e) {
        e.preventDefault();

        const targetId = this.getAttribute("href");
        const targetSection = document.querySelector(targetId);

        window.scrollTo({
            top: targetSection.offsetTop - 80,
            behavior: "smooth",
        });

        // Close mobile menu if open
        document.getElementById("main-nav").classList.remove("active");
    });
});

// Initialize page elements
window.addEventListener("DOMContentLoaded", function () {
    createParticles();
    updateCountdown();

    // Update countdown every second
    setInterval(updateCountdown, 1000);

    // Add scroll effect to header
    window.addEventListener("scroll", function () {
        const header = document.querySelector("header");
        if (window.scrollY > 100) {
            header.style.background = "rgba(5, 5, 16, 0.9)";
            header.style.backdropFilter = "blur(10px)";
        } else {
            header.style.background = "transparent";
            header.style.backdropFilter = "none";
        }
    });
});
