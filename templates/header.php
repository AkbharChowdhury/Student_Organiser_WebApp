<?php
declare(strict_types=1);

session_start();
define('LOGO', 'fas fa-book-reader');
define('CURRENT_FILE', htmlspecialchars($_SERVER['PHP_SELF']));
define('LOGO_TEXT', 'StudentPlanner');
define('PAGES', ['index', 'login', 'register']);
define('USER', ['profile', 'coursework', 'teachers', 'modulesAndTeacher', 'campus', 'calendar', 'dashboard']);
define('ADMIN', ['admin_dashboard']);
define('ERROR_PAGE', dirname(__FILE__, 2) . DIRECTORY_SEPARATOR . 'includes/error.inc.php');
require_once in_array($current_page, USER) || in_array($current_page, ADMIN) ?  '../includes/class-autoload.php' : 'includes/class-autoload.php';

Helper::currentPage($current_page);
Helper::setDirectory(true);

define('FILE_PATH', [

  'logo' => in_array($current_page, USER) || in_array($current_page, ADMIN) ?  '../img/logo.png' : 'img/logo.png',
  'calendar' => in_array($current_page, USER) ?  '../calendar/calendar.php' : 'calendar/calendar.php',
  'css' => in_array($current_page, USER) || in_array($current_page, ADMIN) ?  '../css/style.css' : 'css/style.css',
  'script' => in_array($current_page, USER) || in_array($current_page, ADMIN) ?  '../js/script.js' : 'js/script.js',
  'profile' => in_array($current_page, USER) ?  '../profile/profile.php' : 'profile/profile.php',
  'login' => in_array($current_page, USER) ?  '../login.php' : 'login.php',
  'logout' => in_array($current_page, USER) || in_array($current_page, ADMIN) ?  '../logout.inc.php' : 'logout.inc.php',
  'modulesAndTeachers' => in_array($current_page, USER) ?  '../teacherAndModules/modulesAndTeachers.php' : 'teacherAndModules/modulesAndTeachers.php',
  'campus' => in_array($current_page, USER) ?  '../campus/campus.php' : 'campus/campus.php',
  'coursework' => in_array($current_page, USER) ?  '../coursework/coursework.php' : 'coursework/coursework.php',
  'dashboard' => in_array($current_page, USER)  || in_array($current_page, ADMIN) ?  '../dashboard/dashboard.php' : 'dashboard/dashboard.php',
  'admin_dashboard' => in_array($current_page, ADMIN)  || in_array($current_page, USER) ?  '../admin/admin_dashboard.php' : 'admin/admin_dashboard.php',

]);


if (!Helper::studentIsLoggedIn() && in_array($current_page, USER) || in_array($current_page, ADMIN)) Helper::userIsLoggedIn(FILE_PATH['login']);
if (isset($_GET['contact'])) $current_page = 'contact';


// check for admin access only
if (in_array($current_page, ADMIN) && !Helper::adminIsLoggedIn()) {
  $errorMessage = Helper::setRoleErrorMessage('Administrator');
  $homeLink = '<a href="' . FILE_PATH["dashboard"] . '" class="alert-link">Return to the student homepage</a>';

  require_once ERROR_PAGE;
  exit;
}

// check for student access only
if (in_array($current_page, USER) && Helper::adminIsLoggedIn()) {
  $errorMessage = Helper::setRoleErrorMessage('students');
  $homeLink = '<a href="' . FILE_PATH["admin_dashboard"] . '" class="alert-link">Return to the admin homepage</a>';
  require_once ERROR_PAGE;
  exit;
}


?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <!-- flat-picker CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- full Calender CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />

  <!-- font awesome -->
  <!-- <script src="https://kit.fontawesome.com/af0beca0d3.js"></script> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= FILE_PATH['css'] ?>">

  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css">

  <!-- TimePicker CSS -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <!-- DatePicker CSS -->
  <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
  <!-- Data-table CSS -->

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.4/datatables.min.css" />

  <!-- favicon -->
  <link rel="shortcut icon" href="<?= FILE_PATH['logo'] ?>">

  <title><?= $page_title ?></title>
</head>

<body data-spy="scroll" data-offset="15" data-target="#navbarSupportedContent">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">


    <div class="container-fluid">
      <a class="navbar-brand" href="<?= Helper::getHomeLink() ?>">
        <img src="<?= FILE_PATH['logo'] ?>" alt="Logo" class="d-inline-block align-text-top" width="30" height="24">
        <?= LOGO_TEXT ?>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

          <?php if (!Helper::studentIsLoggedIn() && !Helper::adminIsLoggedIn()) :  // public navbar links 
          ?>
            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('index') ?>" <?= Helper::ariaCurrent('index') ?> href="<?= !Helper::studentIsLoggedIn() ? 'index.php' : 'admin/' ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('contact') ?>" <?= Helper::ariaCurrent('contact') ?> href="index.php?contact#contact" data-target="#contact">Contact</a>
            </li>

          <?php elseif (Helper::adminIsLoggedIn()) : ?>
            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('admin_dashboard') ?>" <?= Helper::ariaCurrent('admin_dashboard') ?> href="<?= FILE_PATH['admin_dashboard'] ?>">Dashboard</a>
            </li>


          <?php else : // student logged-in pages 
          ?>
            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('dashboard') ?>" <?= Helper::ariaCurrent('dashboard') ?> href="<?= FILE_PATH['dashboard'] ?>">Dashboard</a>
            </li>

          <?php endif; ?>

          <?php if (Helper::studentIsLoggedIn()) : // nav-links for when user is logged in 
          ?>

            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('coursework') ?>" <?= Helper::ariaCurrent('coursework') ?> href="<?= FILE_PATH['coursework'] ?>">Coursework</a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('modulesAndTeacher') ?>" <?= Helper::ariaCurrent('modulesAndTeacher') ?> href="<?= FILE_PATH['modulesAndTeachers'] ?>">Modules & Teachers</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('calendar') ?>" <?= Helper::ariaCurrent('calendar') ?> href="<?= FILE_PATH['calendar'] ?>">Calendar</a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('campus') ?>" <?= Helper::ariaCurrent('campus') ?> href="<?= FILE_PATH['campus'] ?>">Campus</a>
            </li>

          <?php endif; ?>
        </ul>

        <ul class="navbar-nav ml-auto">
          <?php if (!Helper::studentIsLoggedIn() && !Helper::adminIsLoggedIn()) : // nav-links for when student/admin is not logged in 
          ?>

            <li class="nav-item">
              <a class="nav-link <?= Helper::activeLink('login') ?>" <?= Helper::ariaCurrent('login') ?> href="login.php">Login</a>
            </li>
            <button class="btn btn-success" type="button" onclick="window.location.href='register.php'">Register</button>
        </ul>
      <?php else : ?>

        <li class="nav-item dropdown">

          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile
          </a>

          <ul class="dropdown-menu dropdown-menu-darj dropdown-menu-end" aria-labelledby="navbarDropdown">
            <?php if (Helper::studentIsLoggedIn()) :  // show profile link page for student?>
              <li>
                <a class="dropdown-item <?= Helper::activeLink('profile') ?>" href="<?= FILE_PATH['profile'] ?>">My profile</a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="<?= FILE_PATH['logout'] ?>">Logout</a></li>
          </ul>
        </li>

      <?php endif; ?>


      <!-- <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
      </div>
    </div>
  </nav>