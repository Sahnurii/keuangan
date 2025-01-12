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




// document.getElementById('yourButtonId').addEventListener('click', function() {
//     fetch('<?= BASEURL; ?>/core/flasher') // Path ke fungsi flash Anda
//         .then(response => response.json())
//         .then(data => {
//             console.log(data);
//             if (data.pesan) {
// Swal.fire({
//     title: data.pesan,
//     text: data.aksi,
//     icon: data.tipe,
//     confirmButtonText: 'OK'
// });
//             }
//         });
// });