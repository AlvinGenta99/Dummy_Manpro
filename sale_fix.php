<?php
require_once 'config.php';
session_start();
$number = count($_POST['iid']);
$id = $_POST['iid'];
$jumlah = $_POST['ijumlah'];
//$id = $_SESSION['id'];
//$jumlah = $_SESSION['jumlah'];
//$harga = $_SESSION['harga'];
//Queries
//$query1 = "UPDATE spareparts SET stock = stock - $jumlah WHERE id_tipe =$id";
//$query2 = "SELECT stock FROM spareparts WHERE id_tipe =$id ";
//$query3 = "INSERT INTO riwayat_jual (id_tipe,jumlah) VALUES ($id,$jumlah)";
// $confirm = pg_query("SELECT DISTINCT id_tipe FROM tipe");
// $tipec = pg_fetch_assco($confirm);
$query4 = "INSERT INTO riwayat_jual (id_tipe,jumlah) VALUES ";
//$prep1 = pg_prepare($link,"reduce",$query1);
//$prep2 = pg_prepare($link,"check",$query2);
//$prep3 = pg_prepare($link,"historize",$query3);
		
pg_query("BEGIN") or die("Could not start transaction\n");

if($number == 1)
	{
		if($id[0] == 0 || $jumlah[0] == 0)
		{
            echo ("Nilai tidak dimasukkan. HARAP CEK KEMBALI!");
			exit();
		}

		$query1 = "UPDATE spareparts SET stock = stock - $jumlah[0] WHERE id_tipe = $id[0]";
		$query2 = "SELECT stock FROM spareparts WHERE id_tipe = $id[0]";
		$prep1 = pg_prepare($link,"reduce",$query1);
		$prep2 = pg_prepare($link,"check",$query2);
		$prep1 = pg_execute($link,"reduce",array());
		$prep2 = pg_execute($link,"check",array());
		$query4 .= "($id[0], $jumlah[0])";
		pg_query($link, $query4);
		$data = pg_fetch_assoc($prep2);
		if ($data['stock'] < 0 )
		{
			pg_query("ROLLBACK") or die("ROLLBACK failed\n");

			echo ("Transaksi Gagal, karena STOCK TIDAK ADA/HABIS. Harap cek transaksi kembali!");
			exit();
		}
		else
		{
			pg_query("COMMIT") or die("Transaction commit failed\n");
			echo ("Transaksi BERHASIL!");
			exit();
		}
	}
if($number > 1)
	{
		if($id[0] == 0 || $jumlah[0] == 0)
		{
            echo ("Nilai tidak dimasukkan. HARAP CEK KEMBALI!");
			exit();
		}
		for($i=0; $i<$number-1; $i++)
		{
			if($id[$i] == 0 || $jumlah[$i] == 0)
			{
				echo ("Nilai tidak dimasukkan. HARAP CEK KEMBALI!");
				exit();
			}
			if(trim($_POST["iid"][$i] != ''))
			{

				$query1 = "UPDATE spareparts SET stock = stock - $jumlah[$i] WHERE id_tipe = $id[$i]";
				$query2 = "SELECT stock FROM spareparts WHERE id_tipe = $id[$i]";
				$prep1 = pg_prepare($link,"reduce",$query1);
				$prep2 = pg_prepare($link,"check",$query2);
				$prep1 = pg_execute($link,"reduce",array());
				$prep2 = pg_execute($link,"check",array());
				$query4 .= "($id[$i], $jumlah[$i]),";
				$data = pg_fetch_assoc($prep2);
				if ($data['stock'] < 0 )
				{
					pg_query("ROLLBACK") or die("ROLLBACK failed\n");

					echo ("Transaksi Gagal, karena STOCK TIDAK ADA/HABIS. Harap cek transaksi kembali!");
					exit();
				}
				else
    			{
					pg_query("COMMIT") or die("Transaction commit failed\n");
					echo ("Transaksi BERHASIL!");
					exit();
				}

			}
		
		}

		$query4 .= "($id[$i], $jumlah[$i])";
		//$prep3 = pg_execute($link,"historize",array());
		pg_query($link, $query4);
	   // $query4 = pg_query($query4);

	}
/*else 
	{
		echo ("<script>
		alert('Tidak ada Input. Harap Cek kembali input!');
		window.location.href='sale.php';
		</script>");
	}*/


if ($data < 0 )
    {
		pg_query("ROLLBACK") or die("ROLLBACK failed\n");

		echo ("Transaksi Gagal, karena STOCK TIDAK ADA/HABIS. Harap cek transaksi kembali!");
		exit();
    }
else
    {

		pg_query("COMMIT") or die("Transaction commit failed\n");
		echo ("Transaksi BERHASIL!");
		exit();
    }

?>
