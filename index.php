<?php
    session_start();
    $db = new mysqli("localhost", "root", "", "employee");
    if(!isset($_GET['page'])) { $_GET['page']=""; }
    if(!isset($_SESSION['notif'])) { $_SESSION['notif']=""; }
    
    if(!isset($_SESSION['nip'])) { header("location: login.php"); }
?>
<html>
<head>
    <title>Sistem Cuti Karyawan</title>
    <link rel="stylesheet" type="text/css" href="style-main.css" />
</head>
<body>
    <full><h1>Sistem Cuti Karyawan</h1></full>
    <full>
        <div class="menu">
            <ul>
                <?php if($_SESSION['as']=="pegawai") { ?>
                <li><a href="index.php?page=pengajuan_cuti" <?php if(($_GET['page']=="")||($_GET['page']=="pengajuan_cuti")){?>class="aktif"<?php } ?>>Pengajuan Cuti</a></li>
                <li><a href="index.php?page=history_cuti" <?php if($_GET['page']=="history_cuti"){?>class="aktif"<?php } ?>>History Cuti</a></li>
                <?php } else { ?>
                <li><a href="index.php?page=permintaan" <?php if(($_GET['page']=="")||($_GET['page']=="permintaan")){?>class="aktif"<?php } ?>>Permintaan Cuti</a></li>
                <li><a href="index.php?page=history" <?php if($_GET['page']=="history"){?>class="aktif"<?php } ?>>History Cuti</a></li>
                <?php } ?>
                <li><a href="login.php?page=logout" onclick="return confirm('Apakah anda yakin ingin logout?')">Logout</a></li>
            </ul>
        </div>
    </full>
    <full>
        <?php 
        if($_SESSION['notif']!="") { ?>
        <div class="notif"><?php echo $_SESSION['notif']; ?></div>
        <?php } ?>
        <?php $page = $_GET['page'];
        switch($page){
                case'history_cuti':
                    include 'history_cuti.php';
                break;
                case'permintaan':
                    include 'permintaan.php';
                break;
                case'history':
                    include 'history.php';
                break;
                case'pengajuan_cuti':
                default:
                    include 'pengajuan.php';
                break; 
                
                
        } 
        ?>
    </full>
</body>
</html>