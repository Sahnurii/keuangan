document.addEventListener('DOMContentLoaded', () => {
    const flashDataElement = document.querySelector('.flash-data');
    const flashData = JSON.parse(flashDataElement.getAttribute('data-flashdata'));

    if (flashData && flashData.pesan) {
        Swal.fire({
            title: flashData.pesan,
            text: flashData.aksi,
            icon: flashData.tipe,
            confirmButtonText: 'OK'
        });
    }
});

$('.tombol-hapus').on('click', function (e) {

    e.preventDefault();
    const href = $(this).attr('href');
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus Data!"
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = href;
        }
    });
});

$('.tombol-status').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');
    const status = $(this).data('status');
    const pesan = (status === 'aktif') ? 'Nonaktifkan pegawai ini?' : 'Aktifkan kembali pegawai ini?';

    Swal.fire({
        title: 'Konfirmasi',
        text: pesan,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = href;
        }
    });
});
