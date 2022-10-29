<?php
if(isset($_GET["NIM"]) && !empty(trim($_GET["NIM"]))){
	require_once 'koneksi.php';
	// Prepare a select Statement
	$sql = "SELECT *, (Tugas + UTS + UAS)/3 AS Nilai_akhir from mahasiswa WHERE NIM = ? ";

	if($stmt = mysqli_prepare($conn, $sql)){
		//Kumpulkan variable ke dalam prepared statement sebagai parameter
		mysqli_stmt_bind_param($stmt, "i", $param_NIM);
		// Mennyiapkan atau men set Parameter
		$param_NIM = trim($_GET["NIM"]);
		
		// Jalankan Pernyataan yang Disiapkan
		if(mysqli_stmt_execute($stmt)){
			$result = mysqli_stmt_get_result($stmt);
			if(mysqli_num_rows($result) == 1){
				/* Mengambil result row sebagai sebuah array asosiatif. 
                    Karena result set hanya mengandung 1 row, maka tidak
                    diperlukan menggunakan loop atau pengulangan while */
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				// mengambil nilai individu
				$Nama = $row["Nama"];
				$NIM = $row["NIM"];
				$Tugas = $row["Tugas"];
				$UTS = $row["UTS"];
				$UAS = $row["UAS"];
			} else{
				header("location: error.php");
				exit();
			}
		} else {
			echo "oops! something went wrong. please try again later.";
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
} else{
	echo 'nim harus diisi';
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>VIEW RECORD</title>
	<link rel='stylesheet' href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<style type="text/css">
			.wrapper{
				width: 950px;
				margin: auto;
			}
		</style>
	</head>
	<body>
		<div class="wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="page-header">
							<h1>Daftar Nilai - <?php echo $row["Nama"]; ?></h1>
						</div>
						<div class="form-group">
							<label>Nama</label>
							<p class="form-control-static"><?php echo $row["Nama"]; ?></p>
						<div class="form-group">
							<label>NIM</label>
							<p class="form-control-static"><?php echo $row["NIM"]; ?></p>
						<div class="form-group">
							<label>Tugas</label>
							<p class="form-control-static"><?php echo $row["Tugas"]; ?></p>
						</div>
						<div class="form-group">
							<label>UTS</label>
							<p class="form-control-static"><?php echo $row["UTS"]; ?></p>
						<div class="form-group">
							<label>UAS</label>
							<p class="form-control-static"><?php echo $row["UAS"]; ?></p>
						</div>
						<div class="form-group">
							<label>Nilai Akhir</label>
							<p class="form-control-static"><?php echo number_format($row['Nilai_akhir'], 0, '.', '') ?></p>
						</div>
						<p><a href="index2.php"class="btn btn-primary">Back</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>