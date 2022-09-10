<?php

session_start();

if (!isset($_SESSION['array'])) {
    $_SESSION['array'] = [];
}
$rombel = ["PPLG XI-1", "PPLG XI-2", "PPLG XI-3", "PPLG XI-4", "PPLG XI-5"];

$alert = false;
$gagalNomor = false;
$berhasil = false;
$edit = false;
$delete = false;
$resetdata = false;

if(isset($_POST['kirim'])) {
    if (!empty($_POST['nama']) && !empty($_POST['nis']) && !empty($_POST['nPengetahuan']) && !empty($_POST['rombel']) && !empty($_POST['nKeterampilan'])) {

        if ($_POST['nPengetahuan'] <= 100 && $_POST['nKeterampilan'] <= 100) {
            $nilaiAkhir = round(($_POST['nPengetahuan'] + $_POST['nKeterampilan']) / 2);

            if ($nilaiAkhir >= 85) {
                $ket = 'A';
            }elseif ($nilaiAkhir < 85 && $nilaiAkhir >=75) {
                $ket = 'B';
            }else {
                $ket = 'C';
            }

            $data = [
                "nama" => $_POST['nama'],
                "nis" => $_POST['nis'],
                "rombel" => $_POST['rombel'],
                "nilai_pengetahuan" => $_POST['nPengetahuan'],
                "nilai_keterampilan" => $_POST['nKeterampilan'],
                "nilai_akhir" => $nilaiAkhir,
                "keterangan" => $ket,
            ];
            array_push($_SESSION['array'], $data);
            $berhasil = true;

        }else{
            $gagalNomor = true;  
        }
    }else{
        $alert = true;
    }

}

if (isset($_GET['edit'])) {
    $index = $_GET['index'];
    $dataEdit = $_SESSION['array'][$index];
}


if(isset($_POST['update'])){
    if (!empty($_POST['nama']) && !empty($_POST['nis']) && !empty($_POST['nPengetahuan']) && !empty($_POST['rombel']) && !empty($_POST['nKeterampilan'])) {

        $nilai = round(($_POST['nPengetahuan'] + $_POST['nKeterampilan']) / 2);
        if ($nilai >= 85) {
            $status = "A";
        } elseif ($nilai < 85 && $nilai >= 75) {
            $status = "B";
        } else {
            $status = "C";
        }


        $index = $_POST['index'];
        $_SESSION['array'][$index]['nama'] = $_POST['nama'];
        $_SESSION['array'][$index]['nis'] = $_POST['nis'];
        $_SESSION['array'][$index]['rombel'] = $_POST['rombel'];
        $_SESSION['array'][$index]['nilai_pengetahuan'] = $_POST['nPengetahuan'];
        $_SESSION['array'][$index]['nilai_keterampilan'] = $_POST['nKeterampilan'];
        $_SESSION['array'][$index]['nilai_akhir'] = $nilai;
        $_SESSION['array'][$index]['status'] = $status;

        $edit = true;

    }
}


if (isset($_GET['delete'])) {
    array_splice($_SESSION['array'], $_GET['index'], 1);
    $delete = true;
}

if (isset($_POST['reset'])) {
    session_destroy();
    $resetdata = true;
    header("Location: inputinput.php");
}

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Input-input</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .tengah{
            text-align:center;
            margin-top:10px
        }
    </style>
    </head>
