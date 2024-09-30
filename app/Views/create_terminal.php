<!DOCTYPE html>
<html>
<head>
    <title>Tambah Terminal</title>
</head>
<body>
    <h1>Tambah Terminal</h1>
    <form action="<?= site_url('terminals/store') ?>" method="post">
        <label for="nama_terminal">Nama Terminal:</label>
        <input type="text" id="nama_terminal" name="nama_terminal" required><br>
        <label for="lokasi">Lokasi:</label>
        <input type="text" id="lokasi" name="lokasi" required><br>
        <button type="submit">Tambah</button>
    </form>
</body>
</html>
