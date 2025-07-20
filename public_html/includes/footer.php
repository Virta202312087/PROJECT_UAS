<footer class="bg-white text-center border-top mt-5 py-4 shadow-sm">
  <div class="container">
    <p class="mb-2 text-muted">
      &copy; <?= date('Y') ?> <strong>Travel Mobil</strong>. All rights reserved.
    </p>
    <div>
      <a href="#" class="text-muted me-3"><i class="fab fa-facebook"></i></a>
      <a href="#" class="text-muted me-3"><i class="fab fa-instagram"></i></a>
      <a href="#" class="text-muted"><i class="fab fa-whatsapp"></i></a>
    </div>
  </div>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional Custom JS -->
<script>
  const script = document.createElement("script");
  script.src = "/assets/js/scripts.js";
  script.onerror = () => console.warn("⚠️ Custom script not found.");
  document.body.appendChild(script);
</script>

</body>
</html>
