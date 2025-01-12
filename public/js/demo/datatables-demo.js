$(document).ready(function () {
  $('#dataTable').DataTable({
    "pageLength": 10,
    "lengthMenu": [10, 25, 50, 100, 300, 500], 
    "stateSave": true

  });
});
