<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bus</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Bus</h1>
    <table>
        <thead>
            <tr>
                <th>TNKB</th>
                <th>Nama Perusahaan</th>
                <th>Trayek</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($buses as $bus): ?>
            <tr>
                <td><?= esc($bus['tnkb']) ?></td>
                <td><?= esc($bus['nama_perusahaan']) ?></td>
                <td><?= esc($bus['trayek']) ?></td>
                <td><?= $bus['status'] === 'di_terminal' ? 'Di Terminal' : 'Di Jalan' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
