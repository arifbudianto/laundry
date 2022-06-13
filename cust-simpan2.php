<?php
require('header.php');
require('sidebar.php');
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Simpan Data</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Simpan Data</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
<?php
if (isset($_POST['id_member'])){
    $id_member   =   $_POST['id_member'];
    $simpan =   "EDIT";
} else {
    $simpan = "BARU";
}
$nohp       =   $_POST['nohp'];
$nama       =   $_POST['nama'];
// $alamat     =   $_POST['alamat'];

$dataValid = "YA";

$err_nohp='';
$err_nama='';
// $err_alamat='';
$err_valid='';

if (strlen(trim($nohp))==0){
    $err_nohp= "Nomor HP harus diisi ! <br/>";
    $dataValid ="TIDAK";
}
if (strlen(trim($nama))==0){
    $err_nama= "Nama harus diisi ! <br/>";
    $dataValid ="TIDAK";
}
// if (strlen(trim($alamat))==0){
//     $err_alamat= "Alamat harus diisi ! <br/>";
//     $dataValid ="TIDAK";
// }
if ($dataValid=="TIDAK"){
    $err_valid= "Masih ada kesalahan, silahkan perbaiki !";

    // exit;
}

if(strlen(trim($nohp))==0 || strlen(trim($nama))==0 || $dataValid=="TIDAK"){

?>
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php
        echo $err_nohp;
        echo $err_nama;
        // echo $err_alamat;
        echo $err_valid; 
    ?>
</div>
<a href="#" class="mb-3 btn btn-info btn-md" onClick = 'self.history.back()'><i class="fa fa-angle-left"></i> Kembali</a>
<?php
exit;
}

include "koneksi.php";
        // $sqltgl = "SELECT tgl_masuk as tgl from transaksi WHERE tgl_masuk = '$tgl_masuk'";
        // $querytgl = mysqli_query($kon,$sqltgl);
        // $datatgl = mysqli_fetch_array($querytgl);
        

        // if(isset($datatgl['tgl'])){
        //     $tglid = date('Ymd', strtotime($datatgl['tgl']));
        //     $sql = "SELECT max(id_transaksi) as kodeTerbesar FROM transaksi WHERE id_transaksi LIKE '$tglid%'";
        //     $query = mysqli_query($kon, $sql);
        //     $data = mysqli_fetch_array($query);
        //     $kode = $data['kodeTerbesar'];
        // }else{
        //     $tglid = date('Ymd', strtotime($tgl_masuk));
        //     $kode = $tglid;
        // }
        
        
        // $urutan = substr($kode, 8, 3);
        // $urutan++;
        // $id_transaksi = $tglid . sprintf("%03s", $urutan);
    if ($simpan == "EDIT"){
        $sql = "update pelanggan set
                nohp    =   '$nohp',
                nama    =   '$nama',
                where id_member = '$id_member'";
    }else {
            $sql = "insert into pelanggan
                (nohp, nama)
                values
                ('$nohp','$nama')";
        }
    $hasil = mysqli_query($kon, $sql);
        
    if($hasil){
        ?>

        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-check"></i> Data berhasil disimpan!
        </div>
        <a href="cust-tampil.php" class="mb-3 btn btn-info btn-md"><i class="fa fa-user"></i> Daftar Customer</a>
        
        <?php
    }else {
        ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-times"></i> Gagal Simpan!
        </div>

        <?php
        echo mysqli_error($kon);
        ?>
        <a href="#" class="mb-3 btn btn-info btn-md" onclick="self.histry.back()"><i class="fa  fa-angle-left"></i> Kembali</a>

        <?php
        exit;
    }
?>
</div>
</div>

<?php
require('footer.php');
?>