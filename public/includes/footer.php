</main>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div class="f-brand">
      <span class="f-logo">PAKTJIP<span class="dot" aria-hidden="true"></span></span>
      <p>Stempel &amp; Digiprint — Temanggung, Jawa Tengah.</p>
      <p class="f-tag">“Nek Ora PAKTJIP Ora”</p>
    </div>
    <div class="f-col">
      <h4>Kontak</h4>
      <ul>
        <li><a href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya mau tanya-tanya dulu.')) ?>" target="_blank" rel="noopener">WhatsApp <?= e($s['no_whatsapp']) ?></a></li>
        <li><a href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></li>
        <li><?= e($s['instagram']) ?></li>
      </ul>
    </div>
    <div class="f-col">
      <h4>Katalog Resmi</h4>
      <ul>
        <li><a href="<?= e(wa_order_link($s['no_whatsapp'], 'Halo PakTjip, saya mau minta katalog lengkap.')) ?>" target="_blank" rel="noopener">Minta Katalog via WA</a></li>
        <li><a href="#katalog">Katalog di Website Ini</a></li>
      </ul>
    </div>
    <div class="f-col">
      <h4>Jam Operasional</h4>
      <ul>
        <li>Senin – Sabtu: 08.00 – 17.30</li>
        <li>Minggu: tutup</li>
      </ul>
    </div>
  </div>
  <div class="wrap footer-base">
    <span>© <?= date('Y') ?> CV PakTjip Digital Printing</span>
    <span>Terdaftar e-Procurement Nasional</span>
  </div>
</footer>
<script src="/assets/js/main.js" defer></script>
<button class="back-top" id="backTop" aria-label="Kembali ke atas"></button>
</body>
</html>
