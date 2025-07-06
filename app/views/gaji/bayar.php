<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Pembayaran Gaji</h3>
        </div>
        <div class="card-body text-center">
            <p>Nama Pegawai: <?= $data['gaji']['nama'] ?></p>
            <p>Total Gaji: <strong><?= uang_indo($data['total']); ?></strong></p>

            <button id="pay-button" class="btn btn-success mt-3">Bayar Sekarang</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function() {
         snap.pay("<?= $data['snap_token'] ?>", {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                console.log(result);
                window.location.href = "<?= BASEURL ?>/gaji";
            },
            onPending: function(result) {
                alert("Pembayaran dalam proses.");
                console.log(result);
            },
            onError: function(result) {
                alert("Pembayaran gagal.");
                console.log(result);
            },
            onClose: function() {
                alert("Anda menutup jendela pembayaran.");
            }
        });
    });
</script>