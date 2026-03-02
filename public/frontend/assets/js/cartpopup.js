// ═══════════════════════════════════════════
//  __cartpopup.js — Complete Cart Popup JS
// ═══════════════════════════════════════════

function openProductPopup(btn) {
    const id       = btn.dataset.id;
    const name     = btn.dataset.name;
    const price    = btn.dataset.price;
    const image    = btn.dataset.image;
    const variants = JSON.parse(btn.dataset.variants || "[]");

    // ── Data সেট করুন ─────────────────────────────
    document.getElementById("popupImage").src         = image;
    document.getElementById("popupName").textContent  = name;
    document.getElementById("popupProductId").value   = id;
    document.getElementById("popupVariantId").value   = "";
    document.getElementById("popupQty").value         = 1;

    const variantSection = document.getElementById("popupVariantSection");
    const variantList    = document.getElementById("popupVariants");
    variantList.innerHTML = "";

    if (variants.length > 0) {
        variantSection.style.display = "block";

        variants.forEach((v, i) => {
            const btn2       = document.createElement("button");
            btn2.type        = "button";
            btn2.className   = "cp-variant-btn" + (i === 0 ? " active" : "");
            btn2.textContent = v.name;
            btn2.dataset.price = v.price;

            btn2.onclick = function () {
                document.querySelectorAll(".cp-variant-btn")
                    .forEach((b) => b.classList.remove("active"));
                btn2.classList.add("active");
                document.getElementById("popupVariantId").value = v.id;

                // ── Price + Total update ───────────
                updatePopupTotal();

                // ── Link update ────────────────────
                updateCartLink();
            };

            variantList.appendChild(btn2);

            setTimeout(() => {
                btn2.classList.add("cp-variant-visible");
            }, i * 60);
        });

        // প্রথম variant auto select
        document.getElementById("popupVariantId").value = variants[0].id;

        // Price প্রথম variant এর
        updatePopupTotal();

        // Link set করুন
        updateCartLink();

    } else {
        variantSection.style.display = "none";
        document.getElementById("popupVariantId").value = "";

        // Price product এর default price
        document.getElementById("popupPrice").textContent =
            "৳ " + parseFloat(price).toFixed(2);

        // Link set করুন
        updateCartLink();
    }

    // ── Popup Open ─────────────────────────────────
    const overlay = document.getElementById("cartPopupOverlay");
    const popup   = document.getElementById("cartPopup");

    overlay.style.display = "block";
    popup.style.display   = "flex";

    popup.getBoundingClientRect();
    overlay.classList.add("cp-active");
    popup.classList.remove("cp-closing");
    popup.classList.add("cp-open");

    document.body.style.overflow = "hidden";
}

// ── Popup Total Price Calculate ────────────────────
function updatePopupTotal() {
    const activeVariant = document.querySelector(".cp-variant-btn.active");
    const price = activeVariant
        ? parseFloat(activeVariant.dataset.price)
        : 0;

    const qty   = parseInt(document.getElementById("popupQty").value) || 1;
    const total = price * qty;

    // Price animate
    const priceEl = document.getElementById("popupPrice");
    priceEl.style.transform  = "scale(1.15)";
    priceEl.style.transition = "transform 0.2s ease";
    setTimeout(() => {
        priceEl.textContent     = "৳ " + total.toFixed(2);
        priceEl.style.transform = "scale(1)";
    }, 150);
}

// ── Cart Link Update ───────────────────────────────
function updateCartLink() {
    const productId = document.getElementById("popupProductId").value;
    const variantId = document.getElementById("popupVariantId").value;
    const qty       = document.getElementById("popupQty").value;
    const link      = document.getElementById("popupAddToCartLink");

    if (link && productId) {
        let href = "/cart/add?product_id=" + productId + "&qty=" + qty;
        if (variantId) {
            href += "&variant_id=" + variantId;
        }
        link.href = href;
    }
}

// ── Popup Qty Plus ─────────────────────────────────
document.getElementById("popupQtyPlus")?.addEventListener("click", function () {
    const input  = document.getElementById("popupQty");
    const newVal = parseInt(input.value) + 1;
    input.value  = newVal;

    // Price + Link update
    updatePopupTotal();
    updateCartLink();

    // Bounce
    input.style.transform  = "scale(1.15)";
    input.style.transition = "transform 0.15s ease";
    setTimeout(() => { input.style.transform = "scale(1)"; }, 150);
});

// ── Popup Qty Minus ────────────────────────────────
document.getElementById("popupQtyMinus")?.addEventListener("click", function () {
    const input  = document.getElementById("popupQty");
    const newVal = Math.max(1, parseInt(input.value) - 1);
    input.value  = newVal;

    // Price + Link update
    updatePopupTotal();
    updateCartLink();

    // Bounce
    input.style.transform  = "scale(1.15)";
    input.style.transition = "transform 0.15s ease";
    setTimeout(() => { input.style.transform = "scale(1)"; }, 150);
});

// ── Close Popup ────────────────────────────────────
function closePopup() {
    const overlay = document.getElementById("cartPopupOverlay");
    const popup   = document.getElementById("cartPopup");

    overlay.classList.remove("cp-active");
    popup.classList.remove("cp-open");
    popup.classList.add("cp-closing");

    setTimeout(() => {
        popup.style.display   = "none";
        overlay.style.display = "none";
        popup.classList.remove("cp-closing");
        document.body.style.overflow = "";
    }, 300);
}

// ── ESC key ───────────────────────────────────────
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closePopup();
});