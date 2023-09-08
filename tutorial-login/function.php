<?php
session_start();



//koneksi
$koneksi = mysqli_connect('localhost','root','','tutorial-login');

//daftar
if(isset($_POST['register'])){
    // jika tombol register diklik

    $username = $_POST['username'];
    $password = $_POST['password']; // inputan tanpa enkripsi

    //fungsi enkripsi
    $epassword = password_hash($password, PASSWORD_DEFAULT);

    // insert to db
    $insert = mysqli_query($koneksi,"INSERT INTO user (username,password) values ('$username','$epassword')");
    
    if($insert){
        // jika berhasil
        header('location:index.php'); // redirect ke halaman login
    } else{
        // jika gagal
        echo '
        <script>
            alert("REGISTRASI GAGAL");
            window.location.href="register.php"
        </script>
        ';
    }
}

// Login
if (isset($_SESSION['username'])){    
    if (isset($_GET['logout'])) unset($_SESSION['username']);
    header("location: index.php");
} else {
    if(isset($_POST['login'])){
        // jika tombol register diklik
        $username = $_POST['username'];
        $password = $_POST['password']; // inputan tanpa enkripsi
        
        // insert to db
        $cekdb = mysqli_query($koneksi,"SELECT * FROM user where username='$username'");
        $hitung = mysqli_num_rows($cekdb);
        $pw = mysqli_fetch_array($cekdb);
        $passwordsekarang = $pw['password'];

        if($hitung>0){
            // jika ada
            // verifikasi password
            if (password_verify($password,$passwordsekarang)){
                // jika password benar
                unset($_SESSION['failed']); //hapus failed
                unset($_SESSION['delayto']); //hapus delayto
                $_SESSION['username']=$username; //catat username
                header("location: home.php"); //ke halaman utama
            } else {
               //failed catat sudah berapa kali
               echo '
               <script>
                   alert("Login Gagal");
                   window.location.href="index.php"
               </script>
               ';
                if (!isset($_SESSION['failed'])) $_SESSION['failed']=0;
                $_SESSION['failed']++; //faileb bertambah

                //delay sebanyak 2 pangkat gagal
                $delay = pow(2,$_SESSION['failed']);
                $_SESSION['delayto'] = strtotime("+ {$delay} seconds");
                
            }

        } else{
            // jika gagal
            echo '
            <script>
                alert("LOGIN GAGAL");
                window.location.href="index.php"
            </script>
            ';
        }
    }
} 


?>