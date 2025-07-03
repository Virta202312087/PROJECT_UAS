<footer class="bg-white text-center border-top mt-5 py-4 shadow-sm">
    <div class="container">
        <p class="mb-0 text-muted">
            &copy; <?= date('Y') ?> <strong>Travel Mobil</strong>. All rights reserved.
        </p>
    </div>
</footer>

<!-- Bootstrap Bundle (dengan Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-XnA+H89x1I0K8X5DBNcz0N3c8+8U4DPXkMKMT68ZFevX7XYa2vO5Z5puyjWZnIUV"
        crossorigin="anonymous"></script>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a2f1b79d5e.js" crossorigin="anonymous"></script>

<!-- JavaScript Lokal (jika tersedia) -->
<?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/travel-mobil/assets/js/scripts.js")): ?>
<script src="/travel-mobil/assets/js/scripts.js"></script>
<?php endif; ?>
</body>
</html>
