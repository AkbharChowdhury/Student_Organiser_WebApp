<?php
date_default_timezone_set('Europe/London');

final class Helper
{
    private function __construct()
    {
    }

    public static function titleCase($title): string
    {
        return str_contains('_', $title) ? ucwords(str_replace(search: "_", replace: " ", subject: $title)) : ucwords($title);

    }

    public static function rootDirectory($file)
    {
        return dirname($file) . '/../';

    }

    static function getTeacherSelected($module, $selectedModules, $teacher, $selectedTeachers)
    {
        return in_array($module['module_id'], $selectedModules) && in_array($teacher['teacher_id'], $selectedTeachers) ? 'checked' : '';
    }

    private static $directory = false; // default directory is false
    private static $disableSubmitBtn = false;

    private static $currentPage = null; // navbar active link

    public static function currentPage($currentPage)
    {
        self::$currentPage = $currentPage;
    }

    // get active navbar link
    public static function activeLink($link)
    {
        return self::$currentPage === $link ? 'active' : null;
    }

    // screen-reader for accessibility purposes
    public static function srOnly($link)
    {
        return self::$currentPage === $link ? '<span class="sr-only">(current)</span>' : null;
    }

    // adds aria-current attribute on the active .nav-link
    public static function ariaCurrent($link)
    {
        return self::$currentPage === $link ? 'aria-current="page"' : null;
    }

