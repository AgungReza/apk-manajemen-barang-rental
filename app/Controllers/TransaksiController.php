<?php

namespace App\Controllers;

class TransaksiController extends BaseController
{
    public function index()
    {
        // Menampilkan view 'transaksi/form_transaksi'
        return view('dashboard/formpinjam');
    }
}
