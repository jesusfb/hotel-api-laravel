<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
<body>
    <h1>Wikusama hotel</h1>
    <h1>Halo {{ $nama_tamu }}</h1>
    <h5>Berikut adalah detail dari pesanan anda: </h5>
    <p>Kode pesanan anda: {{ $id_transaksi }}</p>
    <p>Tanggal Check-in: {{ $tanggal_checkin }}</p>
    <p>Tanggal Check-out: {{ $tanggal_checkout }}</p>
    <p>Jumlah Kamar: {{ $jumlah_kamar }}</p>
    <p>Total Harga: {{ $harga }}</p>
</body>
</html>