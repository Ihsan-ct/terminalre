<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Kedatangan Bus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            width: 100%;
            font-size: 1.1rem;
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

            h1 {
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
        <h1>Formulir Kedatangan Bus</h1>

        <!-- Tampilkan pesan error dari server jika ada -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('errors') ?>
            </div>
        <?php endif; ?>

        <!-- Tampilkan pesan sukses jika ada -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="/bus/saveArrival" method="post" id="arrivalForm">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= esc($departure['id']) ?>">
            <input type="hidden" name="bus_id" value="<?= esc($departure['bus_id']) ?>">

            <!-- Waktu Kedatangan -->
            <div class="form-group">
                <label for="arrival_time">Waktu Kedatangan</label>
                <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" required>
                <span id="arrival_time_error" class="error-message"></span>
            </div>

            <!-- Jumlah Penumpang Keluar -->
            <div class="form-group">
                <label for="number_of_passengers_out">Jumlah Penumpang Keluar</label>
                <input type="number" class="form-control" id="number_of_passengers_out" name="number_of_passengers_out"
                    required min="0">
                <span id="number_of_passengers_out_error" class="error-message"></span>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Kedatangan</button>
        </form>
    </div>

    <script>
        // Validasi form sebelum dikirim
        document.getElementById('arrivalForm').addEventListener('submit', function (e) {
            let valid = true;

            const arrivalTime = document.getElementById('arrival_time').value;
            const numberOfPassengersOut = document.getElementById('number_of_passengers_out').value;

            // Reset error messages
            document.getElementById('arrival_time_error').textContent = '';
            document.getElementById('number_of_passengers_out_error').textContent = '';

            // Validasi waktu kedatangan
            if (!arrivalTime) {
                document.getElementById('arrival_time_error').textContent = 'Waktu kedatangan harus diisi.';
                valid = false;
            }

            // Validasi jumlah penumpang keluar
            if (numberOfPassengersOut < 0) {
                document.getElementById('number_of_passengers_out_error').textContent = 'Jumlah penumpang tidak boleh kurang dari 0.';
                valid = false;
            }

            if (!valid) {
                e.preventDefault(); // Batalkan submit jika validasi gagal
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>