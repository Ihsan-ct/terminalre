<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD PENGELOLAAN TERMINAL   </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url(/assets/1.jpg) no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.6);
            /* Warna putih dengan lebih banyak transparansi */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 20px;
            text-align: center;
        }

        .site-title {
            margin-bottom: 20px;
            color: #003366;
            /* Warna biru tua untuk judul */
            font-size: 18px;
        }

        h1 {
            color: #003366;
            /* Warna biru tua untuk header */
            margin-top: 10px;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
            height: auto;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #003366;
            /* Warna biru tua untuk tombol */
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #002d72;
            /* Warna biru yang lebih gelap untuk hover */
        }

        p {
            color: #dc3545;
            /* Warna merah untuk pesan error */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="site-title">
            Dashboard Pengelolaan Data Terminal Transportasi
        </div>
        <div class="logo">
            <img src="/assets/dishub.jpg" alt="Logo Dinas Perhubungan Sumatera Barat">
        </div>
        <h1>Login</h1>
        <form action="/authenticate" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>

        <?php if (session()->getFlashdata('error')): ?>
            <p><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>
    </div>
</body>

</html>
