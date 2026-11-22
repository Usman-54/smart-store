document.addEventListener("DOMContentLoaded", function () {
    const radios = document.querySelectorAll('input[name="payment_method"]');

    const cards = document.querySelectorAll(".method-card");
    const panels = document.querySelectorAll(".method-panel");
    const payButtonText = document.getElementById("payButtonText");
    // Card number formatting: 1234 5678 9012 3456
    const cardNumber = document.getElementById("card_number");
    const cardExpiry = document.getElementById("card_expiry");
    const cardCvv = document.getElementById("card_cvv");

    const bankInput = document.getElementById("bank_name");
    const bankPicker = document.getElementById("bankPicker");
    const bankTrigger = document.getElementById("bankPickerTrigger");
    const bankMenu = document.getElementById("bankPickerMenu");
    const bankCurrent = document.getElementById("bankPickerCurrent");

    const buttonLabels = {
        card: "Continue to secure payment",
        wallet: "Continue with mobile wallet",
        raast: "Continue with Raast",
        bank: "Continue with bank transfer",
    };

    function closeBankMenu() {
        if (!bankMenu || !bankTrigger) return;

        bankMenu.hidden = true;
        bankTrigger.setAttribute("aria-expanded", "false");
    }

    function updatePaymentMethod() {
        const selected = document.querySelector(
            'input[name="payment_method"]:checked',
        );

        if (!selected) return;

        cards.forEach(function (card) {
            const radio = card.querySelector('input[name="payment_method"]');

            card.classList.toggle("active", radio === selected);
        });

        panels.forEach(function (panel) {
            const active = panel.dataset.panel === selected.value;

            panel.hidden = !active;

            panel
                .querySelectorAll("input, select, textarea")
                .forEach(function (field) {
                    field.disabled = !active;
                });
        });

        if (bankTrigger) {
            bankTrigger.disabled = selected.value !== "bank";
        }

        if (payButtonText) {
            payButtonText.textContent =
                buttonLabels[selected.value] || "Continue";
        }

        closeBankMenu();
    }

    radios.forEach(function (radio) {
        radio.addEventListener("change", updatePaymentMethod);
    });

    // Format CNIC as 00000-0000000-0.
    document.querySelectorAll(".cnic-input").forEach(function (input) {
        input.addEventListener("input", function () {
            const digits = this.value.replace(/\D/g, "").slice(0, 13);

            let formatted = digits.slice(0, 5);

            if (digits.length > 5) {
                formatted += "-" + digits.slice(5, 12);
            }

            if (digits.length > 12) {
                formatted += "-" + digits.slice(12, 13);
            }

            this.value = formatted;
        });
    });
    if (cardNumber) {
        cardNumber.addEventListener("input", function () {
            const digits = this.value
                .replace(/\D/g, "")
                .slice(0, 19);

            this.value = digits.replace(/(.{4})/g, "$1 ").trim();
        });
    }

    // Expiry formatting: MM/YY
    if (cardExpiry) {
        cardExpiry.addEventListener("input", function () {
            const digits = this.value
                .replace(/\D/g, "")
                .slice(0, 4);

            this.value = digits.length > 2
                ? digits.slice(0, 2) + "/" + digits.slice(2)
                : digits;
        });
    }

    // CVV: digits only, up to four digits
    if (cardCvv) {
        cardCvv.addEventListener("input", function () {
            this.value = this.value
                .replace(/\D/g, "")
                .slice(0, 4);
        });
    }


    // Custom bank dropdown.
    if (bankPicker && bankInput && bankTrigger && bankMenu && bankCurrent) {
        function selectBank(option) {
            bankInput.value = option.dataset.value;
            bankCurrent.replaceChildren();

            // Display the selected bank's logo.
            const logo = document.createElement("img");
            logo.className = "bank-logo";
            logo.src = option.dataset.logo;
            logo.alt = "";

            const label = document.createElement("span");
            label.textContent = option.dataset.name;

            bankCurrent.append(logo, label);

            bankMenu.querySelectorAll(".bank-option").forEach(function (item) {
                item.setAttribute("aria-selected", String(item === option));
            });
        }

        bankTrigger.addEventListener("click", function () {
            if (bankTrigger.disabled) return;

            const willOpen = bankMenu.hidden;
            bankMenu.hidden = !willOpen;

            bankTrigger.setAttribute("aria-expanded", String(willOpen));
        });

        bankMenu.querySelectorAll(".bank-option").forEach(function (option) {
            option.addEventListener("click", function () {
                selectBank(this);
                closeBankMenu();
            });
        });

        document.addEventListener("click", function (event) {
            if (!bankPicker.contains(event.target)) {
                closeBankMenu();
            }
        });

        // Restore the selected bank after a validation error.
        const existingBank = Array.from(
            bankMenu.querySelectorAll(".bank-option"),
        ).find(function (option) {
            return option.dataset.value === bankInput.value;
        });

        if (existingBank) {
            selectBank(existingBank);
        }
    }

    // Initialize the selected payment method.
    updatePaymentMethod();

    // QR code modal
    const qrModal = document.getElementById("qrModal");
    const openQrModal = document.getElementById("openQrModal");
    const closeQrModal = document.getElementById("closeQrModal");

    function closeQrDialog() {
        if (!qrModal) return;

        qrModal.hidden = true;
        document.body.classList.remove("qr-modal-open");

        if (openQrModal) {
            openQrModal.focus();
        }
    }

    if (qrModal && openQrModal && closeQrModal) {
        openQrModal.addEventListener("click", function () {
            qrModal.hidden = false;
            document.body.classList.add("qr-modal-open");
            closeQrModal.focus();
        });

        closeQrModal.addEventListener("click", closeQrDialog);

        qrModal.querySelectorAll("[data-close-qr]").forEach(function (element) {
            element.addEventListener("click", closeQrDialog);
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape" && !qrModal.hidden) {
                closeQrDialog();
            }
        });
    }
});

    

    