<body>
   <div class="container mt-5">

   <!-- alert data tidak boleh kosong -->
    <?php
        if ($alert == true) {
    ?>
    <div class="alert alert-danger">Data tidak boleh kosong</div>
    <?php
        }
    ?>

    <!-- alert data lebih besar dari 100 -->
    <?php
        if ($gagalNomor == true) {
    ?>
   <div class="alert alert-danger">Data tidak boleh lebih besar dari 100</div>
    <?php
        }
    ?>

    <!-- alert edit berhasil -->
    <?php
        if ($edit == true) {
    ?>
   <div class="alert alert-success">edit data berahasil</div>
    <?php
        }
    ?>

    
    <!-- alert delete berhasil -->
    <?php
        if ($delete == true) {
    ?>
   <div class="alert alert-success">Hapus data berhasil</div>
    <?php
        }
    ?>

       
    <!-- alert reset data -->
    <?php
        if ($resetdata == true) {
    ?>
   <div class="alert alert-success">Reset data berhasil</div>
    <?php
        }
    ?>

    <div class="card w-50  mx-auto  mb-3">
        <div class="card-header text-bg-dark">
                Form Siswa
        </div>
        <div class="card-body">
            
        <form action="inputinput.php" method="POST">
        <?php if (isset($dataEdit)) { ?>
                    <tr>
                        <td colspan="2"><input type="number" name="index" value="<?= $_GET['index'] ?>" hidden></td>
                    </tr>
        <?php } ?>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama"  name="nama" value="<?= @$dataEdit['nama'] ?>">
            </div>

            <div class="mb-3">
                <label for="nis" class="form-label">nis</label>
                <input type="number" class="form-control" id="nis" name="nis" value="<?= @$dataEdit['nis'] ?>" >
            </div>

            <div class="mb-3">
                <label for="nPengetahuan" class="form-label">Nilai Pengetahuan</label>
                <input type="text" class="form-control" id="nPengetahuan"  name="nPengetahuan" value="<?= @$dataEdit['nilai_pengetahuan'] ?>">
            </div>

            <div class="mb-3">
                <label for="nKeterampilan" class="form-label">Nilai Keterampilan</label>
                <input type="text" class="form-control" id="nKeterampilan"  name="nKeterampilan" value="<?= @$dataEdit['nilai_keterampilan'] ?>" >
            </div>

            <select class="form-select mb-4" name="rombel">
                <option hidden>Pilih Rombel</option>


                <?php foreach($rombel as $item) {
                    if(isset($dataEdit)){
                ?>

                        <option value="<?= $item?>" <?= $item == $dataEdit['rombel'] ? 'selected' : '' ?>> <?= $item ?></option>
                    <?php
                        } else {
                    ?>
                        <option value="<?= $item ?>"><?= $item ?></option>

                <?php } } ?>
                        </select>

                       
                        <?php
                            if (isset($_GET['edit'])) {
                        ?>
                        <input type="submit" class="btn btn-primary" name="update" value="ubah"/>
                        <?php
                            }else {
                        ?>
                        <input type="submit" class="btn btn-success" name="kirim" value="simpan"/>
                        <?php
                        }?>
                    
                    </div>
        </form>
        </div>
    </div>
   </div>



   <!-- REset -->
<div class="tengah">
    <div class="">
        <form method="POST" action="inputinput.php">     
                <input onclick="return confirm(`yakin reset data?`)" type="submit" class="btn btn-danger" name="reset" value="reset data"/>     
        </form>

</div>

<div class="container mt-5">
<?php 
if (!empty($_SESSION['array'])) 
{
?>

        <div class="card w-75  mx-auto  mb-3">
            <div class="card-header text-bg-dark">
                    Data Siswa
            </div>        
            <table class="table table-bordered">
                    <thead>
     
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Nis</th>
                        <th scope="col">Rombel</th>
                        <th scope="col">Nilai Keterampilan</th>
                        <th scope="col">Nilai Pengetahuan</th>
                        <th scope="col">Nilai Akhir</th>
                        <th scope="col">Keterangan</th>
                        
                        <th scope="col">Kondisi</th>
                        </tr>

                    </thead>
                    <tbody>
                    <?php 
        $no = 1;
        foreach($_SESSION['array'] as $key => $dt) {
        ?>
                        <tr>
                            <th scope="row"><?=  $no++  ?></th>
                            <td> <?= $dt['nama'] ?></td>
                            <td> <?= $dt['nis'] ?></td>
                            <td> <?= $dt['rombel'] ?></td>
                            <td> <?= $dt['nilai_pengetahuan'] ?></td>
                            <td> <?= $dt['nilai_keterampilan'] ?></td>
                            <td> <?= $dt['nilai_akhir'] ?></td>
                            <td> <?= $dt['keterangan'] ?></td>
                         
                            
                            <td>
                                <a href="?edit&index=<?= $key ?>" ><i class="fas fa-edit"></i></a>
                              |
                                <a href="?delete&index=<?= $key ?>" onclick="return confirm(`Hapus data nilai peserta didik <?= $dt['nama'] ?> ?`)"><i class="fas fa-trash-alt text-danger"></i></a>             
                            </td>
                <?php } ?>  
                        </tr>

                    </tbody>
            </table>
        </div>
<?php } ?>   
   </div>
</body>
</html>