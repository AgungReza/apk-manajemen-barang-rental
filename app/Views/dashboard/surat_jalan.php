<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Surat Jalan</h1>
    <p><strong>Nomor Transaksi:</strong> <?= $transaksi['transaksi_id']; ?></p>
    <p><strong>Nama Customer:</strong> <?= $customer['nama_customer']; ?></p>
    <p><strong>Tanggal Pinjam:</strong> <?= $transaksi['tanggal_keluar']; ?></p>
    <p><strong>Tanggal Kembali:</strong> <?= $transaksi['tanggal_kembali']; ?></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Id Barang</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($detail_barang as $barang): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $barang['barang_id']; ?></td>
                <td><?= $barang['nama_barang']; ?></td>
                <td>1</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
