<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Terminal</title>
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

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                box-shadow: none;
            }

            .content {
                margin-left: 0;
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
        <h1 class="my-4">Statistik Terminal</h1>

        <form method="get" action="/terminal_statistics" class="mb-3">
            <select name="terminal" id="terminal" class="form-control">
                <option value="">Pilih Terminal</option>
                <?php foreach ($terminals as $terminal): ?>
                    <option value="<?= $terminal['id']; ?>" <?= ($selectedTerminal == $terminal['id']) ? 'selected' : ''; ?>>
                        <?= $terminal['nama_terminal']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Tampilkan Statistik</button>
        </form>

        <?php if ($selectedTerminal): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Detail Terminal</h5>
                    <p><strong>Nama Terminal:</strong>
                        <?= $terminals[array_search($selectedTerminal, array_column($terminals, 'id'))]['nama_terminal'] ?>
                    </p>
                    <p><strong>Lokasi Terminal:</strong>
                        <?= $terminals[array_search($selectedTerminal, array_column($terminals, 'id'))]['lokasi'] ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Bus</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>TNKB</th>
                            <th>Nama Perusahaan</th>
                            <th>Trayek</th>
                            <th>Terminal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($busData)): ?>
                            <?php foreach ($busData as $bus): ?>
                                <tr>
                                    <td><?= esc($bus['tnkb']); ?></td>
                                    <td><?= esc($bus['nama_perusahaan']); ?></td>
                                    <td><?= esc($bus['trayek']); ?></td>
                                    <td>
                                        <?php
                                        // Temukan nama terminal berdasarkan terminal_id
                                        $namaTerminal = '';
                                        foreach ($terminals as $terminal) {
                                            if ($terminal['id'] == $bus['terminal_id']) {
                                                $namaTerminal = $terminal['nama_terminal'];
                                                break;
                                            }
                                        }
                                        echo esc($namaTerminal);
                                        ?>
                                    </td>
                                    <td><?= esc($bus['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data bus yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($selectedTerminal): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistik untuk
                        <?= $terminals[array_search($selectedTerminal, array_column($terminals, 'id'))]['nama_terminal'] ?>
                    </h5>
                    <p>Total Bus: <?= $terminalStatistics['total_buses'] ?? 'Data tidak tersedia'; ?></p>
                    <p>Total Penumpang Naik di Terminal:
                        <?= $terminalStatistics['total_passengers_in'] ?? 'Data tidak tersedia'; ?>
                    </p>
                    <p>Total Penumpang Turun di Terminal:
                        <?= $terminalStatistics['total_passengers_out'] ?? 'Data tidak tersedia'; ?>
                    </p>

                    <div class="chart-container">
                        <canvas id="terminalStatsChart"></canvas>
                    </div>
                    <script>
                        var ctx = document.getElementById('terminalStatsChart').getContext('2d');
                        var chart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Total Penumpang Naik di Terminal', 'Total Penumpang Turun di Terminal'],
                                datasets: [{
                                    label: 'Statistik Penumpang Terminal',
                                    data: [<?= $terminalStatistics['total_passengers_in'] ?? 0 ?>, <?= $terminalStatistics['total_passengers_out'] ?? 0 ?>],
                                    backgroundColor: ['#007bff', '#28a745'],
                                    borderColor: ['#0056b3', '#218838'],
                                    borderWidth: 2,
                                    borderRadius: 10,
                                    hoverBackgroundColor: ['rgba(0, 123, 255, 0.7)', 'rgba(40, 167, 69, 0.7)'],
                                    hoverBorderColor: ['rgba(0, 86, 179, 1)', 'rgba(25, 135, 84, 1)']
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
                                            text: 'Kategori',
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
                                            text: 'Jumlah',
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
            </div>
        <?php endif; ?>
    </div>
</body>

</html>