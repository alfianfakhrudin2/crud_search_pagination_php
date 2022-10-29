<?php
// Include koneksi file
require_once "koneksi.php";

// Tentukan variabel dan inisialisasi dengan nilai kosong
$Nama = $NIM = $Tugas = $UTS = $UAS = "";
$Nama_err = $NIM_err = $Tugas_err = $UTS_err = $UAS_err = "";

// Memproses data formulir saat formulir dikirimkan
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_Nama = trim( $_POST["Nama"]); 
	if(empty($input_Nama)){
		$Nama_err = "Harap masukkan Nama."; 
	} elseif(!filter_var($input_Nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
		$Nama_err = "Harap masukkan Nama yang valid."; 
	} else{
		$Nama = $input_Nama;
	}

    // Validate nim
    $input_NIM = trim($_POST['NIM']);
    if (empty($input_NIM)) {
        $NIM_err = "Please enter your nim.";
    } elseif (!ctype_digit($input_NIM)) {
        $NIM_err = "Please enter a positive integer value.";
    } else {
        $NIM = $input_NIM;
    }

    // Validate Tugas
    $input_Tugas = trim($_POST['Tugas']);
    if (empty($input_Tugas)) {
        $Tugas_err = "Please enter your assignment score.";
    } elseif (!ctype_digit($input_Tugas)) {
        $Tugas_err = "Please enter a positive integer value.";
    } else {
        $Tugas = $input_Tugas;
    }

    // Validate UTS
    $input_UTS = trim($_POST['UTS']);
    if (empty($input_UTS)) {
        $UTS_err = "Please enter your uts score.";
    } elseif (!ctype_digit($input_UTS)) {
        $UTS_err = "Please enter a positive integer value.";
    } else {
        $UTS = $input_UTS;
    }
    
    // Validate UAS
    $input_UAS = trim($_POST['UAS']);
    if (empty($input_UAS)) {
        $UAS_err = "Please enter your uas score.";
    } elseif (!ctype_digit($input_UAS)) {
        $UAS_err = "Please enter a positive integer value.";
    } else {
        $UAS = $input_UAS;
    }
    // Check input errors before inserting in database
    if (empty($Nama_err) && empty($NIM_err) && empty($Tugas_err) && empty($UTS_err) && empty($UAS_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO mahasiswa (Nama, NIM, Tugas, UTS, UAS) VALUES (?,?,?,?,?)";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variable to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisss", $param_Nama, $param_NIM, $param_Tugas, $param_UTS, $param_UAS);
            // SEt parameters
            $param_Nama = $Nama;
            $param_NIM = $NIM;
            $param_Tugas = $Tugas;
            $param_UTS = $UTS;
            $param_UAS = $UAS;
            // Attempt to execute successfully. Redirect to landing page
            if (mysqli_stmt_execute($stmt)) {
                header("location: index2.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>create page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="dekor.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page_header">
                        <h2>Tambah Mahasiswa</h2>
                    </div>
                    <p>Silahkan isi form dibawah ini kemudian submit untuk menambahkan data pegawai ke dalam database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($Nama_err)) ? 'has-error' : '';?>">
                        <label>Nama</label>
                        <input type="text" name="Nama"" class="form-control" value="<?php echo $Nama; ?>">
                        <span class="help-block"><?php echo $Nama_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($NIM_err)) ? 'has-error' : '';?>">
                        <label>NIM</label>
                        <input type="number" name="NIM" class="form-control" value="<?php echo $NIM; ?>">
                        <span class="help-block"><?php echo $NIM_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($Tugas_err)) ? 'has-error' : '';?>">
                        <label>Tugas</label>
                        <input type="number" name="Tugas" class="form-control" value="<?php echo $Tugas; ?>">
                        <span class="help-block"><?php echo $Tugas_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($UTS_err)) ? 'has-error' : '';?>">
                        <label>UTS</label>
                        <input type="number" name="UTS" class="form-control" value="<?php echo $UTS; ?>">
                        <span class="help-block"><?php echo $UTS_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($UAS_err)) ? 'has-error' : '';?>">
                        <label>UAS</label>
                        <input type="number" name="UAS" class="form-control" value="<?php echo $UAS; ?>">
                        <span class="help-block"><?php echo $UAS_err; ?></span>
                    </div>
                    <input style="font-size: 15px; color: whitesmoke; background: #00ABB3; margin-left: 137px;  width: 100px;" type="submit" class="btn" value="Submit" name="proses">
                    <a style="background: #C9BBCF; width: 100px;" href="index2.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>