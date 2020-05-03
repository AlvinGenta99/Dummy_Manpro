<?php
$posted = false;
require_once "config.php";
require_once "insert_own.php";


if($_SERVER["REQUEST_METHOD"] = "POST"){
    try 
    {   
        $posted = true;
        $namamerk = $_POST['iNamaMerk'];
        
        $new_merk = "INSERT INTO merk (nama_merk) VALUES ('$namamerk')";
        pg_query($new_merk);

      
            echo ("<script>
            alert('Data sudah tercatat');
            </script>");
    }

    catch(Exception $e)
    {
        echo $e;
    }
}
?>