<?php

include "dbMaster.php";
class Barang extends Database{
    static protected $table="barang";
    
    static protected $test="tabel barang";
    static protected $primaryKey="id_barang";
    static protected $db_fields=array("id_barang","namaBarang","merk","hargaBeli","hargaJual","stok","deskripsi");
    

}

class Toko extends Database{
    static protected $table="toko";
    static protected $test="tabel toko";
    static protected $primaryKey="nama_toko";
    static protected $db_fields=array("nama_toko","nama_pemilik","email","alamat","gambar","password");
    
}