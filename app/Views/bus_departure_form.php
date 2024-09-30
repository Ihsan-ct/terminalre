<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Keberangkatan Bus - Dinas Perhubungan Sumbar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 120px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
        }

        @media (max-width: 576px) {
            .container {
                padding: 15px;
            }

            .header img {
                width: 100px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .btn-primary {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="/assets/dishub.jpg" alt="Dinas Perhubungan Sumbar Logo">
            <h1 class="mt-3">Atur Keberangkatan Bus</h1>
        </div>
        <form method="post" action="/bus/saveDeparture" id="departureForm">
            <input type="hidden" name="bus_id" value="<?= esc($bus_id) ?>">
            <input type="hidden" name="status" id="status" value="di_terminal">

            <!-- Tampilkan Informasi Bus -->
            <div class="form-group">
                <label>TNKB:</label>
                <p><?= esc($bus['tnkb']) ?></p>
            </div>

            <div class="form-group">
                <label>Trayek:</label>
                <p><?= esc($bus['trayek']) ?></p>
            </div>

            <!-- Terminal otomatis terisi berdasarkan bus yang dipilih -->
            <div class="form-group">
                <label>Terminal:</label>
                <p><?= esc($terminal['nama_terminal']) ?></p>
                <input type="hidden" name="terminal_id" value="<?= esc($terminal['id']) ?>">
            </div>

            <!-- Waktu Keberangkatan -->
            <div class="form-group">
                <label for="departure_time">Waktu Keberangkatan:</label>
                <input type="datetime-local" id="departure_time" name="departure_time" class="form-control"
                    aria-required="true" required>
                <span id="departure_time_error" class="error-message"></span>
            </div>

            <!-- Jumlah Penumpang -->
            <div class="form-group">
                <label for="number_of_passengers">Jumlah Penumpang:</label>
                <input type="number" id="number_of_passengers" name="number_of_passengers" class="form-control"
                    aria-required="true" required min="0">
                <span id="number_of_passengers_error" class="error-message"></span>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-primary">Simpan Keberangkatan</button>
        </form>
    </div>

    <script>
        // Fungsi untuk mengupdate status berdasarkan waktu keberangkatan
        function updateStatus() {
            const departureTime = document.getElementById('departure_time').value;
            const statusField = document.getElementById('status');

            if (departureTime) {
                const departureDateTime = new Date(departureTime);
                const currentTime = new Date();

                // Jika waktu sekarang lebih dari waktu keberangkatan, ubah status menjadi 'berangkat'
                if (currentTime >= departureDateTime) {
                    statusField.value = 'berangkat';
                } else {
                    statusField.value = 'di_terminal';
                }
            }
        }

        // Validasi form sebelum dikirim
        document.getElementById('departureForm').addEventListener('submit', function (e) {
            let valid = true;
            const departureTime = document.getElementById('departure_time').value;
            const numberOfPassengers = document.getElementById('number_of_passengers').value;

            // Reset error messages
            document.getElementById('departure_time_error').textContent = '';
            document.getElementById('number_of_passengers_error').textContent = '';

            // Validasi waktu keberangkatan
            if (!departureTime) {
                document.getElementById('departure_time_error').textContent = 'Waktu keberangkatan harus diisi.';
                valid = false;
            }

            // Validasi jumlah penumpang
            if (numberOfPassengers < 0) {
                document.getElementById('number_of_passengers_error').textContent = 'Jumlah penumpang tidak boleh kurang dari 0.';
                valid = false;
            }

            if (!valid) {
                e.preventDefault(); // Batalkan submit jika validasi gagal
            } else {
                updateStatus(); // Pastikan status diperbarui sebelum submit
            }
        });

        // Cek status secara berkala (misalnya setiap 10 detik)
        setInterval(updateStatus, 10000);
    </script>
</body>

</html>