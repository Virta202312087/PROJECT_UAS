$(document).ready(function () {
    function updateHarga() {
        const service_id = $('#serviceSelect').val();
        const route_id = $('#routeSelect').val();
        const posisi = $('#posisiSelect').val();

        if (!service_id || !route_id) {
            $('#hargaField').val('');
            return;
        }

        // Kirim permintaan ke get_price.php
        $.post('get_price.php', {
            service_id: service_id,
            route_id: route_id,
            posisi: posisi
        }, function (data) {
            $('#hargaField').val(data);
        });
    }

    function updateFieldVisibility() {
        const selected = $('#serviceSelect').val();

        // Sembunyikan semuanya terlebih dahulu
        $('#posisiGroup').hide();
        $('#fotoBarangGroup').hide();
        $('#posisiSelect').val('');
        $('#hargaField').val('');

        // Tampilkan field khusus sesuai layanan
        if (selected === '3') {
            $('#posisiGroup').show(); // Reguler
        } else if (selected === '4') {
            $('#fotoBarangGroup').show(); // Cargo
        }
    }

    // Saat layanan berubah
    $('#serviceSelect').on('change', function () {
        updateFieldVisibility(); // Perbarui field posisi/foto
        updateHarga();           // Langsung cek harga
    });

    // Saat rute atau posisi duduk berubah
    $('#routeSelect, #posisiSelect').on('change', function () {
        updateHarga();
    });

    // Opsional: autofocus ke jam setelah pilih tanggal
    $('#tanggal').on('change', function () {
        $('#jam').focus();
    });

    // Batasi tanggal minimal hari ini
    const today = new Date().toISOString().split("T")[0];
    $('#tanggal').attr('min', today);
});
