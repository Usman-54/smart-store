// @ts-nocheck
function addToCart(productId) {
    let form = document.getElementById(`cart-form-${productId}`);
    if (!form) return;

    let formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let badge = document.getElementById('cart-count');
            if (badge) badge.innerText = data.cartCount;

            console.log('Item added to cart');
        }
    })
    .catch(error => console.error('Error adding to cart:', error));
}

// as the function for cart sidebare and not releted to cart badjge
function loadMiniCart() {
    fetch('/cart/mini')
        .then(res => res.text())
        .then(html => {
            document.getElementById('mini-cart-items').innerHTML = html;
            updateMiniCartTotal();
        })
        .catch(err => console.error(err));
}

function updateMiniCartTotal() {
    let total = 0;
    document.querySelectorAll('#mini-cart-items .mini-cart-price').forEach(item => {
        total += parseFloat(item.dataset.total);
    });
    document.getElementById('mini-cart-total').innerText = total.toFixed(2);
}

// for Quantity update in mini cart
function updateQuantity(productId, change) {
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId, change: change })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            loadMiniCart();
            document.getElementById('cart-count').innerText = data.cartCount;
        }
    });
}
