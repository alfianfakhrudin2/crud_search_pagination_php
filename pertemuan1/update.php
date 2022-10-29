<?php
// untu memanggil file koneksi
require_once "koneksi.php";

// menentukan variable dan inisialisasi dengan nilai kosong

$Nama = $NIM = $Tugas = $UTS = $UAS = "";
$Nama_err = $NIM_err = $Tugas_err = $UTS_err = $UAS_err ="";

// memproses data formulir saat formulir dikirimkan
if(isset($_POST["NIM"]) && !empty($_POST["NIM"])){
    // mendapatkan nilai input tersembunyi
    $NIM = $_POST["NIM"];

    // Validate name
    $input_Nama = trim($_POST["Nama"]);
    if(empty($input_Nama)){
        $Nama_err = "Please enter a name.";
    } elseif(!filter_var($input_Nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Nama_err = "Please enter a valid name.";
    } else{
        $Nama = $input_Nama;
    }

    // validasi nim
    $input_NIM = trim($_POST["NIM"]);
    if(empty($input_NIM)){
        $NIM_err = "Please enter your nim.";
    } else{
        $NIM = $input_NIM;
    }

    // validasi tugas
    $input_Tugas = trim($_POST["Tugas"]);
    if(empty($input_Tugas)){
        $Tugas_err = "Please enter nilai tugas.";
    } elseif(!ctype_digit($input_Tugas)){
        $Tugas_err = "Please enter a positive integer value.";
    } else{
        $Tugas = $input_Tugas;
    }
    
    // validasi nim
    $input_UTS = trim($_POST["UTS"]);
    if(empty($input_UTS)){
        $UTS_err = "Please enter nilai uts.";
    } elseif(!ctype_digit($input_UTS)){
        $UTS_err = "Please enter a positive integer value.";
    } else{
        $UTS = $input_UTS;
    }

    // validasi uas
    $input_UAS = trim($_POST["UAS"]);
    if(empty($input_UAS)){
        $UAS_err = "Please enter nilai uas.";
    } elseif(!ctype_digit($input_UAS)){
        $UAS_err = "Please enter a positive integer value.";
    } else{
        $UAS = $input_UAS;
    }

    // periksa kesalahan input sebelum memasukkan dalam database
    if(empty($Nama_err) && empty($NIM_err) && empty($Tugas_err) && empty($UTS_err) && empty($UAS_err)){
        // menyiapkan pernyataan insert
        $sql = "UPDATE mahasiswa SET Nama=?, Tugas=?, UTS=?, UAS=? WHERE NIM=?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // mengikat variabel ke pernyataam yang disiapkan sebagai parameter
            mysqli_stmt_bind_param($stmt, "siiii", $param_Nama, $param_Tugas, $param_UTS, $param_UAS, $param_NIM);
            // Set paramaters
            $param_Nama = $Nama;
            $param_Tugas = $Tugas;
            $param_UTS = $UTS;
            $param_UAS = $UAS;
            $param_NIM = $NIM;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // jika data berhasil ke update maka akan mendirect ke halaman index2
                header("location: index2.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $NIM = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM mahasiswa WHERE NIM = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parametes
            mysqli_stmt_bind_param($stmt, "i", $param_NIM);

            // Set parameters
            $param_NIM = $NIM;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $Nama = $row["Nama"];
                    $NIM = $row["NIM"];
                    $Tugas = $row["Tugas"];
                    $UTS = $row["UTS"];
                    $UAS = $row["UAS"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else{
        // URL doesn't contain id parameter. Redirect to erro page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Update Record</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="dekor.css">
	<style type="text/css">
		.wrapper{
			width: 500px;
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
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($Nama_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="Nama" class="form-control" value="<?php echo $Nama; ?>">                          
                            <span class="help-block"><?php echo $Nama_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($NIM_err)) ? 'has-error' : ''; ?>">
                            <label>NIM</label>
                            <input type="number" name="NIM" class="form-control" value="<?php echo $NIM; ?>">                          
                            <span class="help-block"><?php echo $NIM_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($Tugas_err)) ? 'has-error' : ''; ?>">
                            <label>Tugas</label>
                            <input type="number" name="Tugas" class="form-control" value="<?php echo $Tugas; ?>">
                            <span class="help-block"><?php echo $Tugas_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($UTS_err)) ? 'has-error' : ''; ?>">
                            <label>UTS</label>
                            <input type="number" name="UTS" class="form-control" value="<?php echo $UTS; ?>">
                            <span class="help-block"><?php echo $UTS_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($UAS_err)) ? 'has-error' : ''; ?>">
                            <label>UAS</label>
                            <input type="number" name="UAS" class="form-control" value="<?php echo $UAS; ?>">                         
                            <span class="help-block"><?php echo $UAS_err;?></span>
                        </div>
                        <input type="hidden" name="NIM" value="<?php echo $NIM; ?>"/>
                        <input type="submit" class="btn" style="margin-left:160px; background-color: #3D8361; color:whitesmoke;" value="Submit">
                        <a href="index2.php" class="btn" style="background-color: #FF9551; color:black;" >Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>