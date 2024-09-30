<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keberangkatan Bus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header,
        footer {
            background-color: #003366;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }

        h1,
        h2 {
            margin: 20px 0;
            color: #ffffff;
        }

        .container {
            width: 100%;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        @media print {
            .container {
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            footer {
                position: absolute;
                bottom: 0;
                width: 100%;
            }

            @page {
                margin: 20mm;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Dinas Perhubungan Provinsi Sumatera Barat</h1>
        <h2>Laporan Keberangkatan Bus</h2>
    </header>

    <div class="container">
        <h2>Semua Laporan</h2>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">TNKB</th>
                    <th scope="col">Waktu Keberangkatan</th>
                    <th scope="col">Waktu Kedatangan</th>
                    <th scope="col">Jumlah Penumpang Masuk</th>
                    <th scope="col">Jumlah Penumpang Keluar</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dailyReport as $report): ?>
                    <tr>
                        <td><?= esc($report['id']) ?></td>
                        <td><?= esc($report['tnkb']) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime(esc($report['departure_time']))) ?></td>
                        <td><?= date('d-m-Y H:i', strtotime(esc($report['arrival_time']))) ?></td>
                        <td><?= esc($report['number_of_passengers']) ?></td>
                        <td><?= esc($report['number_of_passengers_out']) ?></td>
                        <td><?= esc($report['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer>
        &copy; <?= date('Y') ?> Dinas Perhubungan Provinsi Sumatera Barat
    </footer>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
