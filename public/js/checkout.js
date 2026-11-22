
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('checkoutForm');
    const codRadio = document.getElementById('payment_cod');
    const payfastRadio = document.getElementById('payment_payfast');
    const completeOrderBtn = document.getElementById('completeOrderBtn');
    const payNowBtn = document.getElementById('payNowBtn');

    if (!form || !codRadio || !payfastRadio ||
        !completeOrderBtn || !payNowBtn) {
        return;
    }

    function updatePaymentButtons() {
        completeOrderBtn.hidden = !codRadio.checked;
        payNowBtn.hidden = !payfastRadio.checked;
    }

    codRadio.addEventListener('change', updatePaymentButtons);
    payfastRadio.addEventListener('change', updatePaymentButtons);

    form.addEventListener('submit', function (event) {
        if (!codRadio.checked) {
            event.preventDefault();
            return;
        }

        if (!form.reportValidity()) {
            event.preventDefault();
            return;
        }

        completeOrderBtn.disabled = true;
        completeOrderBtn.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin me-2"></i>Processing...';
    });

    payNowBtn.addEventListener('click', function () {
        if (!form.reportValidity()) {
            return;
        }

        window.location.href = payNowBtn.dataset.url;
    });

    updatePaymentButtons();
});
