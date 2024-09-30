<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        .table thead th {
            background-color: #003366;
            color: #fff;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
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

            .table thead th {
                font-size: 14px;
            }

            .table td,
            .table th {
                font-size: 12px;
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

            /* Card hover effect */
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

            /* Table responsive */
            .table-responsive-sm {
                overflow-x: auto;
            }

            /* Grafik responsif */
            #busChart {
                max-width: 100%;
            }

            /* Tooltip */
            .tooltip-inner {
                background-color: #333;
                color: #fff;
            }

            /* Card shadow effect */
            .card.shadow-lg {
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }

            /* Card hover effect */
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
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
        <h1 class="mt-5">Admin Dashboard</h1>
        <form method="get" action="/admin/dashboard" class="mb-3">
            <!-- Dropdown untuk memilih bus -->
            <select name="search" class="form-control">
                <option value="">Pilih Bus</option>
                <?php foreach ($busList as $bus): ?>
                    <option value="<?= $bus['tnkb'] ?>" <?= $bus['tnkb'] == $search ? 'selected' : '' ?>>
                        <?= esc($bus['tnkb']) ?> - <?= esc($bus['trayek']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Dropdown untuk memilih status bus -->
            <select name="status" class="form-control mt-2">
                <option value="">Semua Status</option>
                <option value="di_terminal" <?= $status === 'di_terminal' ? 'selected' : '' ?>>Di Terminal</option>
                <option value="berangkat" <?= $status === 'berangkat' ? 'selected' : '' ?>>Di Jalan</option>
            </select>

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-primary mt-2">Cari</button>
        </form>

        <!-- Data Bus -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Bus</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-responsive-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>TNKB</th>
                            <th>Nama Perusahaan</th>
                            <th>Trayek</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($buses as $key => $bus): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= esc($bus['tnkb']) ?></td>
                                <td><?= esc($bus['nama_perusahaan']) ?></td>
                                <td><?= esc($bus['trayek']) ?></td>
                                <td>
                                    <span
                                        class="badge <?= esc($bus['status']) === 'di_terminal' ? 'badge-primary' : 'badge-secondary' ?>">
                                        <?= esc($bus['status']) === 'di_terminal' ? 'Di Terminal' : 'Di Jalan' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/dashboard/showBus/<?= $bus['id'] ?>" class="btn btn-info btn-sm"
                                        data-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <?php if ($bus['status'] === 'di_terminal'): ?>
                                        <a href="/bus/departure/<?= $bus['id'] ?>" class="btn btn-warning btn-sm"
                                            data-toggle="tooltip" title="Atur Keberangkatan">
                                            <i class="fas fa-bus"></i> Atur Keberangkatan
                                        </a>
                                    <?php else: ?>
                                        <a href="/bus/returnToTerminal/<?= $bus['id'] ?>" class="btn btn-success btn-sm"
                                            data-toggle="tooltip" title="Kembali ke Terminal">
                                            <i class="fas fa-undo-alt"></i> Kembali ke Terminal
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <?= $pager->links() ?>
                </div>
            </div>
        </div>


        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>

        <!-- Statistik -->
        <div class="card shadow-lg mb-4"
            style="border-radius: 15px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.2); transition: transform 0.3s ease, box-shadow 0.3s ease;">
            <div class="card-body">
                <h5 class="card-title font-weight-bold text-uppercase" style="letter-spacing: 1px; color: #333;">
                    Statistik Bus</h5>
                <div class="row">
                    <!-- Jumlah Bus di Terminal -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box mr-3 bg-primary text-white rounded-circle d-flex justify-content-center align-items-center shadow"
                                style="width: 60px; height: 60px; background: linear-gradient(145deg, #6a11cb, #2575fc);">
                                <i class="fas fa-bus fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark">Bus di Terminal</h6>
                                <h3 class="mb-0 text-primary">
                                    <?= isset($stats['di_terminal']) ? number_format($stats['di_terminal']) : 'N/A' ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!-- Jumlah Bus Berangkat -->
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-box mr-3 bg-success text-white rounded-circle d-flex justify-content-center align-items-center shadow"
                                style="width: 60px; height: 60px; background: linear-gradient(145deg, #43e97b, #38f9d7);">
                                <i class="fas fa-road fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold text-dark">Bus Berangkat</h6>
                                <h3 class="mb-0 text-success">
                                    <?= isset($stats['berangkat']) ? number_format($stats['berangkat']) : 'N/A' ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .card:hover {
                transform: translateY(-10px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

            .icon-box {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .icon-box i {
                font-size: 1.5rem;
            }

            .card-title {
                color: #333;
                margin-bottom: 20px;
            }

            .font-weight-bold {
                font-weight: 700;
            }

            .text-dark {
                color: #333;
            }

            .text-primary {
                color: #007bff;
            }

            .text-success {
                color: #28a745;
            }
        </style>




        <!-- Pastikan Anda memuat font-awesome untuk ikon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

        <!-- Grafik Jumlah Bus -->
        <div class="card shadow-lg mb-4"
            style="border-radius: 15px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.2);">
            <div class="card-body">
                <h5 class="card-title font-weight-bold text-uppercase" style="letter-spacing: 1px;">Grafik Jumlah Bus
                </h5>
                <canvas id="busChart"></canvas>
            </div>
        </div>

        <script>
            var ctxBus = document.getElementById('busChart').getContext('2d');
            var busChart = new Chart(ctxBus, {
                type: 'bar',
                data: {
                    labels: ['Di Terminal', 'Berangkat'],
                    datasets: [{
                        label: 'Jumlah Bus',
                        data: [<?= isset($stats['di_terminal']) ? $stats['di_terminal'] : 0 ?>, <?= isset($stats['berangkat']) ? $stats['berangkat'] : 0 ?>],
                        backgroundColor: [
                            'rgba(102, 126, 234, 0.5)', // Warna untuk 'Di Terminal'
                            'rgba(118, 75, 162, 0.5)' // Warna untuk 'Berangkat'
                        ],
                        borderColor: [
                            'rgba(102, 126, 234, 1)', // Border warna untuk 'Di Terminal'
                            'rgba(118, 75, 162, 1)' // Border warna untuk 'Berangkat'
                        ],
                        borderWidth: 2,
                        borderRadius: 10,
                        barThickness: 50,
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.9)',
                        hoverBorderColor: 'rgba(54, 162, 235, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce'
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Status Bus',
                                color: '#333',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Bus',
                                color: '#333',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        </script>


    </div>
</body>

</html>