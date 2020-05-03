<?php
require_once "config.php";
$posted = false;
$jumlah = $id = '';
$tipe = pg_query("SELECT * FROM tipe ORDER BY nama_tipe ASC");

function dropdown()
{
	$query = "SELECT * FROM tipe ORDER BY nama_tipe ASC";
	$tipe = pg_query($query);
	while ($rowt = pg_fetch_array($tipe)) 
	{
		echo "<option value='" . $rowt['id_tipe'] . "'>" . $rowt['nama_tipe'] . "</option>";
	}
}

require('login.php');
if(isset($_SESSION['login_user']))
{?>

<!DOCTYPE html>
<html lang="en">
<head>
	
    <meta charset="UTF-8">
    <title>Transaction</title>   
    <link rel="stylesheet" href="theme.css" />  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
 <!   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

</head>

<body>
		<div class="container">
			<br />
			<br />
			<h2 align="center"><a>Jual Barang</a></h2><br />
			<div class="form-group">
				<form name="add_name" id="add_name">
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field">
							<tr>
								<td><input type="number" name="iid[]" placeholder="Masukan ID barang" class="form-control name_list" /></td>
								<td><input type="number" name="ijumlah[]" placeholder="Masukan Jumlah yang Dijual" class="form-control name_list" /></td>
								<td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
							</tr>
						</table>
						<br>
						<center><input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" /><center>
					</div>
				</form>
			</div>
		</div>

<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append
		(
			'<tr id="row'+i+'"><td><input type="number" name="iid[]" placeholder="Masukan ID barang" class="form-control name_list" /></td></td><td><input type="number" name="ijumlah[]" placeholder="Masukan Jumlah yang Dijual" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'
		);
	});
	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
		i=i-1;
	});
	
	$('#submit').click(function(){		
		$.ajax({
			url:"sale_fix.php",
			method:"POST",
			data:$('#add_name').serialize(),
			success:function(data)
			{
				alert(data);
				$('#add_name')[0].reset();
			}
		});
	});
	
});
</script>
<center><a type="submit" href="home.php" class="btn btn-lg" value="CANCEL">Cancel</a></center>
<br>
</body>
</html>

 <?php }

else 
{
    header("Location: index.php");
}
