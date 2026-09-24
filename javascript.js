document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("registrationForm");
    const phone = document.getElementById("phone");
    const message = document.getElementById("message");

    // Allow only numbers in the phone field
    phone.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, "");
    });

    form.addEventListener("submit", function (event) {
        const phoneNumber = phone.value.trim();

        if (phoneNumber.length !== 10) {
            event.preventDefault();
            message.textContent = "Please enter a valid 10-digit phone number.";
            message.style.color = "red";
            return;
        }

        message.textContent = "Submitting registration...";
        message.style.color = "green";
    });

    form.addEventListener("reset", function () {
        message.textContent = "";
    });
});