    // dynamic navbar
    public static function studentIsLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && !$_SESSION['admin_logged_in'];
    }

    public static function adminIsLoggedIn()
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];
    }


    // Check if the user is logged in, if not then redirect them to login page
    public static function userIsLoggedIn($loginFilePath)
    {

        if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] === false) {

            self::setWarningMessage('Please login to access the page you have requested');
            $_SESSION['redirect'] = $_SERVER['REQUEST_URI']; // get the current url of the page requested
            header('location: ' . $loginFilePath);
        }
    }

    public static function getDefaultColour()
    {
        return '#000000';
    }

    public static function getRequiredFieldMessage()
    {
        return '<p class="text-muted mt-3">All required fields are marked with <small class="text-danger">*</small></p>';
    }

    public static function formatDate($date)
    {
        return date('D d M Y', strtotime(self::html($date)));
    }

    public static function formatTCDate($date)
    {
        return date('F d, Y', strtotime($date));
    }

    // format date and time
    public static function formatDueDate($date)
    {
        return date('F d, Y h:ia', strtotime($date));
    }

    //
    public static function getModuleTooltip()
    {
        return "If you don't see your modules listed please assign a module to a teacher first from the teacher and modules page";
    }

    public static function getCampusTooltip()
    {
        return "If you don't see your campus listed please add a campus first";
    }

    /**Time methods  */
    public static function toMinutes($startTime, $endTime)
    {
        $startTime = strtotime($startTime);
        $endTime = strtotime($endTime);
        return round(abs($endTime - $startTime) / 60, 2);
    }

    public static function get12HourFormatTime($time)
    {
        return date('g:i A', strtotime($time));
    }

    public static function goTo($url)
    {
        echo '<script>window.location.href="' . $url . '"</script>';
    }


    public static function calculateDeadlineDate($deadline)
    {
        $currentDateTime = date_create(date('Y-m-d H:i:s'));
        $interval = date_diff($currentDateTime, date_create($deadline));
        return $interval->format('%m months and %d days and %h Hours and %i Minutes');
    }


    public static function cwDateColour($deadline, $status)
    {

        return match ($status) {
            'Not completed' => 'danger',
            'In progress', => 'warning',
            default => 'success'
        };



    }

    public static function showStatusColour($status)
    {

        return match ($status) {
            'Completed' => 'success',
            'in_progress', 'In progress' => 'warning',
            default => 'danger'
        };

    }


    public static function getPriorityMessage($priorityLevel)
    {


        return match (strtolower($priorityLevel)) {
            'high' => '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div>
              This task requires urgent attention! 
            </div>
          </div>
          ',
            'medium' => '<div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#info-fill"/></svg>
            <div>
              Please check if you are on progress! 
            </div>
          </div>
          ',
            'low' => '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
              This task requires low attention
            </div>
          </div>
          ',
            default => '',
        };
    }

    public static function overDueCW($due)
    {
        $currentDateTime = date("Y-m-d H:i:s");
        $dueDate = date('Y-m-d H:i:s', strtotime($due));
        if ($dueDate < $currentDateTime) return 'disabled';
    }

    public static function dueDateMsg($deadline)
    {
        $current = strtotime(date("Y-m-d"));
        $date = strtotime($deadline);

        $dateDiff = $date - $current;
        $difference = floor($dateDiff / (60 * 60 * 24));
        if ($difference == 0) return 'today';
        if ($difference == 1) return 'tomorrow';
        if ($difference < -1) return 'Overdue';

    }


    public static function formatTime($timeInMinutes)
    {

        $timeInMinutes = (int)$timeInMinutes;

        if (floor($timeInMinutes / 60 < 1)) {
            // check for one minute
            if ($timeInMinutes === 1) {
                return ($timeInMinutes) . ' minute';
            }
            // minutes only
            return ($timeInMinutes % 60) . ' minutes';
        }
        if ($timeInMinutes % 60 === 0) {
            // only for 1 hour
            return floor($timeInMinutes / 60) . ' hour';
        } else if (floor($timeInMinutes >= 60 && $timeInMinutes < 120)) {
            // includes over 1 hour but less than 2 hours
            return floor($timeInMinutes / 60) . ' hour ' . ($timeInMinutes % 60) . ' minutes';
        }
        // display default duration
        return floor($timeInMinutes / 60) . ' hours ' . ($timeInMinutes % 60) . ' minutes';
    }


    public static function setErrorMessage($message)
    {
        $_SESSION['message'] = $message;
        $_SESSION['msg_type'] = 'danger';
        $_SESSION['msg_icon'] = 'exclamation-triangle-fill';
    }

    public static function setSuccessMessage($message)
    {
        $_SESSION['message'] = $message;
        $_SESSION['msg_type'] = 'success';
        $_SESSION['msg_icon'] = 'check-circle-fill';
    }

    public static function setWarningMessage($message)
    {

        $_SESSION['message'] = $message;
        $_SESSION['msg_type'] = 'warning';
        $_SESSION['msg_icon'] = 'exclamation-triangle-fill';
    }

    public static function setRoleErrorMessage($message)
    {

        return 'Only ' . $message . ' can access this page!';
    }

    // Default coursework colour for academic calendar
    public static function getCourseworkColour()
    {
        return 'red';
    }


    // sanitize data and output html.
    public static function html($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    // Check root directory for dynamic link/path - admin folder
    public static function path()
    {

        return self::$directory;
    }

    // set (file) directory - setter directory field
    public static function setDirectory($status)
    {
        self::$directory = $status;
    }


    public static function disableSubmit(): bool
    {
        return self::$disableSubmitBtn;
    }

    public static function getProfileDeleteMessage($db)
    {
        if (!empty($db->getDeletionDate($_SESSION['student_id']))) {
            $date = date('l jS \of F Y', strtotime($db->getDeletionDate($_SESSION['student_id'])));
            return $db->showErrorMessage("URGENT REMINDER: Your account will be deleted on <strong> {$date}</strong> Please login by this date to reactivate your account");
        }
    }

    public static function getMonth($monthName)
    {
        $monthNumber = date_parse($monthName)['month'];
        return strlen($monthNumber) == 1 ? '0' . $monthNumber : $monthNumber;

    }

    public static function getLastDayOfMonth($month)
    {
        return date_parse($month)['month'];

    }

    // Prevent the student editing others modules by redirecting
    public static function validateStudentModules($db)
    {

        $modules = $db->getStudentModuleID($_SESSION['student_id']);
        if (!in_array($_GET['editModule'], array_column($modules, 'module_id'))) {
            Helper::goTo('modulesAndTeachers.php');
        }
    }
    // check if student id is the same as session and prevent the user from editing other students except their own
    // for profile page
    public static function validateStudentID($db)
    {
        if ($_GET['editStudent'] !== $db->getStudentID($_SESSION['student_id'])) {
            $_GET['editStudent'] = $db->getStudentID($_SESSION['student_id']);
        }
    }

    public static function validateStudentCampus($db)
    {

        $campus = $db->getStudentCampusID($_SESSION['student_id']);
        if (!in_array($_GET['editCampus'], array_column($campus, 'campus_id'))) {
            Helper::goTo('campus.php');
        }
    }

    public static function getHomeLink()
    {

        if (!self::studentIsLoggedIn() && !self::adminIsLoggedIn()) return '.';
        if (self::adminIsLoggedIn()) return 'admin_dashboard.php';
        return FILE_PATH['dashboard'];
    }

    public static function checkStudentDeletion($email, $db)
    {
        $studentID = $db->getStudentID(trim($email));
        $accountDelete = $db->getDeletionDate($studentID);
        if ($accountDelete !== false) {
            $dateNow = time(); //current timestamp
            $date_convert = strtotime($accountDelete);
            if ($dateNow > $date_convert) $db->deleteAccount($studentID);
        }
    }


    public static function breadcrumb($page, $homeLink = '.')
    { ?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $homeLink ?>">Home</a></li>
                <li class="breadcrumb-item text-capitalize active" aria-current="page"><?= $page; ?></li>
            </ol>
        </nav>
        <?php
    }
}
