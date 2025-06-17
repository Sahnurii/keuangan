<?php
class Error extends Controller
{
    public function forbidden()
    {
        echo "<h1>403 - Akses Ditolak</h1><p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>";
    }
}
