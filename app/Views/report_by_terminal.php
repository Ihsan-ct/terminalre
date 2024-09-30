<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keberangkatan Bus Berdasarkan Terminal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    /* Include your CSS styling here */
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
                <h1>Laporan Keberangkatan Bus Berdasarkan Terminal</h1>
            </div>
            <div class="card-body">
                <!-- Formulir Filter Terminal -->
                <form method="get" action="<?= site_url('report/reportByTerminal') ?>" class="mb-3">
                    <div class="form-group">
                        <label for="terminal_id">Pilih Terminal</label>
                        <select class="form-control" id="terminal_id" name="terminal_id" required>
                            <option value="" disabled selected>Pilih Terminal</option>
                            <?php foreach ($terminals as $terminal): ?>
                            <option value="<?= $terminal['id'] ?>"><?= esc($terminal['nama_terminal']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
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