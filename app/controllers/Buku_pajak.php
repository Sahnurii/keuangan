<?php

class Buku_pajak extends Controller
{
    protected $allowedRoles = ['Admin', 'Petugas', 'Pegawai', 'Pimpinan'];

    public function index()
    {
        $data['judul'] = 'Buku Pajak';

        // Ambil daftar bulan & tahun unik dari tabel transaksi_pajak
        $bulanTahun = $this->model('Pajak_model')->getUniqueMonthsAndYears();
        $groupedBulanTahun = [];
        foreach ($bulanTahun as $bt) {
            $groupedBulanTahun[$bt['tahun']][] = $bt['bulan'];
        }
        $data['bulan_tahun'] = $groupedBulanTahun;

        // Ambil bulan & tahun dari GET (atau default ke sekarang)
        $tahun = $_GET['tahun'] ?? date('Y');
        $bulan = $_GET['bulan'] ?? date('m');

        $raw = $this->model('Pajak_model')->getTransaksiPajakLengkap($bulan, $tahun);

        // GROUP per no_bukti
        $transaksiGroup = [];
        foreach ($raw as $row) {
            $no = $row['no_bukti'];
            if (!isset($transaksiGroup[$no])) {
                $transaksiGroup[$no] = [
                    'id' => $row['id'],
                    'tanggal' => $row['tanggal'],
                    'no_bukti' => $row['no_bukti'],
                    'keterangan' => $row['keterangan'],
                    'pajak' => [
                        'PPN' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh21' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh22' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh23' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                        'PPh 4(2)' => ['Pemasukan' => 0, 'Pengeluaran' => 0],
                    ]
                ];
            }

            $tipePajak = $row['tipe_pajak'];
            $tipeKat = $row['tipe_kategori'];
            if (isset($transaksiGroup[$no]['pajak'][$tipePajak][$tipeKat])) {
                $transaksiGroup[$no]['pajak'][$tipePajak][$tipeKat] += (float)$row['nilai_pajak'];
            }
        }

        // Ambil saldo awal untuk bulan dan tahun tertentu
        $saldoAwal = $this->model('Saldo_model')->getSaldoAwalByTipeBukuDanTanggal('Pajak', $bulan, $tahun);
        // print_r($saldoAwal);
        error_log(print_r($saldoAwal, true)); // Debug saldo_awal


        $saldo = $saldoAwal['saldo_awal'] ?? 0;

        foreach ($transaksiGroup as &$trx) {
            $totalPemasukan = 0;
            $totalPengeluaran = 0;

            foreach ($trx['pajak'] as $jenis => $nilai) {
                $totalPemasukan += $nilai['Pemasukan'];
                $totalPengeluaran += $nilai['Pengeluaran'];
            }

            $saldo += ($totalPemasukan - $totalPengeluaran);

            $trx['total_pemasukan'] = $totalPemasukan;
            $trx['total_pengeluaran'] = $totalPengeluaran;
            $trx['saldo'] = $saldo;
        }


        $data['transaksi'] = array_values($transaksiGroup);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        $this->view('templates/header', $data);
        $this->view('buku_pajak/index', $data);
        $this->view('templates/footer');
    }

    public function edit($id)
    {
        $data['Pajak'] = $this->model('Pajak_model')->getTransaksiById($id);
        $data['judul'] = 'Edit Pajak';

        $data['pemasukan'] = $this->model('Kategori_model')->getKategoriByTipe('Pemasukan');
        $data['pengeluaran'] = $this->model('Kategori_model')->getKategoriByTipe('Pengeluaran');

        $this->view('templates/header', $data);
        $this->view('buku_pajak/edit', $data);
        $this->view('templates/footer');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->model('Pajak_model')->editDataTransaksi($_POST) > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
                Flasher::setFlash('Ubah Data Berhasil', '', 'success');
                header('Location: ' . BASEURL . '/buku_pajak');
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data gagal diperbarui']);
                Flasher::setFlash('Ubah Data Gagal', '', 'error');
                header('Location: ' . BASEURL . '/buku_pajak');
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Metode tidak valid']);
        }
    }
}
