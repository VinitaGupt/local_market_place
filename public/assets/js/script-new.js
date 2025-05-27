document.addEventListener("DOMContentLoaded", function () {
    openModal(); // Show modal when the page loads
});

let confettiInterval;

function openModal() {
    document.getElementById("modal").classList.add("show");
    startConfetti();
}

function closeModal() {
    document.getElementById("modal").classList.remove("show");
    clearInterval(confettiInterval);
}

function startConfetti() {
    const modal = document.querySelector(".modal__content");

    confettiInterval = setInterval(() => {
        for (let i = 0; i < 10; i++) {
            let confetti = document.createElement("div");
            confetti.classList.add("confetti");

            let confettiTypes = ["circle", "square", "ribbon"];
            let colors = ["red", "blue", "yellow", "green", "purple", "orange", "pink", "cyan"];

            confetti.classList.add(confettiTypes[Math.floor(Math.random() * confettiTypes.length)]);
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];

            let isLeft = Math.random() > 0.5;
            confetti.style.left = isLeft ? "5px" : "calc(100% - 10px)";
            confetti.style.bottom = "0px";

            confetti.style.setProperty("--dirX", isLeft ? "1" : "-1");
            confetti.style.setProperty("--dirY", (Math.random() * 0.5 + 0.5).toString());
            confetti.style.animationDuration = (Math.random() * 2.5 + 1) + "s";
            confetti.style.width = confetti.style.height = Math.random() * 10 + 6 + "px";

            modal.appendChild(confetti);
            setTimeout(() => confetti.remove(), 2500);
        }
    }, 400);

    setTimeout(() => clearInterval(confettiInterval), 2500);
}