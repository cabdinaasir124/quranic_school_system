<?php 
// session_start();
// include("../connection/conn.php");
// // Authentication
// if(isset($_SESSION['activeAdmin']))
// {
//     // header("location:../admin");
//     // exit();
// }
// else if(isset($_SESSION['activeTeacher']))
// {
//     header("location:../teacher");
//     exit();

// }
// else if(isset($_SESSION['activeParent']))
// {
//     header("location:../parent");
//     exit();
// }
// else if(isset($_SESSION['activeAtt']))
// {
//     header("location:../att");
//     exit();
// }
// else
// {
//     header("location:../auth");
//     exit();
// }

// $userId = $_SESSION['userId'];
// $select = mysqli_query($conn , "SELECT * FROM users WHERE userId='$userId'");
// if($select && mysqli_num_rows($select)>0)
// {
//     $row = mysqli_fetch_assoc($select);
//     $userName = $row['userName'];
//     $userEmail = $row['userEmail'];
//     $userStatus = $row['userStatus'];
//     $userRole = $row['userRole'];
//     $userImage = $row['userImage'] ?: "https://img.freepik.com/premium-vector/user-icons-includes-user-icons-people-icons-symbols-premiumquality-graphic-design-elements_981536-526.jpg?semt=ais_hybrid";
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/feather/feather.css">
    <link rel="stylesheet" href="../assets/plugins/icons/flags/flags.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
    
</head>
<style>
   /* Hide Google Translate toolbar */
.goog-logo-link,
.goog-te-gadget span,
.VIpgJd-ZVi9od-ORHb-OEVmcd {
  display: none !important;
}

/* Hide the "powered by" link */
.goog-te-banner-frame.skiptranslate {
  display: none !important;
}
body {
  top: 0px !important;
}
 
</style>
<body>

    <div class="main-wrapper">
        
    <div class="header">

<div class="header-left">
    <a href="../Admin/" class="logo">
        <img src="../assets/img/logo.png" alt="Logo">
    </a>
    <a href="../Admin/" class="logo logo-small">
        <img src="../assets/img/logo-small.png" alt="Logo" width="30" height="30">
    </a>
</div>
<div class="menu-toggle">
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fas fa-bars"></i>
    </a>
</div>

<div class="top-nav-search">
    <form>
        <input type="text" class="form-control" placeholder="Search here">
        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    </form>
</div>
<a class="mobile_btn" id="mobile_btn">
    <i class="fas fa-bars"></i>
</a>

<ul class="nav user-menu">
    <li class="nav-item dropdown noti-dropdown language-drop me-2">
        <!-- Google Translate dropdown -->
        <div id="google_translate_element"></div>
    </li>

    <li class="nav-item dropdown noti-dropdown me-2">
        <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
            <img src="../assets/img/icons/header-icon-05.svg" alt="">
        </a>
        <div class="dropdown-menu notifications">
            <div class="topnav-dropdown-header">
                <span class="notification-title">Notifications</span>
                <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
            </div>
            <div class="noti-content">
                <ul class="notification-list">
                    <li class="notification-message">
                        <a href="#">
                            <div class="media d-flex">
                                <span class="avatar avatar-sm flex-shrink-0">
                                    <img class="avatar-img rounded-circle" alt="User Image"
                                        src="../assets/img/profiles/avatar-02.jpg">
                                </span>
                                <div class="media-body flex-grow-1">
                                    <p class="noti-details"><span class="noti-title">Carlson Tech</span> has
                                        approved <span class="noti-title">your estimate</span></p>
                                    <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="#">
                            <div class="media d-flex">
                                <span class="avatar avatar-sm flex-shrink-0">
                                    <img class="avatar-img rounded-circle" alt="User Image"
                                        src="../assets/img/profiles/avatar-11.jpg">
                                </span>
                                <div class="media-body flex-grow-1">
                                    <p class="noti-details"><span class="noti-title">International Software
                                            Inc</span> has sent you a invoice in the amount of <span
                                            class="noti-title">$218</span></p>
                                    <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="#">
                            <div class="media d-flex">
                                <span class="avatar avatar-sm flex-shrink-0">
                                    <img class="avatar-img rounded-circle" alt="User Image"
                                        src="../assets/img/profiles/avatar-17.jpg">
                                </span>
                                <div class="media-body flex-grow-1">
                                    <p class="noti-details"><span class="noti-title">John Hendry</span> sent
                                        a cancellation request <span class="noti-title">Apple iPhone
                                            XR</span></p>
                                    <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="notification-message">
                        <a href="#">
                            <div class="media d-flex">
                                <span class="avatar avatar-sm flex-shrink-0">
                                    <img class="avatar-img rounded-circle" alt="User Image"
                                        src="../assets/img/profiles/avatar-13.jpg">
                                </span>
                                <div class="media-body flex-grow-1">
                                    <p class="noti-details"><span class="noti-title">Mercury Software
                                            Inc</span> added a new product <span class="noti-title">Apple
                                            MacBook Pro</span></p>
                                    <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="topnav-dropdown-footer">
                <a href="#">View all Notifications</a>
            </div>
        </div>
    </li>

    <li class="nav-item zoom-screen me-2">
        <a href="#" class="nav-link header-nav-list win-maximize">
            <img src="../assets/img/icons/header-icon-04.svg" alt="">
        </a>
    </li>

    <li class="nav-item dropdown has-arrow new-user-menus">
        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
            <span class="user-img">
                <img class="rounded-circle" src="../assets/img/logo.png" width="31"
                    alt="">
                <div class="user-text">
                    <h6>></h6>
                    <p class="text-muted mb-0"></p>
                </div>
            </span>
        </a>
        <div class="dropdown-menu">
            <div class="user-header">
                <div class="avatar avatar-sm">
                    <img src="../assets/img/logo.png" alt="User Image"
                        class="avatar-img rounded-circle">
                </div>
                <div class="user-text">
                    <h6></h6>
                    <p class="text-muted mb-0"></p>
                </div>
            </div>
            <a class="dropdown-item" href="profile.php">My Profile</a>
            <a class="dropdown-item" href="Account.php">Account</a>
            <a class="dropdown-item" href="../auth/logout.php">Logout</a>
        </div>
    </li>

</ul>

</div>

