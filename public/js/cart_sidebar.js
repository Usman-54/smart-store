
(() => {
    const drawer = document.getElementById('mini-cart');
    const overlay = document.getElementById('cartOverlay');

    let previousFocus = null;

    // Mini-cart open/close functionality
    if (drawer && overlay) {
        window.openMiniCart = function () {
            previousFocus = document.activeElement;

            drawer.classList.add('open');
            overlay.classList.add('show');

            drawer.setAttribute('aria-hidden', 'false');
            overlay.setAttribute('aria-hidden', 'false');

            document.body.classList.add('cart-open');
            drawer.focus();
        };

        window.closeMiniCart = function () {
            drawer.classList.remove('open');
            overlay.classList.remove('show');

            drawer.setAttribute('aria-hidden', 'true');
            overlay.setAttribute('aria-hidden', 'true');

            document.body.classList.remove('cart-open');

            if (previousFocus && typeof previousFocus.focus === 'function') {
                previousFocus.focus();
            }
        };

        overlay.addEventListener('click', window.closeMiniCart);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && drawer.classList.contains('open')) {
                window.closeMiniCart();
            }
        });
    }

    // Automatic cart quantity updates
    document.addEventListener('click', async function (event) {
        const button = event.target.closest(
            '.cart-qty-minus, .cart-qty-plus'
        );

        if (!button) return;

        const quantityBox = button.closest('.cart-quantity-form');
        if (!quantityBox || button.disabled) return;

        const input = quantityBox.querySelector('.cart-quantity-input');
        const updateUrl = quantityBox.dataset.updateUrl;

        if (!input || !updateUrl) {
            console.error('Quantity input or update URL is missing.', {
                inputFound: !!input,
                updateUrl
            });
            return;
        }

        const currentQuantity = Number(input.value) || 1;
        const isPlus = button.classList.contains('cart-qty-plus');

        // const newQuantity = isPlus
        //     ? Math.min(99, currentQuantity + 1)
        //     : Math.max(1, currentQuantity - 1);

        // if (newQuantity === currentQuantity) return;
        

// Remove the item when minus is clicked at quantity 1
        if (!isPlus && currentQuantity === 1) {
            const removeUrl = quantityBox.dataset.removeUrl;

            if (!removeUrl) {
                console.error('Remove URL is missing.');
                return;
            }

            const token = quantityBox.querySelector(
                'input[name="_token"]'
            )?.value;

            button.disabled = true;

            try {
                const response = await fetch(removeUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        _method: 'DELETE'
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Could not remove item.');
                }

                // Refresh the sidebar to show the updated cart
                window.location.reload();

            } catch (error) {
                console.error(error);
                alert(error.message || 'Unable to remove item.');
                button.disabled = false;
            }

            return;
        }

        const newQuantity = isPlus
            ? Math.min(99, currentQuantity + 1)
            : Math.max(1, currentQuantity - 1);

        if (newQuantity === currentQuantity) return;


        const token = quantityBox.querySelector(
            'input[name="_token"]'
        )?.value;

        if (!token) {
            console.error('CSRF token not found.');
            return;
        }

        // Prevent repeated clicks while saving
        const buttons = quantityBox.querySelectorAll('.cart-qty-btn');
        buttons.forEach(btn => btn.disabled = true);

        try {
            const response = await fetch(updateUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    quantity: newQuantity
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Could not update cart.');
            }

            // Update the quantity and item subtotal
            if (data.quantity === undefined) {
                console.error('Quantity missing from Laravel response:', data);
                return;
            }

            input.value = data.quantity;

            const item = quantityBox.closest('.cart-item');
            const subtotal = item.querySelector('.cart-item-subtotal');

            if (subtotal) {
                subtotal.textContent = Number(data.itemSubtotal)
                    .toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
            }

            // Update the cart-wide subtotal and item count
            document.querySelectorAll('[data-cart-subtotal]')
                .forEach(element => {
                    element.textContent = Number(data.cartSubtotal)
                        .toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                });

            document.querySelectorAll('[data-cart-count]')
                .forEach(element => {
                    element.textContent = data.cartCount;
                });

        } catch (error) {
            console.error(error);
            alert(error.message || 'Unable to update cart.');
        } finally {
            buttons.forEach(btn => btn.disabled = false);
        }
    });
})();
