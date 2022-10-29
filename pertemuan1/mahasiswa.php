<?php
// untuk menghubungkan ke file koneksi
include ('koneksi.php');
// untuk memberi nama table
$table_name = 'mahasiswa';
// untuk membuat table dan menetpkan struktur nya
$sql = "CREATE TABLE IF NOT EXISTS `$table_name`(
            `Nama` VARCHAR(20) NOT NULL,
            `NIM`  INT(50) NOT NULL,
            `Tugas` INT(50) NOT NULL,
            `UTS` INT(50) NOT NULL,
            `UAS` INT(50) NOT NULL,
        PRIMARY KEY (`NIM`)) ENGINE = InnoDB DEFAULT CHARSET=utf8";

$query = mysqli_query($conn, $sql);
// untuk mengetahui table sudah berhasil dibuat atau tidak
if(!$query){
    die('Error: Tabel' . $table_name . ' gagal dibuat: ' . mysqli_error($conn));
} 
echo 'create table ' . $table_name . ' berhasil dibuat' . '<br/>';

// untuk memasukan data ke tabel
$sql = "INSERT INTO `$table_name` (`Nama`, `NIM`, `Tugas`, `UTS`, `UAS`)
    VALUES
        ('rojak', 210112, 40, 45, 50),
        ('reja', 210213, 30, 60, 95),
        ('rayhan', 210314, 66, 51, 55),
        ('dimas', 210415, 62, 70, 80),
        ('rehanwngsaf', 210516, 90, 75, 84)";

$query = mysqli_query($conn, $sql);
// konidisi untuk mengetahui apakah data tersebut berhasil atau tidak
if(!$query) {
    die('ERROR: data gagal dimasukkan pada tabel ' . $table_name . ': ' . mysqli_error($conn));
}
echo 'Data Berhasil dimasukkan pada tabel ' . $table_name;
?>