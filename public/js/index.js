
// @ts-nocheck
// index.js

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.product-card').forEach(card => {
    const origStr = card.getAttribute('data-original');
    const saleStr = card.getAttribute('data-sale');
    const orig = parseFloat(origStr || "0");
    const sale = parseFloat(saleStr || "0");
    const badge = card.querySelector('.discount-badge');
    const origEl = card.querySelector('.original');
    const saleEl = card.querySelector('.final');

    if (!badge) {
      // no badge element, nothing to do
    } else if (isNaN(orig) || isNaN(sale) || orig <= sale) {
      badge.style.display = 'none';
    } else {
      const pct = Math.round((1 - sale / orig) * 100);
      badge.textContent = `-${pct}%`;
    }

    if (origEl) {
      if (!isNaN(orig)) origEl.textContent = `$${orig.toFixed(2)}`;
      else origEl.textContent = '';
    }
    if (saleEl) {
      if (!isNaN(sale)) saleEl.textContent = `$${sale.toFixed(2)}`;
      else saleEl.textContent = '';
    }
  });
});
