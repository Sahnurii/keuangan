// Call the dataTables jQuery plugin
$(document).ready(function () {
  $('#dataTable').DataTable({
    "pageLength": 10, // Jumlah item yang ditampilkan per halaman
    "lengthMenu": [10, 25, 50, 100, 300,] // Opsi yang tersedia untuk jumlah item


  });
});
