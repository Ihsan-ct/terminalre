<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Bus</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

        .container {
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

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        .table thead th {
            background-color: #003366;
            color: #fff;
            cursor: pointer;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .btn-info,
        .btn-warning,
        .btn-danger {
            border-radius: 4px;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
            }

            .container {
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
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Bus</h1>

        <!-- Tombol Tambah Bus -->
        <a href="/bus/create" class="btn btn-primary mb-3">Tambah Bus Baru</a>
        <a href="/bus/export" class="btn btn-info mb-3">Ekspor ke CSV</a>

        <!-- Pencarian dan Filter -->
        <div class="form-group mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari bus...">
        </div>

        <div class="form-group mb-4">
            <select id="terminalFilter" class="form-control">
                <option value="">Semua Terminal</option>
                <?php foreach ($terminals as $terminal): ?>
                    <option value="<?= htmlspecialchars($terminal['nama_terminal']) ?>">
                        <?= htmlspecialchars($terminal['nama_terminal']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tabel Data Bus -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th data-sort="index">No</th>
                            <th data-sort="tnkb">TNKB</th>
                            <th data-sort="nama_perusahaan">Nama Perusahaan</th>
                            <th data-sort="trayek">Trayek</th>
                            <th data-sort="terminal">Terminal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($buses)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data bus</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($buses as $index => $bus): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($bus['tnkb']) ?></td>
                                    <td><?= htmlspecialchars($bus['nama_perusahaan']) ?></td>
                                    <td><?= htmlspecialchars($bus['trayek']) ?></td>
                                    <td><?= htmlspecialchars($bus['nama_terminal']) ?></td>
                                    <td>
                                        <a href="/bus/edit/<?= $bus['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/bus/delete/<?= $bus['id'] ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus bus ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $current_page - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $current_page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Pencarian
        document.getElementById('searchInput').addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(filter));
                row.style.display = match ? '' : 'none';
            });
        });

        // Sorting
        document.querySelectorAll('thead th[data-sort]').forEach(th => {
            th.addEventListener('click', function () {
                const sortField = this.getAttribute('data-sort');
                const table = this.closest('table');
                const rows = Array.from(table.querySelectorAll('tbody tr'));

                const sortedRows = rows.sort((a, b) => {
                    const aText = a.querySelector(`td:nth-child(${this.cellIndex + 1})`).textContent.trim();
                    const bText = b.querySelector(`td:nth-child(${this.cellIndex + 1})`).textContent.trim();

                    return aText.localeCompare(bText, undefined, { numeric: true });
                });

                table.querySelector('tbody').append(...sortedRows);
            });
        });

        // Pencarian dan Filter Berdasarkan Terminal
        document.getElementById('searchInput').addEventListener('input', filterRows);
        document.getElementById('terminalFilter').addEventListener('change', filterRows);

        function filterRows() {
            const searchText = document.getElementById('searchInput').value.toLowerCase();
            const selectedTerminal = document.getElementById('terminalFilter').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const busInfoMatch = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchText));
                const terminalMatch = selectedTerminal === "" || cells[4].textContent.toLowerCase() === selectedTerminal;

                // Hanya tampilkan baris jika ada kecocokan dengan teks pencarian dan terminal
                row.style.display = busInfoMatch && terminalMatch ? '' : 'none';
            });
        }

    </script>

</body>

</html>