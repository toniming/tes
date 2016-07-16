<?php
    session_start();
    $db = new mysqli("localhost", "root", "", "employee");
    if(!isset($_GET['page'])) { $_GET['page']=""; }
    if(!isset($_SESSION['notif'])) { $_SESSION['notif']=""; }
    
    if($_GET['page']=="login"){
    if(isset($_POST['nip']) && isset($_POST['pass'])){
        $nip = $_POST['nip'];
        $pass = $_POST['pass'];
        $pilihan = $_POST['pilihan'];
        $query = $db->query("SELECT * FROM $pilihan where nip = '$nip'");
        if($query->num_rows==1){
            $query1 = $db->query("SELECT * FROM $pilihan where nip = '$nip' and password = '$pass'");
            if($query1->num_rows==1){
                unset($_SESSION['notif']);
                $_SESSION['nip'] = $nip;
                $_SESSION['as'] = $pilihan;
                header("location: index.php");
            }
            else{
                $_SESSION['notif'] = "Password Salah.";
                echo "SELECT * FROM $pilihan where nip = '$nip' password = '$pass'";
            }
        }
        else{
            $_SESSION['notif'] = "Username tidak ditemukan.";
        }
    }
    }
    if($_GET['page']=="logout"){
        unset($_SESSION['nip']);
    }
    if(isset($_SESSION['user'])) { header("location: index.php"); }
?>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
    <div id="box">
        <div class="title">LOGIN FORM</div>
        <form method="post" action="login.php?page=login">
        <div class="form">
            <?php if($_SESSION['notif']!="") { ?>
            <div class="notif"><?php echo $_SESSION['notif']; ?></div>
            <?php } ?>
            <table>
                <tr><td>Username</td>
                    <td>:</td>
                    <td><input type="text" name="nip" required="" placeholder="Masukan NIP"/></td>
                </tr>
                <tr><td>Password</td>
                    <td>:</td>
                    <td><input type="password" name="pass" required="" placeholder="Masukan Password"/></td>
                </tr>
                <tr><td>Sebagai</td>
                    <td>:</td>
                    <td><select name="pilihan">
                            <option value="pegawai">Pegawai</option>
                            <option value="hrd">HRD</option>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;"><input type="submit" name="login" value="LOGIN" /></td>
                </tr>
            </table>
        </div>
        </form>
    </div>
</body>
</html>