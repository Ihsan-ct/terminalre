<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bus</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Edit Bus</h1>
        <form method="post" action="/bus/update/<?= $bus['id'] ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="tnkb">TNKB</label>
                <input type="text" class="form-control" id="tnkb" name="tnkb" value="<?= $bus['tnkb'] ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nama_perusahaan">Nama Perusahaan</label>
                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="<?= $bus['nama_perusahaan'] ?>" required>
            </div>
            <div class="form-group">
                <label for="trayek">Trayek</label>
                <input type="text" class="form-control" id="trayek" name="trayek" value="<?= $bus['trayek'] ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="di_terminal" <?= $bus['status'] == 'di_terminal' ? 'selected' : '' ?>>Di Terminal</option>
                    <option value="berangkat" <?= $bus['status'] == 'berangkat' ? 'selected' : '' ?>>Di Jalan</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/dashboard" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>