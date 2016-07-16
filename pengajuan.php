<?php
    if($_SESSION['as']=="pegawai") { 
    unset($_SESSION['notif']);
    if(isset($_POST['tgl_aw'])){
        $awal = $_POST['thn_aw']."-".$_POST['bln_aw']."-".$_POST['tgl_aw'];
        $akhir = $_POST['thn_ak']."-".$_POST['bln_ak']."-".$_POST['tgl_ak'];
        $alasan = $_POST['alasan'];
        
        $cek = $db->query("SELECT sum(jumlah) as jumlah1 FROM cuti where nip = '".$_SESSION['nip']."' AND tahun = '".$_POST['thn_aw']."' AND status = 'Approved'");
        $jumlahh = 0;
        while($row = mysqli_fetch_array($cek)){
            $jumlahh = $row['jumlah1'];
        }
        if($jumlahh>=12){
            $_SESSION['notif'] = "Maaf, jatah cuti anda sudah habis.";
            header("location: index.php");
            break;
        }
        
        if($_POST['thn_ak']!=$_POST['thn_aw']){
            $_SESSION['notif'] = "Maaf, pengajuan cuti hanya bisa di lakukan didalam tahun yang sama.";
            header("location: index.php");
            break;
        }
        if($_POST['bln_aw']==$_POST['bln_ak']) $jumlah = $_POST['tgl_ak'] - $_POST['tgl_aw'] + 1;
        else if($_POST['bln_aw']!=$_POST['bln_ak']){
            $dif = $_POST['bln_ak']-$_POST['bln_aw'];
            if($dif>1){
                $_SESSION['notif'] = "Pengajuan Cuti anda terlalu banyak.";
                header("location: index.php");
                break;
            }
            else if($dif<1){
                $_SESSION['notif'] = "Silahkan inputkan tanggal yang benar.";
                header("location: index.php");
                break;
            }
            else{
                $jumlah = $_POST['tgl_ak']+(31-$_POST['tgl_aw']) +1;
                echo $jumlah;       
            }
        }
        if(($jumlah)>12){
            $_SESSION['notif'] = "Maaf, jatah cuti anda dalam 1 tahun hanya 12 hari.";
            header("location: index.php");
            break;
        }
        else if(($jumlah)<0){
            $_SESSION['notif'] = "Silahkan inputkan tanggal yang benar.";
            header("location: index.php");
            break;
        }
        else if(($jumlahh+$jumlah)>12){
            $_SESSION['notif'] = "Maaf, ada tidak bisa mengajukan cuti selama ".($jumlah+1)." hari karena sisa cuti anda tinggal ".(12-$jumlahh)." hari.";
            header("location: index.php");
            break;
        }
        $query = $db->query("INSERT INTO cuti (nip, tanggal_awal, tanggal_akhir, alasan, jumlah, tahun) VALUES ('".$_SESSION['nip']."', '".$awal."', '".$akhir."', '".$alasan."', '".$jumlah."', '".$_POST['thn_aw']."')");
        if($query){
            $_SESSION['notif'] = "Anda berhasil mengajukan cuti. Silahkan mengecek history cuti anda di <a href='index.php?page=history_cuti'>History Cuti.</a>";
            header("location: index.php");
        }
        else{
            $_SESSION['notif'] = "Anda sudah mengajukan cuti pada tanggal yang sama sebelumnya. Silahkan mengecek history cuti anda di <a href='index.php?page=history_cuti'>History Cuti.</a>";
            header("location: index.php");
        }
        
    }
?>
                
<form method="post" action="">
    <table>
        <tr><td colspan="3"><h2>Ajukan cuti</h2></td></tr>
        <tr>
            <td>Tanggal Awal</td>
            <td>:</td>
            <td>
                <select name="tgl_aw">
                    <?php
                        for($a=1;$a<=31;$a++){
                            echo "<option value='$a'>$a</option>";        
                        }
                    ?>
                </select>
                <select name="bln_aw">
                <?php
                $bulan = array('','januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
                    for($a=1;$a<=12;$a++){
                        echo "<option value='$a'>$bulan[$a]</option>";        
                    }
                ?>
                </select>
                <select name="thn_aw">
                <?php
                    for($a=2015;$a<=2019;$a++){
                        echo "<option value='$a'>$a</option>";        
                    }
                ?>
                </select>    
            </td>
        </tr>
        <tr>
            <td>Tanggal Akhir</td>
            <td>:</td>
            <td>
                <select name="tgl_ak">
                    <?php
                        for($a=1;$a<=31;$a++){
                            echo "<option value='$a'>$a</option>";        
                            }
                    ?>
                </select>
                <select name="bln_ak">
                    <?php
                    $bulan = array('', 'januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
                        for($a=1;$a<=12;$a++){
                        echo "<option value='$a'>$bulan[$a]</option>";        
                        }
                    ?>
                </select>        
                <select name="thn_ak">
                    <?php
                        for($a=2015;$a<=2019;$a++){
                            echo "<option value='$a'>$a</option>";        
                        }
                    ?>
                </select>    
            </td>
        </tr>
        <tr>
            <td>Alasan Cuti</td>
            <td>:</td>
            <td><input type="text" name="alasan" required=""/></td>
        </tr>
        <tr>
            <td><input type="submit" name="cuti" value="AJUKAN"/></td>
        </tr>
    </table>
</form>
<?php } ?>                                    