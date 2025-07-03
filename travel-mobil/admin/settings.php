<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function isAdmin() {
    return isset($_SESSION['admin_id']);
}

if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';
include '../includes/header.php';

// Proses penyimpanan saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
        $stmt->execute([$value, $key]);
    }
    $success = true;
}

// ✅ Ambil data pengaturan (2 kolom saja agar FETCH_KEY_PAIR tidak error)
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // bentuk: ['key' => 'value']
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Pengaturan Sistem</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success">Pengaturan berhasil disimpan.</div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="form-control" value="<?= htmlspecialchars($settings['nama_perusahaan'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>No. WhatsApp</label>
            <input type="text" name="no_whatsapp" class="form-control" value="<?= htmlspecialchars($settings['no_whatsapp'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Alamat Kantor</label>
            <input type="text" name="alamat_kantor" class="form-control" value="<?= htmlspecialchars($settings['alamat_kantor'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Jam Operasional</label>
            <input type="text" name="jam_operasional" class="form-control" value="<?= htmlspecialchars($settings['jam_operasional'] ?? '') ?>">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
