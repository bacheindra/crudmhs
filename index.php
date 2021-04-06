<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "crud";

$koneksi = mysqli_connect($server, $user, $pass, $db) or die(mysqli_error($koneksi));

//Jika tombol simpat diklik
if (isset($_POST['bsimpan'])) {



    if ($_GET['hal'] == "edit") {

        //data akan di edit


        $edit = mysqli_query($koneksi, "UPDATE tmhs set
                                        nim = '$_POST[tnim]',
                                        nama= '$_POST[tnama]',
                                        alamat = '$_POST[talamat]',
                                        prodi = '$_POST[tprodi]'
                                        WHERE id_mhs = '$_GET[id]'
                                        ");
        if ($edit) {
            echo "<script>alert('Data berhasil diedit');
                                document.location='index.php';
            </script>";
        } else {
            echo "<script>alert('Data gagal diedit');
                                document.location='index.php';
            </script>";
        }
    } else {

        // data disimpan 

        $duplicate = mysqli_query($koneksi, "SELECT * from tmhs where nim ='$_POST[tnim]' ");

        if (mysqli_num_rows($duplicate) > 0) {
            echo "<script>alert('Data Nim sudah terdaftar');
        document.location='index.php';
        </script>";
        } else {

            $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim,nama,alamat,prodi) 
                                VALUES ('$_POST[tnim]',
                                       '$_POST[tnama]', 
                                       '$_POST[talamat]',
                                       '$_POST[tprodi]') ");
            if ($simpan) {
                echo "<script>alert('Data berhasil disimpan');
                                document.location='index.php';
            </script>";
            } else {
                echo "<script>alert('Data gagal disimpan');
                                document.location='index.php';
            </script>";
            }
        }
    }
}

// pengujian jika tombol edit/hapus di klik
if (isset($_GET['hal'])) {
    //pengujian jika edit data
    if ($_GET['hal'] == "edit") {
        //tampilkan data data yang di edit
        $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {

            $vnim = $data['nim'];
            $vnama = $data['nama'];
            $valamat = $data['alamat'];
            $vprodi = $data['prodi'];
        }
    } else if ($_GET['hal'] == "hapus") {
        // persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
        if ($hapus) {
            echo "<script>
                    alert('Data berhasil dihapus');
                                document.location='index.php';
            </script>";
        }
    }
}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <title>CRUD 2020</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">CRUD 2020</h1>
        <h2 class="text-center">Ngetes Aja</h2>


        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                Form Input Data Mahasiswa
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="">NIM</label>
                        <input type="text" name="tnim" value="<?= @$vnim ?>" class="form-control" placeholder="Input Nim Anda" required>

                    </div>

                    <div class="form-group">
                        <label for="">NAMA</label>
                        <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control" placeholder="Input Nama Anda" required>

                    </div>

                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea class="form-control" name="talamat" id=""><?= @$valamat ?></textarea>

                    </div>

                    <div class="form-group">
                        <label for="">Pilih Jurusan</label>
                        <select name="tprodi" value="<?= @$vprodi ?>" id="">
                            <option value="D3-MI">D3-MI</option>
                            <option value="S1-SI">S1-SI</option>
                            <option value="S1-TI">S1-TI</option>
                        </select>

                    </div>

                    <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                    <button type="reset" class="btn btn-danger" name="breset">Reset</button>

                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-primary text-white bg-success">
                Data Mahasiswa
            </div>
            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>

                    </tr>
                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                    while ($data = mysqli_fetch_array($tampil)) {

                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nim']; ?></td>
                            <td><?= $data['nama']; ?></td>
                            <td><?= $data['alamat']; ?></td>
                            <td><?= $data['prodi']; ?></td>
                            <td>
                                <a href="index.php?hal=edit&id=<?= $data['id_mhs'] ?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?hal=hapus&id=<?= $data['id_mhs'] ?>" onclick="return confirm('Hapus Data')" class="btn btn-danger">Hapus</a>
                            </td>

                        </tr>

                    <?php } // penutup while 
                    ?>


                </table>

            </div>
        </div>

    </div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
</body>

</html>