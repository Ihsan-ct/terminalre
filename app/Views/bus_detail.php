<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Bus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styling tambahan */
        .badge-primary {
            background-color: #007bff;
        }
        .badge-secondary {
            background-color: #6c757d;
        }
        .card-header {
            background-color: #343a40;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <!-- Header dengan Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Dashboard Pengelolaan Data Terminal Transportasi</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/admin/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/report">Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/bus_list">Daftar Bus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Container untuk Detail Bus -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Detail Bus</h3>
                    </div>
                    <div class="card-body">
                        <!-- Detail Informasi Bus -->
                        <table class="table table-bordered">
                            <tr>
                                <th>TNKB</th>
                                <td><?= esc($bus['tnkb']) ?></td>
                            </tr>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <td><?= esc($bus['nama_perusahaan']) ?></td>
                            </tr>
                            <tr>
                                <th>Trayek</th>
                                <td><?= esc($bus['trayek']) ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge <?= esc($bus['status']) === 'di_terminal' ? 'badge-primary' : 'badge-secondary' ?>">
                                        <?= esc($bus['status']) === 'di_terminal' ? 'Di Terminal' : 'Di Jalan' ?>
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <!-- Riwayat Keberangkatan -->
                        <h4 class="mt-4">Riwayat Keberangkatan</h4>
                        <?php if (!empty($history)): ?>
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Waktu Keberangkatan</th>
                                        <th>Jumlah Penumpang</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history as $record): ?>
                                        <tr>
                                            <td><?= esc($record['departure_time']) ?></td>
                                            <td><?= esc($record['number_of_passengers']) ?></td>
                                            <td>
                                                <span class="badge <?= esc($record['status']) === 'di_terminal' ? 'badge-primary' : 'badge-secondary' ?>">
                                                    <?= esc($record['status']) === 'di_terminal' ? 'Di Terminal' : 'Di Jalan' ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>Riwayat keberangkatan tidak tersedia.</p>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer text-right">
                        <a href="/admin/dashboard" class="btn btn-primary">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Dashboard Pengelolaan Data Terminal Transportasi. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
