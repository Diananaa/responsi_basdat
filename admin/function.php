<?php
// $conn = mysqli_connect("localhost", "root", "", "diana-responsi");
include dirname(__DIR__)."\db.php";
function register($data)
{
    // global $conn;
    $nama_toko = htmlspecialchars($data["nama_toko"]);
    $nama_pemilik = htmlspecialchars($data["nama_pemilik"]);
    $email = htmlspecialchars($data["email"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $password = htmlspecialchars($data["password"]);
    $password2 = htmlspecialchars($data["password2"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // password
    // cek username sudah ada atau belum
    $result = Toko::getWhereData("email = '$email'");
    if (count($result)>0) {
        echo "<script>
                alert('email yang dipilih sudah terdaftar')
            </script>";
        return false;
    }
    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script> 
                alert('konfirmasi password tidak sesuai');
            </script>";
        return false;
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    // $password = md5($password);

    // $query = "INSERT INTO toko VALUES
    //     ('$nama_toko','$nama_pemilik','$email','$alamat','','$password')";
    // print_r($query);
    // mysqli_query($conn, $query);
    return Toko::saveData([
        "nama_toko"=>"'$nama_toko'",
        "nama_pemilik"=>"'$nama_pemilik'",
        "email"=>"'$email'",
        "alamat"=>"'$email'",
        "password"=>"'$password'"
    ]);
    // return mysqli_affected_rows($conn);
}
function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFIle = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];
    
    // cek apakah tidak ada gambar yg diupload
    if ($error === 4) {
        echo "<script>
                alert('tes');
            </script>";
        return false;
    }

    // cek ekstensi gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png','JPG'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('yg ada anda upload bukan gambar');
            </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFIle > 7000000) {
        echo "<script>
                alert('yg ada anda upload terlalu besar');
            </script>";
        return false;
    }



    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function tambahBarang($data)
{
    global $conn;
    $namaBarang = htmlspecialchars($data["namaBarang"]);
    $merk = htmlspecialchars($data["merk"]);
    $hargaBeli = htmlspecialchars($data["hargaBeli"]);
    $hargaJual = htmlspecialchars($data["hargaJual"]);
    $stok = htmlspecialchars($data["stok"]);
    $deskripsi = htmlspecialchars($data["deskripsi"]);
    
    $query = "INSERT INTO barang
    VALUES
    ('','$namaBarang','$merk','$hargaBeli','$hargaJual','$stok','$deskripsi')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);

}