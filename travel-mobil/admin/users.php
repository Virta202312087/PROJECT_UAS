<?php
session_start();

// Tambahkan fungsi isAdmin untuk pengecekan akses
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

// Proteksi akses halaman jika bukan admin
if (!isAdmin()) {
    header("Location: login.php");
    exit();
}

include '../includes/header.php';
?>
<div class="container">
    <h1>Manajemen Pengguna</h1>
    <!-- Tampilkan tabel pengguna di sini -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once '../config/database.php';
            $stmt = $pdo->query("SELECT id, username, role FROM users");

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                echo "<td>
                        <a href='edit_user.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                        <a href='delete_user.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?>
