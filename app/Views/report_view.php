<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keberangkatan Bus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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

        .card-header {
            background-color: #003366;
            color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #003366;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 4px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            border-radius: 4px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
            }

            .content {
                margin-left: 0;
            }

            .sidebar a {
                display: inline-block;
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .table thead th {
                font-size: 12px;
            }

            .table td,
            .table th {
                font-size: 10px;
            }

            .btn-sm {
                font-size: 12px;
                padding: 4px 8px;
            }
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
        <div class="card">
            <div class="card-header">
                <h1>Laporan Keberangkatan Bus</h1>
            </div>
            <div class="card-body">
                <!-- Tombol Kembali ke Dashboard -->
                <a href="<?= site_url('/admin/dashboard') ?>" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                <!-- Tombol Ekspor ke CSV -->
                <a href="<?= site_url('report/generate?terminal=' . esc($selectedTerminal)) ?>"
                    class="btn btn-primary mb-3">
                    <i class="fas fa-file-csv"></i> Ekspor ke CSV
                </a>

                <!-- Filter Berdasarkan Terminal -->
                <form method="get" action="<?= site_url('report/filterByTerminal') ?>" class="mb-3">
                    <div class="form-group">
                        <label for="terminal">Filter Berdasarkan Terminal:</label>
                        <select name="terminal" id="terminal" class="form-control">
                            <option value="">Semua Terminal</option>
                            <?php foreach ($terminals as $terminal): ?>
                                <option value="<?= $terminal['id'] ?>" <?= $terminal['id'] == $selectedTerminal ? 'selected' : '' ?>>
                                    <?= esc($terminal['nama_terminal']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </form>

                <!-- Tabel Data -->
                <?php if (!empty($dailyReport)): ?>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>TNKB</th>
                                <th>Trayek</th>
                                <th>Waktu Keberangkatan</th>
                                <th>Jumlah Penumpang Masuk</th>
                                <th>Waktu Kedatangan</th>
                                <th>Jumlah Penumpang Keluar</th>
                                <th>Nama Terminal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($dailyReport as $report): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($report['tnkb']) ?></td>
                                    <td><?= esc($report['trayek']) ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($report['departure_time'])) ?></td>
                                    <td><?= esc($report['number_of_passengers']) ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($report['arrival_time'])) ?></td>
                                    <td><?= esc($report['number_of_passengers_out']) ?></td>
                                    <td><?= esc($report['nama_terminal']) ?></td>
                                    <td><?= esc($report['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Tidak ada laporan yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>