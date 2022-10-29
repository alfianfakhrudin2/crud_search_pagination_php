<?php
// Include koneksi file
require_once "koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard</title>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> 
	<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script> 
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fuzzy+Bubbles&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="dekor.css">
	<style type="text/css">
		.wrapper{	
			width: 1000px; margin: 0 auto;
		}
		.page-header h2{
			margin-top: 0;
		}
		table tr td:last-child a{
			margin-right: 10px;
			font-size: 20px;
		}
        thead{
            background:#5F6F94;
            color: whitesmoke;
        }
        tbody{
			font-size:18px;
            background: #F6FBF4;
        }
		.inpot{
            border-radius: 10px 0px 0px 10px;
            margin-right: 0px;
            padding: 4px;
			height: 3.7rem;
            width: 21rem;
        }
		
	</style> 
	<script type="text/javascript"> 
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip(); 
		}); 
	</script> 
</head>
<body>
	<header>
    <div class="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="" style="margin-top:26px;">
						<h2 style="font-family: 'Fuzzy Bubbles', cursive;" class="pull-left" style="margin-top:10px;">Data Mahasiswa Univ.Tadika Mesra</h2> 
					</div> 
				</div>
			</div>
            <div class="row">
                <div class="col-12">
                    <form method="get">
                        <div class="input-group" style="margin: 14px 0px; padding:0px 10px;">
                            <input class="inpot" type="search" name="search" id="forml" placeholder="Search Mahasiswa?" class="form-control" />
                            <input style="border-radius:0px 10px 10px 0px;"type="submit" class="btn btn-primary" value="Search">
							<a href="create.php" class="btn pull-right" style="	border-radius: 10px;margin-left:50px; color: #06283D; font-size: 15px; background:#B1B2FF;"><b><i class='bx bx-message-alt-add' ></i> Tambah Mahasiswa</b></a>
                        </div>
                    </form>
                </div>
            </div>
		</div>
    </div>
    </header>
	<div class="wrapper">
		<div class="container-fluid"> 
			<div class="row"> 
				<div class="col-md-12"> 
					<?php
					$limit = 4;
                    $page = $_GET['page'] ?? null;
                    if(empty($page)){
                        $position = 0;
                        $page = 1;
                    } else{
                        $position = ($page-1) * $limit;
                    }
					
					if(isset($_GET['search'])){
						$search = $_GET['search'];
						$sql = "SELECT * FROM mahasiswa WHERE Nama LIKE '%$search%' ORDER BY NIM DESC LIMIT $position, $limit";
					} else{
						$sql = "SELECT * FROM mahasiswa ORDER BY NIM DESC LIMIT $position, $limit";
					}

					
					$i = 1;
					$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0){ 
							echo "<table class='table table-bordered table-striped  table-hover'>"; 
								echo "<thead>"; 
									echo "<tr>";
										echo "<th class='text-center'>No</th>";
										echo "<th class='text-center'>Nim</th>";
										echo "<th class='text-center'>Nama</th>"; 
										echo "<th class='text-center'>Nilai Tugas</th>"; 
										echo "<th class='text-center'>Nilai UTS</th>";
										echo "<th class='text-center'>Nilai UAS</th>"; 
										echo "<th class='text-center'>Action</th>"; 
									echo "</tr>"; 
								echo "</thead>"; 
								echo "<tbody>";
								while ($row = mysqli_fetch_array($result)){
									echo "<tr>";
										echo "<td class='text-center'>" . $i++ . "</td>";
										echo "<td class='text-center'>" . $row['NIM'] . "</td>"; 
										echo "<td class='text-center'>" . $row['Nama'] . "</td>"; 
										echo "<td class='text-center'>" . $row['Tugas'] . "</td>"; 
										echo "<td class='text-center'>" . $row['UTS'] . "</td>";
										echo "<td class='text-center'>" . $row['UAS'] . "</td>"; 
										echo "<td class='text-center'>";
											echo "<a style='padding-right: 5px;' href='read.php?NIM=". $row['NIM'] ."' tittle='View Record' ><span><i class='btn btn-success bx bx-spreadsheet' style='font-size:18px;'></i></span></a>";
											echo "<a style='padding-right: 5px;' href='update.php?id=". $row['NIM'] ."' title='Update Record' ><span><i class='btn btn-info bx bxs-edit' style='font-size:18px;'></i></span></a>"; 
											echo "<a style='padding-right: 5px;' href='delete.php?NIM=". $row['NIM'] ."' title='Delete Record'><span><i class='btn btn-danger bx bxs-trash' style='font-size:18px;'></i></span></a>"; 
										echo "</td>"; 
									echo "</tr>";
								}
								echo "</tbody>"; 
							echo "</table>"; 
							// Free result set
							mysqli_free_result($result); 
						} else{
							echo "<table class='table table-bordered table-striped table-hover' style='background-color:white'>";
								echo "<thead>";
										echo "<tr>";
											echo "<th>Student Number</th>";
											echo "<th>Name</th>";
											echo "<th>Task</th>";
											echo "<th>Middle Test</th>";
											echo "<th>Final Test</th>";
											echo "<th>Settings</th>";
										echo "</tr>";
									echo "</thead>";
									echo "<tbody>";
										echo "<tr>";
											echo "<td td class='text-center' colspan='6'>Oops! Data Not Found.</td>";
										echo "</tr>";
										echo "</tbody>";
								echo "</table>";
						}
						if(isset($_GET['search'])){
							$search = $_GET['search'];
							$query2 = "SELECT * FROM mahasiswa WHERE Nama LIKE '%$search%' ORDER BY NIM DESC";
						} else{
							$query2= "SELECT * FROM mahasiswa ORDER BY NIM DESC";
						}
						$result2 = mysqli_query($conn, $query2);
						$jmlhdata = mysqli_num_rows($result2);
						$jmlhalaman = ceil($jmlhdata/$limit);
					// Close connection
					mysqli_close($conn);
				?> 
				<!-- <br> -->
					<ul class="pagination">
						<?php
							for ($i=1;$i<=$jmlhalaman;$i++) {
								if ($i != $page) {
									if (isset($_GET['search'])) {
										$search = $_GET['search'];
										echo "<li class='page-item'><a class='page-link' href='index2.php?page=$i&search=$search'>$i</a></li>";
									} else {
										echo "<li class='page-item'><a class='page-link' href='index2.php?page=$i' style='color: black;'>$i</a></li>";
									}
								} else {
									echo "<li class'page-item'><a class='page-link' href='#' style='color: black;'>$i</a></li>";
								}
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
</html>