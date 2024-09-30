<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Bus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 220px;
            background-color: #003366;
            color: #fff;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 15px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #00509e;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            margin-bottom: 20px;
        }

        .btn-info,
        .btn-warning,
        .btn-success {
            border-radius: 4px;
        }

        .btn-info {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-info:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4 class="text-white">Dashboard</h4>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/report">Laporan</a>
        <a href="/bus_list">Data Bus</a>
        <a href="/terminal_statistics">Statistik Terminal</a>
        <a href="/logout">Logout</a>
    </div>

    <div class="content">
        <h1 class="mt-5">Tambah Bus</h1>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="/bus/store">
            <?= csrf_field() ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Formulir Tambah Bus</h5>
                    <div class="form-group">
                        <label for="tnkb">TNKB</label>
                        <input type="text" class="form-control" id="tnkb" name="tnkb" value="<?= old('tnkb') ?>"
                            placeholder="Masukkan TNKB" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_perusahaan">Nama Perusahaan</label>
                        <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                            value="<?= old('nama_perusahaan') ?>" placeholder="Masukkan Nama Perusahaan" required>
                    </div>
                    <div class="form-group">
                        <label for="trayek">Trayek</label>
                        <input type="text" class="form-control" id="trayek" name="trayek" value="<?= old('trayek') ?>"
                            placeholder="Masukkan Trayek" required>
                    </div>
                    <div class="form-group">
                        <label for="terminal_id">Terminal</label>
                        <select class="form-control" id="terminal_id" name="terminal_id" required>
                            <option value="" disabled selected>Pilih Terminal</option>
                            <?php foreach ($terminals as $terminal): ?>
                                <option value="<?= $terminal['id'] ?>" <?= old('terminal_id') == $terminal['id'] ? 'selected' : '' ?>><?= $terminal['nama_terminal'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/bus_list" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>