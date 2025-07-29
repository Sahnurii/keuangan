 <!-- Footer -->
 <footer class="sticky-footer bg-white">
     <div class="container my-auto">
         <div class="copyright text-center my-auto">
             <span>Copyright &copy; Keuangan Politeknik Batulicin</span>
         </div>
     </div>
 </footer>
 <!-- End of Footer -->

 </div>
 <!-- End of Content Wrapper -->

 </div>
 <!-- End of Page Wrapper -->

 <!-- Scroll to Top Button-->
 <a class="scroll-to-top rounded" href="#page-top">
     <i class="fas fa-angle-up"></i>
 </a>

 <!-- Logout Modal-->
 <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Ingin Logout?</h5>
                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
             </div>
             <div class="modal-body">Pilih “Logout” di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
             <div class="modal-footer">
                 <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                 <a class="btn btn-primary" href="<?= BASEURL; ?>/auth/logout">Logout</a>
             </div>
         </div>
     </div>
 </div>

 <!-- Bootstrap core JavaScript-->
 <script src="<?= BASEURL; ?>/vendor/jquery/jquery.min.js"></script>

 <!-- Select2 JS -->
 <script src="<?= BASEURL ?>/js/select2.min.js"></script>

 <script src="<?= BASEURL; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

 <!-- Core plugin JavaScript-->
 <script src="<?= BASEURL; ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

 <!-- Custom scripts for all pages-->
 <script src="<?= BASEURL; ?>/js/sb-admin-2.min.js"></script>

 <!-- Page level plugins -->
 <script src="<?= BASEURL; ?>/vendor/chart.js/Chart.min.js"></script>

 <!-- Page level custom scripts -->
 <!-- <script src="<?= BASEURL; ?>/js/demo/chart-area-demo.js"></script> -->
 <!-- <script src="<?= BASEURL; ?>/js/demo/chart-pie-demo.js"></script> -->


 <!-- Page level plugins -->
 <script src="<?= BASEURL; ?>/vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= BASEURL; ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

 <!-- Page level custom scripts -->
 <script src="<?= BASEURL; ?>/js/demo/datatables-demo.js"></script>
 <script src="<?= BASEURL; ?>/js/dist/sweetalert2.all.min.js"></script>
 <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $_ENV['MIDTRANS_CLIENT_KEY']; ?>"></script>

 <script src="<?= BASEURL; ?>/js/script.js"></script>
 <script type="text/javascript">
     window.onload = function() {
         jam();
     }

     function jam() {
         var e = document.getElementById('jam'),
             d = new Date(),
             h, m, s;
         h = d.getHours();
         m = set(d.getMinutes());
         s = set(d.getSeconds());

         e.innerHTML = h + ':' + m + ':' + s;

         setTimeout('jam()', 1000);
     }

     function set(e) {
         e = e < 10 ? '0' + e : e;
         return e;
     }
 </script>
 <!-- <script>
     $(document).ready(function() {
         $('.select2').select2({
             placeholder: '-- Pilih --',
             allowClear: true,
             width: '100%'
         });
     });
 </script> -->
 <script>
     $(document).ready(function() {
         // Inisialisasi Select2
         $('.select2').select2({
             placeholder: "-- Pilih --",
             width: '100%',
             allowClear: true
         });

         // Change listener untuk No Bukti Transaksi (Pakai jQuery, bukan native)
         if ($('#no_bukti_transaksi').length > 0) {
             $('#no_bukti_transaksi').on('change', function() {
                 const transaksiId = $(this).val();

                 if (!transaksiId) return;

                 fetch(`<?= BASEURL; ?>/transaksi/getNominalById/${transaksiId}`)
                     .then(response => response.json())
                     .then(data => {
                         if (data && data.nominal !== undefined && data.nominal !== null) {
                             $('#nominal_pajak').val(data.nominal);
                             hitungPajak();
                         } else {
                             $('#nominal_pajak').val('');
                             $('#nilai_pajak').val('');
                         }
                     })
                     .catch(error => {
                         console.error('Gagal fetch nominal transaksi:', error);
                     });
             });
         }
         // Hitung pajak saat jenis pajak berubah
         if ($('#id_jenis_pajak').length > 0) {
             $('#id_jenis_pajak').on('change', hitungPajak);
         }

         function hitungPajak() {
             const tarif = parseFloat($('#id_jenis_pajak option:selected').data('tarif') || 0);
             const nominal = parseFloat($('#nominal_pajak').val() || 0);
             const pajak = (nominal * tarif / 100).toFixed(2);
             $('#nilai_pajak').val(pajak);
         }
     });
  
 </script>
 </body>

 </html>