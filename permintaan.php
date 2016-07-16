                    <?php
                    if($_SESSION['as']=="hrd") {
                    unset($_SESSION['notif']);
                    //approval    
                    if(isset($_POST['nip'])){
                        $cek = $db->query("SELECT sum(jumlah) as jumlah1 FROM cuti where nip = '".$_POST['nip']."' AND tahun = '".substr($_POST['tanggal_awal'],0,4)."' AND status = 'Approved'");
                        $jumlahh = 0;
                        while($row = mysqli_fetch_array($cek)){
                            $jumlahh = $row['jumlah1'];
                        }
                        if($jumlahh>=12){
                            $_SESSION['notif'] = "Maaf, jatah cuti pegawai dengan nip ".$_POST['nip']." sudah habis.";
                            header("location: index.php");
                            break;
                        }else if(($jumlahh+$_POST['jumlah'])>12){
                            $_SESSION['notif'] = "Maaf, cuti selama ".($jumlah)." hari tidak bisa disetujui karena sisa cuti tinggal ".(12-$jumlahh)." hari.";
                            header("location: index.php");
                            break;
                        }
                        
                        $query = $db->query("Update cuti set status = 'Approved' where nip = '".$_POST['nip']."' and tanggal_awal = '".$_POST['tanggal_awal']."'");
                        $_SESSION['notif'] = "Pengajuan Cuti berhasil disetujui.";
                        header("location: index.php?page=permintaan");
                        break;
                    }
                    
                    $query= $db->query("select * from cuti where status = 'NA'");
                    echo "<br/><table class='table' cellspacing=0>
                        <tr class='header'><td>NIP</td>
                            <td>Tanggal Awal</td>
                            <td>Tanggal Akhir</td>
                            <td>Alasan</td>
                            <td>Status</td>
                            <td>Action</td></tr>
                    ";
                    while($row = mysqli_fetch_array($query)){
                        ?>
                        <tr>
                            <td><?php echo $row['nip'];?></td>
                            <td><?php echo $row['tanggal_awal'];?></td>
                            <td><?php echo $row['tanggal_akhir'];?></td>
                            <td><?php echo $row['alasan'];?></td>
                            <td><?php echo $row['status'];?></td>
                            <td><form method="post" method="">
                                    <input type="hidden" name="nip" value="<?php echo $row['nip'];?>" />
                                    <input type="hidden" name="tanggal_awal" value="<?php echo $row['tanggal_awal'];?>" />
                                    <input type="hidden" name="jumlah" value="<?php echo $row['jumlah'];?>" />
                                    <input type="submit" value="approve" onclick="return confirm('Yakin ingin menyetujui pengajuan cuti ini?')" />
                                </form></td>
                        </tr>
                        <?php }
                    echo "</table>";
                    }
                    ?>