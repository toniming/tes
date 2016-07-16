                    <?php
                    if($_SESSION['as']=="pegawai") {
                    unset($_SESSION['notif']);
                    $query= $db->query("select * from cuti where nip='".$_SESSION['nip']."'");
                    echo "<table class='table' cellspacing=0>
                        <tr class='header'><td>NIP</td>
                            <td>Tanggal Awal</td>
                            <td>Tanggal Akhir</td>
                            <td>Alasan</td>
                            <td>Status</td></tr>
                    ";
                    while($row = mysqli_fetch_array($query)){
                        ?>
                        <tr>
                            <td><?php echo $row['nip'];?></td>
                            <td><?php echo $row['tanggal_awal'];?></td>
                            <td><?php echo $row['tanggal_akhir'];?></td>
                            <td><?php echo $row['alasan'];?></td>
                            <td><?php echo $row['status'];?></td>
                        </tr>
                        <?php }
                    echo "</table>";
                    }
                    ?>