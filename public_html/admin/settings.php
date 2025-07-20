<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../config/database.php';

// Fungsi validasi admin
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';

// Proses penyimpanan form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        foreach ($_POST as $key => $value) {
            // Bersihkan input (jika perlu tambahkan validasi khusus per field)
            $value = trim($value);
            $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
            $stmt->execute([$value, $key]);
        }
        $success = true;
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

// Ambil semua pengaturan (key-value)
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $settings = [];
    $error = $e->getMessage();
}
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">⚙️ Pengaturan Sistem</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success">✅ Pengaturan berhasil disimpan.</div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger">❌ Gagal menyimpan: <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>🏢 Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" value="<?= htmlspecialchars($settings['nama_perusahaan'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>📞 No. WhatsApp</label>
            <input type="text" name="no_whatsapp" class="form-control" value="<?= htmlspecialchars($settings['no_whatsapp'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>📍 Alamat Kantor</label>
            <input type="text" name="alamat_kantor" class="form-control" value="<?= htmlspecialchars($settings['alamat_kantor'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>🕐 Jam Operasional</label>
            <input type="text" name="jam_operasional" class="form-control" value="<?= htmlspecialchars($settings['jam_operasional'] ?? '') ?>">
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Pengaturan</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
