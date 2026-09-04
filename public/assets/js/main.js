/* PAKTJIP landing — hours, nav, filter, calculator, reveal */
(function () {
  "use strict";

  /* live open/closed badge (Asia/Jakarta assumed — shop local time) */
  document.querySelectorAll("[data-open-state]").forEach((el) => {
    if (!el.dataset.hours) return;
    try {
      var jam = JSON.parse(el.dataset.hours);
      var days = ["minggu", "senin", "selasa", "rabu", "kamis", "jumat", "sabtu"];
      var d = new Date();
      var today = days[d.getDay()];
      var range = jam[today] || (today !== "minggu" ? jam["senin-sabtu"] : null);
      var dot = el.querySelector(".dot");
      var label = el.textContent.trim();
      if (!range || range === "tutup") return; // PHP already rendered closed state
      var m = /^(\d{1,2}):(\d{2})\s*-\s*(\d{1,2}):(\d{2})$/.exec(range);
      if (!m) return;
      var now = d.getHours() * 60 + d.getMinutes();
      var open = parseInt(m[1], 10) * 60 + parseInt(m[2], 10);
      var close = parseInt(m[3], 10) * 60 + parseInt(m[4], 10);
      var isOpen = now >= open && now < close;
      if (dot) dot.classList.toggle("on", isOpen);
      if (dot) dot.classList.toggle("off", !isOpen);
      if (!isOpen && el.textContent.indexOf("Tutup") === -1) {
        el.textContent = "Tutup — buka " + m[1] + ":" + m[2];
        if (dot) el.prepend(dot);
      }
    } catch (e) { /* keep server-rendered state */ }
  });

  /* mobile nav */
  var toggle = document.querySelector(".nav-toggle");
  var menu = document.getElementById("navmenu");
  if (toggle && menu) {
    toggle.addEventListener("click", function () {
      var open = menu.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", String(open));
    });
    menu.addEventListener("click", function (e) {
      if (e.target.tagName === "A") {
        menu.classList.remove("is-open");
        toggle.setAttribute("aria-expanded", "false");
      }
    });
  }

  /* katalog filter */
  var chips = document.querySelectorAll(".chip");
  var cards = document.querySelectorAll(".prod-card");
  var emptyNote = document.querySelector(".empty-note");
  chips.forEach(function (chip) {
    chip.addEventListener("click", function () {
      chips.forEach(function (c) {
        c.classList.remove("is-active");
        c.setAttribute("aria-selected", "false");
      });
      chip.classList.add("is-active");
      chip.setAttribute("aria-selected", "true");
      var f = chip.dataset.filter;
      var visible = 0;
      cards.forEach(function (card) {
        var show = f === "all" || card.dataset.cat === f;
        card.classList.toggle("is-hidden", !show);
        if (show) visible++;
      });
      if (emptyNote) emptyNote.hidden = visible > 0;
    });
  });
  document.querySelectorAll("[data-cat-link]").forEach(function (a) {
    a.addEventListener("click", function () {
      var slug = a.dataset.catLink;
      var chip = document.querySelector('.chip[data-filter="' + slug + '"]');
      if (chip) chip.click();
    });
  });

  /* calculator */
  var calc = document.getElementById("calc");
  if (calc) {
    var prod = document.getElementById("calc-prod");
    var size = document.getElementById("calc-size");
    var custom = document.getElementById("calc-custom");
    var fieldSize = document.getElementById("field-size");
    var fieldCustom = document.getElementById("field-custom");
    var qty = document.getElementById("calc-qty");
    var total = document.getElementById("calc-total");
    var note = document.getElementById("calc-note");
    var wa = document.getElementById("calc-wa");

    function fmt(n) {
      return "Rp" + Math.round(n).toLocaleString("id-ID");
    }
    function current() {
      var parts = prod.value.split("|"); // name|m2?|price
      var isM2 = parts[1] === "m2";
      var unit = parseFloat(parts[2]);
      var n = parseInt(qty.value, 10) || 1;
      var amount = unit * n;
      var detail = parts[0].replace("banner", "Banner FL280gr");
      if (isM2) {
        var m2 = size.value === "custom" ? parseFloat(custom.value) || 0 : parseFloat(size.value);
        amount = unit * m2 * n;
        detail = "Banner FL280gr " + m2 + " m²";
      }
      return { amount: amount, detail: detail, n: n, isM2: isM2 };
    }
    function render() {
      var c = current();
      total.textContent = c.amount > 0 ? fmt(c.amount) : "—";
      note.textContent = c.isM2 ? "*Cetak saja, belum termasuk pemasangan." : "*Belum termasuk ongkir.";
      var msg =
        "Halo PakTjip, saya mau order " +
        c.detail +
        (c.n > 1 ? " x" + c.n : "") +
        ". Estimasi dari website: " +
        fmt(c.amount) +
        ". Mohon konfirmasi harga finalnya.";
      wa.href = "https://wa.me/6282137215808?text=" + encodeURIComponent(msg);
    }
    function syncFields() {
      var isM2 = prod.value.split("|")[1] === "m2";
      fieldSize.hidden = !isM2;
      fieldCustom.hidden = !isM2 || size.value !== "custom";
      render();
    }
    [prod, size, custom, qty].forEach(function (el) {
      el.addEventListener("change", syncFields);
      el.addEventListener("input", syncFields);
    });
    syncFields();
  }

  /* back to top */
  var backTop = document.getElementById("backTop");
  if (backTop) {
    var lastY = 0;
    window.addEventListener("scroll", function () {
      var y = window.scrollY;
      if (y > 500 && y < lastY) backTop.classList.add("show");
      else backTop.classList.remove("show");
      lastY = y;
    }, { passive: true });
    backTop.addEventListener("click", function () { window.scrollTo({ top: 0, behavior: "smooth" }); });
  }

  if ("IntersectionObserver" in window) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) {
            en.target.classList.add("is-in");
            io.unobserve(en.target);
          }
        });
      },
      { threshold: 0.12 }
    );
    document.querySelectorAll(".reveal").forEach(function (el) {
      io.observe(el);
    });
  } else {
    document.querySelectorAll(".reveal").forEach(function (el) {
      el.classList.add("is-in");
    });
  }
})();
