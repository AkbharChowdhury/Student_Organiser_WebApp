<?php

/**
 * @author Akbhar Chowdhury
 * @description Akbhar Chowdhury StudentPlanner website
 */

use Dotenv\Dotenv as Dotenv;

final class Database {

    private $con;
    private $lastID;
    private $data = [];
    private static $instance = null;
    private $errorMessage;
    private $isUniDays = true;

    // search functionality
    private const RECORDS_PER_PAGE = 6;
    private $start, $pageNumber;
    private $productQuery;
    private $courseworkCount;
    private $moduleID;
    private $courseworkTitleSearch;
    private $studentID;
    private $relatedCoursework = [];


    private function __construct() {
    }



    public static function getInstance() {
        return self::$instance === null ? self::$instance = new Database : self::$instance;
    }
    // search functionality functions

    private function getPageNumber() {

        return $this->pageNumber == 1 ? $_SESSION['existing_coursework'] = rand(1, 10) : $_SESSION['existing_coursework'];
    }

    public function setPageNumber($pageNumber) {
        $this->pageNumber = $pageNumber;
    }
    public function getRecordsPerPage() {
        return self::RECORDS_PER_PAGE;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function setModuleID($moduleID) {
        $this->moduleID = $moduleID;
    }
    public function setCourseworkTitle($title) {
        $this->courseworkTitleSearch = $title;
    }


    // search results
    function getCourseworkSearchResults() {
        $this->productQuery = "SELECT
	        cw.*,
	        m.module_code,
	        m.module_name,
	        n.image,
	        s.status_level,
	        col.colour_class AS status_colour,
	        s.status_description,
	        p.priority_level
	    FROM
	        Coursework cw
	    JOIN Modules m ON
	        m.module_id = cw.module_id
	    LEFT JOIN Notes n ON
	        n.coursework_id = cw.coursework_id
	    LEFT JOIN Priority p ON
	        p.priority_id = cw.priority_id
	    LEFT JOIN `Status` s ON
	        s.status_id = cw.status_id
	    LEFT JOIN Colours col ON
	        col.colour_id = s.colour_id
	    LEFT JOIN Colours col_priority ON
	        col_priority.colour_id = p.colour_id
	    WHERE TRUE";



        $this->moduleSelected(' AND m.module_id = :module_id', $this->productQuery);
        $this->searchCourseworkTitle(' AND cw.title LIKE :title', $this->productQuery);
        $this->studentID(' AND m.student_id = :student_id', $this->productQuery);

        $this->productQuery .= ' LIMIT ' . $this->start . ', ' . self::RECORDS_PER_PAGE;
        $stmt = $this->getConnection()->prepare($this->productQuery);
        $stmt->execute($this->data);
        return $stmt->fetchAll();
    }
    // count search results
    function getCourseworkCount() {
        $this->courseworkCount = 'SELECT
        COUNT(cw.coursework_id) AS `coursework_total`
    FROM
        Coursework cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    WHERE
        TRUE';

        $this->moduleSelected(' AND m.module_id = :module_id', $this->courseworkCount);
        $this->searchCourseworkTitle(' AND cw.title LIKE :title', $this->courseworkCount);
        $this->studentID(' AND m.student_id = :student_id', $this->courseworkCount);



        $stmt = $this->getConnection()->prepare($this->courseworkCount);
        $stmt->execute($this->data);
        $row = $stmt->fetch();

        return $row['coursework_total'];
    }

    private function moduleSelected($filter, $args) {

        if (!empty($this->moduleID)) {
            $this->filterCourseworkResults($filter, $args);
            $this->data[':module_id'] = $this->moduleID;
        }
    }

    private function studentID($filter, $args) {

        if (isset($_SESSION['student_id'])) {
            $this->filterCourseworkResults($filter, $args);
            $this->data[':student_id'] = $_SESSION['student_id'];
        }
    }


    private function searchCourseworkTitle($filter, $args) {
        if (!empty($this->courseworkTitleSearch)) {
            $this->filterCourseworkResults($filter, $args);
            $this->data[':title'] = '%' . $this->courseworkTitleSearch . '%';
        }
    }
    private function filterCourseworkResults($filter, $args) {
        if ($args === $this->productQuery) {
            $this->productQuery .= $filter;
            return;
        }
        $this->courseworkCount .= $filter;
    }


    function relatedCourseworkResults($moduleID) {
        $sql = "SELECT
        cw.*,
        m.module_code,
        m.module_name,
        n.image,
        s.status_level,
        col.colour_class AS status_colour,
        s.status_description,
        p.priority_level
    FROM
        Coursework cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    LEFT JOIN Notes n ON
        n.coursework_id = cw.coursework_id
    LEFT JOIN Priority p ON
        p.priority_id = cw.priority_id
    LEFT JOIN `Status` s ON
        s.status_id = cw.status_id
    LEFT JOIN Colours col ON
        col.colour_id = s.colour_id
    LEFT JOIN Colours col_priority ON
        col_priority.colour_id = p.colour_id
    WHERE TRUE";

        $sql .= ' AND m.student_id = :student_id';
        // $this->relatedCoursework[':student_id'] = $x;

        if (!isset($_SESSION)) session_start();

        if (!empty($moduleID)) {
            $sql .= ' AND cw.module_id = :module_id';
            $this->relatedCoursework[':module_id'] = $moduleID;
        }

        $sql .= ' LIMIT 5';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        if (!empty($moduleID)) $stmt->bindParam(':module_id', $moduleID);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getModuleCoursework() {
        $sql = "SELECT
        m.student_id,
        m.module_id,
        m.module_code,
        m.module_name
    FROM
        Coursework cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    WHERE
        m.student_id = :student_id
    GROUP BY
        m.module_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

//    private function getConnection() {
//        try {
//            $config = [
//                'host' => 'localhost',
//                'username' => 'root',
//                'password' => '',
//                'databaseName' => 'AC_StudentOrganiser',
//                'charset' => 'charset=utf8'
//            ];
//            $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['databaseName'] . ';' . $config['charset'];
//            $this->con = new PDO($dsn, $config['username'], $config['password']);
//            $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//            return $this->con;
//        } catch (PDOException $e) {
//
//            echo $this->showErrorMessage('There was an error connecting to the database <br> ' . $e->getMessage());
//        }
//    }



    private function loadENV(){
        $rootDir = Helper::rootDirectory(__FILE__);
        require_once $rootDir .'/vendor/autoload.php';
        $dotenv = Dotenv::createImmutable($rootDir);
        $dotenv->load();
    }

    private function getConnection() {
        try {
            $this->loadENV();

            $config = [
                'host' => $_ENV['HOST'] ?? 'no host',
                'username' => $_ENV['USERNAME'] ?? 'no username',
                'password' => $_ENV['PASSWORD'] ?? 'no password',
                'databaseName' => $_ENV['DB_NAME'] ?? 'no db name',
                'charset' => $_ENV['CHARSET'] ?? 'no charset'
            ];
            $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['databaseName'] . ';' . $config['charset'];
            $this->con = new PDO($dsn, $config['username'], $config['password']);
            $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->con;
        } catch (PDOException $e) {

            echo $this->showErrorMessage('There was an error connecting to the database <br> ' . $e->getMessage());
        }
    }
    public function showErrorMessage($message) {
        return '
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>
    <div class="container py-5">
        <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
            ' . $message . '
        </div>
    </div>
    </div>
        ';
    }

    public function addData(string $key, $val) {
        $this->data[$key] = $val;
        return $this;
    }


    public function getData(string $key) {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        throw new Exception($key . ' does not exists');
    }

    public function resetData() {
        $this->data = [];
    }
    public function isUniDays($status) {
        $this->isUniDays = $status;
    }


    public function getColours() {
        return $this->getConnection()->query('SELECT * FROM `Colours`')->fetchAll();
    }


    // login functionality 
    public function databaseContainsStudent() {
        $sql = "SELECT COUNT(*) AS `student_found` FROM `Students` WHERE `email` = :email AND `password` = :password";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($this->data);
        $row = $stmt->fetch();
        $this->errorMessage = !$row['student_found'] > 0 ? 'incorrect email and password combination' : '';
        return $row['student_found'] > 0 ? true : false;
    }

    public function databaseContainsAdmin() {
        $sql = "SELECT COUNT(*) AS `admin_found` FROM `Admin` WHERE `username` = :username AND `password` = :password";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($this->data);
        $row = $stmt->fetch();
        $this->errorMessage = !$row['admin_found'] > 0 ? 'incorrect username and password combination' : '';
        return $row['admin_found'] > 0 ? true : false;
    }
    public function emailIsCorrect($email) {
        $sql = "SELECT COUNT(*) AS `email_found` FROM `Students` WHERE `email` = :email";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['email_found'] > 0 ? true : false;
    }


    public function isAccountSuspended($email) {

        $sql = "SELECT COUNT(`student_id`) AS account_suspended 
                FROM `AccountSuspended` WHERE `student_id` = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $this->getStudentID($email));
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['account_suspended'] > 0 ? true : false;
    }



    public function suspendAccount($email, $reason) {

        $sql = 'INSERT INTO `AccountSuspended` 
        SET 
        `student_id` = :student_id, 
        `reason` = :reason';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $this->getStudentID($email));
        $stmt->bindParam(':reason', $reason);
        return $stmt->execute();
    }

    public function deactivateAccount($deletionDate) {
        $sql = 'INSERT INTO `AccountDeletionDate` 
        SET 
        `student_id` = :student_id, 
        `deletion_date` = :deletion_date';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':deletion_date', $deletionDate);
        return $stmt->execute();
    }

    public function getDeletionDate($studentID) {
        $sql = "SELECT `deletion_date` FROM `AccountDeletionDate` WHERE `student_id` = :student_id LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $studentID);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function activateAccount($studentID) {
        $sql = "DELETE FROM AccountDeletionDate WHERE student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $studentID);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getStudentID($email) {
        $sql = "SELECT `student_id` FROM `Students` WHERE `email` = :email LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getErrorMessage() {
        return $this->errorMessage;
    }


    public function studentEmailExists($email) {
        $sql = 'SELECT COUNT(*) AS `email_found` FROM `Students` WHERE `email` = :email';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['email_found'] > 0 ? true : false;
    }

    public function getProfileComPref() {

        $sql = 'SELECT
        cp.*,
        p.type
    FROM
        CommunicationPreferences cp
    JOIN Preferences p ON
        cp.pref_id = p.pref_id
    WHERE
        student_id = :student_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateProfile() {
        $sql = "UPDATE `Students`
                SET
                    `firstname` = :firstname,
                    `lastname` = :lastname,
                    `email` = :email,
                    `phone` = :phone
                WHERE
                    student_id = :student_id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }

    public function updatePassword($password) {
        $sql = "UPDATE `Students`
                SET
                    `password` = SHA(:password)
                WHERE
                    student_id = :student_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);

        return $stmt->execute();
    }

    public function deletePreferences() {
        // delete all the checklist first from the associated coursework
        $sql = "DELETE FROM `CommunicationPreferences` WHERE `student_id` = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":student_id", $_SESSION['student_id']);
        $stmt->execute();
    }

    public function deleteModuleTeachers($moduleID) {
        // delete all the checklist first from the associated coursework
        $sql = "DELETE FROM `ModuleTeachers` WHERE `module_id` = :module_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":module_id", $moduleID);
        $stmt->execute();
    }
    public function deleteAccount($studentID) {
        // delete all the checklist first from the associated coursework
        $sql = "DELETE FROM `Students` WHERE `student_id` = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":student_id", $studentID);
        $stmt->execute();
    }

    public function updatePreferences($communicationList) {
        $this->deletePreferences();

        if (!empty($communicationList)) {

            foreach ($communicationList as $k => $v) {

                $sql = 'INSERT INTO `CommunicationPreferences` 
                SET 
                `student_id` = :student_id, 
                `pref_id` = :pref_id';
                $stmt = $this->getConnection()->prepare($sql);
                $stmt->bindParam(':student_id', $_SESSION['student_id']);
                $stmt->bindParam(':pref_id', $_POST['communication'][$k]);
                $stmt->execute();
            }
        }

        return true;
    }
    public function getCWStatus() {
        $sql = 'SELECT
        s.status_level,
        COUNT(s.status_level) AS `total`,
        col.colour_class
    FROM
        `Coursework` cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    LEFT JOIN `Status` s ON
        cw.status_id = s.status_id
    LEFT JOIN Colours col ON
        s.colour_id = col.colour_id
    JOIN Students st ON
        m.student_id = st.student_id
    WHERE
        st.student_id = :student_id
    GROUP BY
        cw.status_id';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function addStudent() {

        $sql = "INSERT INTO `Students`
                 SET `firstname` = :firstname, 
                    `lastname` = :lastname, 
                    `email` = :email, 
                    `phone` = :phone, 
                    `password` = SHA(:password)";
        $this->getConnection()->prepare($sql)->execute($this->data);


        $this->lastID = $this->con->lastInsertId();
        return true;
    }
    function getLastID() {
        return $this->lastID;
    }
    public function getCommunicationPrefs() {

        return $this->getConnection()->query('SELECT * FROM `Preferences`')->fetchAll();
    }


    public function addCommunicationPreferences(array $communicationList) {


        foreach ($communicationList as $k => $v) {


            $sql = 'INSERT INTO `CommunicationPreferences` 
                SET `student_id` = :student_id, 
                `pref_id` = :pref_id';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':student_id', $this->lastID);
            $stmt->bindParam(':pref_id', $v);
            $stmt->execute();
        }
        return true;
    }



    /**************** Modules ************ */
    public function getStudentModuleID($studentID) {
        $sql = "SELECT `module_id` FROM `Modules` WHERE `student_id` = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $studentID);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getTotalModules() {
        $sql = 'SELECT COUNT(*) AS modules_found FROM Modules WHERE student_id = :student_id';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['modules_found'];
    }



    public function getModules() {
        $sql = "SELECT * FROM `Modules` WHERE student_id = :student_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateModule() {
        $sql = "UPDATE `Modules`
                SET
                    `module_code` = :module_code,
                    `module_name` = :module_name
                WHERE
                    module_id = :module_id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }

    public function deleteModule($moduleID) {
        $sql = "DELETE FROM Modules WHERE module_id = :module_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':module_id', $moduleID);
        return $stmt->execute();
    }


    public function deleteTeacherModule($moduleID, $teacherID) {
        $sql = "DELETE FROM `ModuleTeachers` WHERE `module_id` = :module_id AND `teacher_id` = :teacher_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':module_id', $moduleID);
        $stmt->bindParam(':teacher_id', $teacherID);
        return $stmt->execute();
    }

    public function deleteClass($classID) {
        $sql = "DELETE FROM Classes WHERE class_id = :class_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':class_id', $classID);
        return $stmt->execute();
    }
    public function deletePersonalEvent($personalEventID) {
        $sql = "DELETE FROM `PersonalCalendar` WHERE `personal_calendar_id` = :personal_calendar_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':personal_calendar_id', $personalEventID);
        return $stmt->execute();
    }

    public function getModuleDetails($moduleID) {
        $sql = "SELECT * FROM `Modules` WHERE student_id = :student_id AND module_id = :module_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':module_id', $moduleID);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addModule() {

        $sql = "INSERT INTO `Modules`
                 SET 
                 `module_code` = :module_code, 
                 `module_name` = :module_name, 
                 `student_id` = :student_id";
        return $this->getConnection()->prepare($sql)->execute($this->data);
    }
    public function duplicateModule($moduleCode) {
        $sql = 'SELECT COUNT(*) AS `module_found` FROM `Modules` WHERE `student_id` = :student_id AND module_code = :module_code';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':module_code', $moduleCode);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['module_found'] > 0 ? true : false;
    }

    public function duplicateModuleName($name) {
        $sql = 'SELECT COUNT(*) AS `module_found`
                FROM `Modules` 
                WHERE `student_id` = :student_id 
                AND module_name = :module_name';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':module_name', $name);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['module_found'] > 0 ? true : false;
    }


    

    /**************** Teachers ************ */
    public function getTeachers() {
        $sql = "SELECT * FROM Teachers WHERE student_id = :student_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteTeacher($teacherID) {
        $sql = "DELETE FROM Teachers WHERE teacher_id = :teacher_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacherID);
        return $stmt->execute();
    }

    public function countTeachers() {
        $sql = 'SELECT COUNT(*) AS teacher_count FROM Teachers WHERE student_id = :student_id';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['teacher_count'];
    }


    public function getTotalTeachers() {
        $sql = 'SELECT
        COUNT(*) AS modules_found
    FROM
        Modules m
    JOIN Students s ON
        m.student_id = s.student_id
    WHERE
        m.student_id = :student_id';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['modules_found'] > 0 ? true : false;
    }


    public function addTeacher() {

        $sql = 'INSERT INTO `Teachers`
                 SET 
                 `student_id` = :student_id, 
                 `firstname` = :firstname, 
                 `lastname` = :lastname,
                 `email` = :email,
                 `colour_id` = :colour_id';

        return $this->getConnection()->prepare($sql)->execute($this->data);
    }

    public function getTeacherDetails($teacherID) {
        $sql = "SELECT
        t.*
    FROM
        Teachers t
    LEFT JOIN Colours col ON
        col.colour_id = t.colour_id
    JOIN Students st ON
        st.student_id = t.student_id
    WHERE
        t.teacher_id = :teacher_id AND st.student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacherID);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateTeacher() {
        $sql = "UPDATE `Teachers`
                SET
                    `firstname` = :firstname,
                    `lastname` = :lastname,
                    `email` = :email,
                    `colour_id` = :colour_id
                WHERE
                    teacher_id = :teacher_id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }



    public function duplicateTeacherModule($moduleID, $teacherID) {
        $sql = 'SELECT
        COUNT(*) AS duplicate_entry
        FROM
            ModuleTeachers
        WHERE
            module_id = :module_id AND teacher_id = :teacher_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':module_id', $moduleID);
        $stmt->bindParam(':teacher_id', $teacherID);

        $stmt->execute();
        $row = $stmt->fetch();
        return $row['duplicate_entry'] > 0 ? true : false;
    }

    public function addTeacherModule() {

        $sql = "INSERT INTO `ModuleTeachers`
                 SET `module_id` = :module_id, 
                 `teacher_id` = :teacher_id";
        return $this->getConnection()->prepare($sql)->execute($this->data);
    }

    //ModuleTeachers
    public function updateTeacherModule() {

        $sql = "UPDATE `ModuleTeachers` SET 
        `module_id` = :module_id,
        `teacher_id` = :teacher_id
        WHERE module_teacher_id = :module_teacher_id";
        $stmt = $this->getConnection()->prepare($sql);

        return $stmt->execute($this->data);
    }
    public function getModuleName($moduleID) {

        $sql = "SELECT CONCAT(module_code, ' ' ,module_name) AS module_info FROM Modules WHERE module_id = :module_id LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':module_id', $moduleID);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    public function getTeacherName($teacherID) {

        $sql = "SELECT CONCAT(firstname, ' ' ,lastname) AS teacher_name FROM Teachers WHERE teacher_id = :teacher_id LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacherID);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    public function getTeacherAndModulesDetails() {
        $sql = "SELECT
        st.student_id,
        CONCAT(st.firstname, ' ', st.lastname) AS student_name,
        mt.teacher_id,
        CONCAT(t.firstname, ' ', t.lastname) AS teacher_name,
        t.email,
        col.colour_class AS teacher_colour,
        mt.module_id,
        GROUP_CONCAT(m.module_name SEPARATOR ', ') AS modules_taught,
        COUNT(mt.module_id) AS total_modules
    FROM
        ModuleTeachers mt
    JOIN Teachers t ON
        mt.teacher_id = t.teacher_id
    JOIN Modules m ON
        mt.module_id = m.module_id
    JOIN Students st ON
        st.student_id = m.student_id
    LEFT JOIN Colours col ON
        col.colour_id = t.colour_id
    WHERE
        st.student_id = :student_id
    GROUP BY
        t.teacher_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    /*


        SELECT
    mt.*
FROM
    `ModuleTeachers` mt
JOIN Teachers t ON
    mt.teacher_id = t.teacher_id
JOIN Modules m ON
    mt.module_id = m.module_id
JOIN Students st ON
    st.student_id = m.student_id
WHERE
    st.student_id = 20




     */
    // for update and delete operation
    public function getTeacherAndModules() {
        $sql = "SELECT
        st.student_id,
        CONCAT(st.firstname, ' ', st.lastname) AS student_name,
        mt.teacher_id,
        CONCAT(t.firstname, ' ', t.lastname) AS teacher_name,
        col.colour_class AS colour,
        mt.module_teacher_id,
        mt.module_id,
        m.module_code,
        m.module_name
    FROM
        ModuleTeachers mt
    JOIN Teachers t ON
        mt.teacher_id = t.teacher_id
    JOIN Modules m ON
        mt.module_id = m.module_id
    JOIN Students st ON
        st.student_id = m.student_id
    LEFT JOIN Colours col ON
        t.colour_id = col.colour_id
    WHERE
        st.student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    // get distinct modules from the moduleTeachers table    
    public function getModulesTeacher() {
        $sql = "SELECT DISTINCT
        mt.module_id,
        m.module_code,
        m.module_name
    FROM
        ModuleTeachers mt
    JOIN Modules m ON
        m.module_id = mt.module_id
    JOIN Students st ON
        m.student_id = st.student_id
    WHERE
        st.student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    // get distinct teachers from the moduleTeachers table    
    public function getTeachersModule() {
        $sql = "SELECT DISTINCT
        mt.teacher_id,
        t.firstname,
        t.lastname
    FROM
        ModuleTeachers mt
    JOIN Teachers t ON
        mt.teacher_id = t.teacher_id
    JOIN Modules m ON
        m.module_id = mt.module_id
    JOIN Students st ON
        m.student_id = st.student_id
    WHERE
        st.student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTeacherAndModuleToUpdate() {
        $sql = "SELECT DISTINCT
        mt.teacher_id,
        t.firstname,
        t.lastname
    FROM
        ModuleTeachers mt
    JOIN Teachers t ON
        mt.teacher_id = t.teacher_id
    JOIN Modules m ON
        m.module_id = mt.module_id
    JOIN Students st ON
        m.student_id = st.student_id
    WHERE
        st.student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getPriority() {
        return $this->getConnection()->query('SELECT
        p.*,
        col.colour_class,
        col.hex_colour
    FROM
        Priority p
    LEFT JOIN Colours col ON
        col.colour_id = p.colour_id')->fetchAll();
    }

    public function getActivity() {
        return $this->getConnection()->query('SELECT
        actType.*,
        col.colour_class,
        col.hex_colour
    FROM
        ActivityType actType
    LEFT JOIN Colours col ON
        col.colour_id = actType.colour_id')->fetchAll();
    }

    public function getSemester() {
        return $this->getConnection()->query('SELECT * FROM `Semester` ORDER BY start_date ASC')->fetchAll();
    }
    public function getStatus() {
        return $this->getConnection()->query('SELECT
        s.*,
        col.colour_class,
        col.hex_colour
    FROM
        `Status` s
    LEFT JOIN Colours col ON
        col.colour_id = s.colour_id')->fetchAll();
    }

    public function getClassTypes() {
        return $this->getConnection()->query('SELECT * FROM `ClassTypes`')->fetchAll();
    }

    public function getDays() {
        $limit = '';
        if ($this->isUniDays) $limit = ' LIMIT 5';
        return $this->getConnection()->query("SELECT * FROM `Days`" . $limit)->fetchAll();
    }

    public function countUpcomingCourseworkByMonth() {

        $sql = "SELECT
        COUNT(cw.coursework_id) AS total
    FROM
        `Coursework` cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    LEFT JOIN `Notes` n ON
        n.coursework_id = cw.coursework_id
    LEFT JOIN Priority p ON
        p.priority_id = cw.priority_id
    LEFT JOIN `Status` s ON
        s.status_id = cw.status_id
    LEFT JOIN `Colours` col ON
        s.colour_id = col.colour_id
    LEFT JOIN `Colours` col_priority ON
        p.colour_id = col_priority.colour_id
    WHERE
        m.student_id = :student_id AND due_date BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND LAST_DAY(CURRENT_DATE)";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }

    public function getCourseworkStatusByMonth() {
        $sql = "SELECT
        m.student_id,
        IF(
            s.status_level = 'Completed',
            'Completed',
            'Completed'
        ) AS status_level_completed,
        COUNT(
            IF(
                cw.status_id = 1,
                cw.status_id,
                NULL
            )
        ) AS `total_completed`,
        IF(
            s.status_level = 'Not completed',
            'Not completed',
            'Not completed'
        ) AS `status_level_in_completed`,
        COUNT(
            IF(
                cw.status_id = 2,
                cw.status_id,
                NULL
            )
        ) AS `total_not_completed`,
        IF(
            s.status_level = 'In progress',
            'In progress',
            'In progress'
        ) AS `status_level_in_progress`,
        COUNT(
            IF(
                cw.status_id = 3,
                cw.status_id,
                NULL
            )
        ) AS `total_in_progress`,
        COUNT(cw.`coursework_id`) AS `total_number_of_coursework`
    FROM
        Coursework cw
    JOIN `Status` s ON
        s.status_id = cw.status_id
    JOIN Modules m ON
        m.module_id = cw.module_id
    WHERE
        m.student_id = :student_id AND due_date BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND LAST_DAY(CURRENT_DATE)";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getUpcomingCourseworkByMonth() {
        $sql = "SELECT
        cw.*,
        m.module_code,
        m.module_name,
        n.image,
        s.status_level,
        col.colour_class `status_colour`,
        p.priority_level,
        col_priority.colour_class AS `priority_colour`
    FROM
        `Coursework` cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    LEFT JOIN `Notes` n ON
        n.coursework_id = cw.coursework_id
    LEFT JOIN Priority p ON
        p.priority_id = cw.priority_id
    LEFT JOIN `Status` s ON
        s.status_id = cw.status_id
    LEFT JOIN `Colours` col ON
        s.colour_id = col.colour_id
    LEFT JOIN `Colours` col_priority ON
        p.colour_id = col_priority.colour_id
    WHERE
        m.student_id = :student_id AND due_date BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND LAST_DAY(CURRENT_DATE);";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public function getUpcomingEventsByMonth() {
        $sql = "SELECT
        pc.*,
        DATE_FORMAT(pc.end, '%m-%d-%Y') AS due_date,
        s.status_level,
        col.colour_class `status_colour`,
        p.priority_level,
        col_priority.colour_class AS `priority_colour`
    FROM
        PersonalCalendar pc
    LEFT JOIN Priority p ON
        p.priority_id = pc.priority_id
    LEFT JOIN `Status` s ON
        s.status_id = pc.status_id
    LEFT JOIN `Colours` col ON
        s.colour_id = col.colour_id
    LEFT JOIN `Colours` col_priority ON
        p.colour_id = col_priority.colour_id
    WHERE
        pc.student_id = :student_id AND DATE_FORMAT(pc.end, '%Y-%m-%d') BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND LAST_DAY(CURRENT_DATE)";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }




    // view checklist for pie chart
    function getCheckListDetails($courseworkID, $order = '') {
        $sql = "SELECT
                chk.*,
                s.status_level
            FROM
                Checklist chk
            JOIN `Status` s ON
                chk.status_id = s.status_id
            WHERE
                coursework_id = :coursework_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':coursework_id', $courseworkID);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    function countCheckListItemsByCW($courseworkID) {
        $sql = "SELECT
        IF(
            s.status_level = 'Completed',
            'Completed',
            'Completed'
        ) AS status_level_completed,
        COUNT(
            IF(
                chk.status_id = '1',
                chk.status_id,
                NULL
            )
        ) AS `total_completed`,
        IF(
            s.status_level = 'Not completed',
            'Not completed',
            'Not completed'
        ) AS `status_level_in_completed`,
        COUNT(
            IF(
                chk.status_id = '2',
                chk.status_id,
                NULL
            )
        ) AS `total_not_completed`,
        IF(
            s.status_level = 'In progress',
            'In progress',
            'In progress'
        ) AS `status_level_in_progress`,
        COUNT(
            IF(
                chk.status_id = '3',
                chk.status_id,
                NULL
            )
        ) AS `total_in_progress`,
        COUNT(chk.`checklist_id`) AS `total_items`
    FROM
        Checklist chk
    JOIN `Status` s ON
        s.status_id = chk.status_id
    WHERE
        chk.coursework_id = :coursework_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':coursework_id', $courseworkID);
        $stmt->execute();
        return $stmt->fetchAll();
    }




    function countCheckListItemsByCWPie($courseworkID) {
        $sql = "SELECT
        chk.*,
        s.status_level,
        COUNT(chk.`status_id`) AS status_total,
        col.hex_colour AS `status_colour`
    FROM
        `Checklist` chk
    JOIN `Status` s ON
        s.status_id = chk.`status_id`
    LEFT JOIN Colours col ON col.colour_id = s.status_id
    WHERE
        chk.`coursework_id` = :coursework_id
        
    GROUP BY s.status_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':coursework_id', $courseworkID);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalCheckListRows($courseworkID) {
        $sql = " SELECT
    st.student_id,
    CONCAT(st.firstname, ' ', st.lastname) AS student_name,
    chk.*,
    s.*,


    cw.title AS coursework_title
FROM
    Checklist chk
JOIN Coursework cw ON
    cw.coursework_id = chk.coursework_id
JOIN Modules m ON
    m.module_id = cw.module_id
JOIN Students st ON
    m.student_id = st.student_id
JOIN `Status` s ON
    s.status_id = chk.status_id
WHERE
    st.student_id = :student_id AND cw.coursework_id = :coursework_id";



        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':coursework_id', $courseworkID);

        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getCoursework() {

        $sql = "SELECT
        cw.*,
        m.module_code,
        m.module_name,
        n.image,
        s.status_level,
        col.colour_class AS status_colour,
        s.status_description,
        p.priority_level
    FROM
        Coursework cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    LEFT JOIN Notes n ON
        n.coursework_id = cw.coursework_id
    LEFT JOIN Priority p ON
        p.priority_id = cw.priority_id
    LEFT JOIN `Status` s ON
        s.status_id = cw.status_id
    LEFT JOIN Colours col ON
        col.colour_id = s.colour_id
    LEFT JOIN Colours col_priority ON
        col_priority.colour_id = p.colour_id
    WHERE
        m.student_id = :student_id
        ";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // coursework to edit
    public function getCourseworkDetails($courseworkID) {
        $sql = "SELECT
        cw.coursework_id,
        cw.module_id,
        cw.priority_id,
        cw.title,
        cw.description,
        cw.colour_tag,
        cw.due_date,
        cw.status_id,
        n.note_id,
        n.note_description,
        n.image,
        n.attachments,
        CONCAT(m.module_code, ' ', m.module_name) AS module_info
    FROM
        `Coursework` cw
    LEFT JOIN Notes n ON
        n.coursework_id = cw.coursework_id
    JOIN Modules m ON
        m.module_id = cw.module_id
    WHERE
        cw.coursework_id = :coursework_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':coursework_id', $courseworkID);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    // select cw checklist
    public function getCourseworkChecklist($courseworkID) {

        $sql = 'SELECT * FROM Checklist WHERE coursework_id = :coursework_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':coursework_id', $courseworkID);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteCourseworkID($courseworkID) {
        return $this->getConnection()->prepare('DELETE FROM `Coursework` WHERE coursework_id = :coursework_id')->execute([':coursework_id' => $courseworkID]);
    }

    public function deleteCheckListID($checklistID) {
        return $this->getConnection()->prepare('DELETE FROM `checklist` WHERE checklist_id = :checklist_id')->execute([':checklist_id' => $checklistID]);
    }

    public function addCoursework() {

        $sql = 'INSERT INTO `Coursework`
                 SET 
                 `module_id` = :module_id, 
                 `priority_id` = :priority_id, 
                 `title` = :title,
                 `description` = :description, 
                 `colour_tag` = :colour_tag, 
                 `due_date` = :due_date,
                `status_id` = :status_id';

        $stmt = $this->getConnection()->prepare($sql);
        if ($stmt->execute($this->data)) {
            $this->lastID = $this->con->lastInsertId();
            return true;
        }
        return false;
    }


    public function setCWStatusToCompleted($courseworkID) {
        // check if coursework id is valid
        $query = 'SELECT COUNT(coursework_id) AS coursework_found FROM Coursework WHERE coursework_id = :coursework_id';
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(':coursework_id', $courseworkID);
        $stmt->execute();
        $row = $stmt->fetch();
        if (intval($row['coursework_found']) === 0) return false;
        // update coursework status
        $sql = "UPDATE `Coursework` SET `status_id` = 1 WHERE coursework_id = :coursework_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':coursework_id', $courseworkID);
        return $stmt->execute();
    }


    public function setPCStatusToCompleted($personalCalendarID) {
        // check if personal calendar  id is valid
        $query = 'SELECT COUNT(personal_calendar_id) AS found FROM PersonalCalendar WHERE personal_calendar_id = :personal_calendar_id';
        $stmt = $this->getConnection()->prepare($query);
        $stmt->bindParam(':personal_calendar_id', $personalCalendarID);
        $stmt->execute();
        $row = $stmt->fetch();
        if (intval($row['found']) === 0) return false;
        // update personal calendar status
        $sql = "UPDATE `PersonalCalendar` SET `status_id` = 1 WHERE personal_calendar_id = :personal_calendar_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':personal_calendar_id', $personalCalendarID);
        return $stmt->execute();
    }
    public function addCourseworkNotes($notes, $image) {

        $sql = 'INSERT INTO `Notes`
                 SET `coursework_id` = :coursework_id, 
                 `note_description` = :note_description, 
                 `image` = :image';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':coursework_id', $this->lastID);
        $stmt->bindParam(':note_description', $notes);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function addCourseworkCheckList($checklistTitle) {


        foreach ($checklistTitle as $k => $title) {

            $sql = 'INSERT INTO `Checklist` 
                SET 
                `coursework_id` = :coursework_id, 
                `title` = :title,
                `due_date` = :due_date,
                `status_id` = :status_id
                ';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindParam(':coursework_id', $this->lastID);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':due_date', $_POST['checklist_due_date'][$k]);
            $stmt->bindParam(':status_id', $_POST['check_list_status'][$k]);
            $stmt->execute();
        }
        return true;
    }


    public function updateCoursework() {
        $sql = "UPDATE `Coursework`
                SET 
                `module_id` = :module_id, 
                 `priority_id` = :priority_id, 
                 `title` = :title,
                 `description` = :description, 
                 `colour_tag` = :colour_tag, 
                 `due_date` = :due_date,
                `status_id` = :status_id
                WHERE
                    coursework_id = :coursework_id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }

    public function updateCourseworkNotes() {
        $sql = "UPDATE `Notes`
                SET 
                 `note_description` = :note_description, 
                 `image` = :image
                WHERE
                    coursework_id = :coursework_id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }

    // delete checklist data first before inserting new values


    public function deleteCheckListItems($courseworkID) {
        $sql = "DELETE FROM `Checklist` WHERE `coursework_id` = :coursework_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":coursework_id", $courseworkID);
        $stmt->execute();
    }
    public function updateChecklist($courseworkID, $checklistTitle) {

        $this->deleteCheckListItems($courseworkID);

        foreach ($checklistTitle as $k => $title) {
            $sql = 'INSERT INTO `Checklist` 
            SET 
            `coursework_id` = :coursework_id, 
            `title` = :title,
            `due_date` = :due_date,
            `status_id` = :status_id';
            $stmt =  $this->getConnection()->prepare($sql);
            $stmt->bindParam(':coursework_id', $courseworkID);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':due_date', $_POST['checklist_due_date'][$k]);
            $stmt->bindParam(':status_id', $_POST['check_list_status'][$k]);
            $stmt->execute();
        }
    }




    public function getAcademicCalendar() {

        $sql = "SELECT
        st.student_id,
        CONCAT(st.firstname, ' ', st.lastname) AS student_name,
        GROUP_CONCAT(
            CONCAT(t.firstname, ' ', t.lastname) SEPARATOR ', '
        ) AS teacher_name,
        c.class_id,
        c.module_id,
        c.colour,
        m.module_code,
        m.module_name,
        c.day_id,
        d.day,
        c.room,
        c.type_id,
        ct.type,
        c.semester_id,
        s.name,
        s.start_date AS semester_start,
        s.end_date AS semester_end,
        c.start_time,
        c.end_time,
        c.colour,
        camp.campus_id,
        camp.campus
    FROM
        Classes c
    JOIN ClassTypes ct ON
        ct.type_id = c.type_id
    JOIN `Days` d ON
        d.day_id = c.day_id
    JOIN Semester s ON
        s.semester_id = c.semester_id
    JOIN Campuses camp ON
        camp.campus_id = c.campus_id
    JOIN ModuleTeachers mt ON
        mt.module_id = c.module_id
    JOIN Modules m ON
        m.module_id = mt.module_id
    JOIN Students st ON
        st.student_id = m.student_id
    JOIN Teachers t ON
        t.teacher_id = mt.teacher_id
    WHERE
        st.student_id = :student_id
    GROUP BY
        class_id
    ORDER BY
        mt.module_id";


        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function editClass($classID) {
        $sql = "SELECT
        st.student_id,
        CONCAT(st.firstname, ' ', st.lastname) AS student_name,
        CONCAT(t.firstname, ' ', t.lastname) AS teacher_name,
        c.class_id,
        c.module_id,
        m.module_code,
        m.module_name,
        c.room,
        c.day_id,
        d.day,
        c.type_id,
        ct.type,
        c.semester_id,
        s.start_date AS semester_start,
        s.end_date AS semester_end,
        c.start_time,
        c.end_time,
        c.colour,
        camp.campus_id,
        camp.campus
        
    FROM
        Classes c
    JOIN ClassTypes ct ON
        ct.type_id = c.type_id
    JOIN `Days` d ON
        d.day_id = c.day_id
    JOIN Semester s ON
        s.semester_id = c.semester_id
    JOIN Campuses camp ON
        camp.campus_id = c.campus_id
    JOIN ModuleTeachers mt ON
        mt.module_id = c.module_id
    JOIN Modules m ON
        m.module_id = mt.module_id
    JOIN Students st ON
        st.student_id = m.student_id
    JOIN Teachers t ON
        t.teacher_id = mt.teacher_id
    WHERE
        st.student_id = :student_id AND c.class_id = :class_id
    LIMIT 1
        ";


        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':class_id', $classID);


        $stmt->execute();
        return $stmt->fetchAll();
    }
    /**Personal calendar */


    public function getPersonalCalendarActivity() {

        $sql = "SELECT DISTINCT
        actType.activity_id,
        actType.type,
        colAct.hex_colour AS `activity_colour`
    FROM
        ActivityType actType
    LEFT JOIN Colours colAct ON
        colAct.colour_id = actType.colour_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public function getPersonalCalendar() {

        $sql = "SELECT
        pc.*,
        s.status_level,
        col.colour_class `status_colour`,
        p.priority_level,
        col_priority.colour_class AS `priority_colour`,
        actType.type,
        colAct.hex_colour AS `activity_colour`
    FROM
        PersonalCalendar pc
    LEFT JOIN Priority p ON
        p.priority_id = pc.priority_id
    LEFT JOIN `Status` s ON
        s.status_id = pc.status_id
    LEFT JOIN `Colours` col ON
        s.colour_id = col.colour_id
    LEFT JOIN `Colours` col_priority ON
        p.colour_id = col_priority.colour_id
    LEFT JOIN ActivityType actType ON
        actType.activity_id = pc.activity_id
    LEFT JOIN Colours colAct ON
        colAct.colour_id = actType.colour_id
    WHERE
        pc.student_id = :student_id";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updatePersonalCalendarEndDate() {
        $sql = "UPDATE `PersonalCalendar` SET  `start` = :start, `end` = :end WHERE `personal_calendar_id` = :personal_calendar_id";
        return $this->getConnection()->prepare($sql)->execute($this->data);
    }
    public function addPersonalCalendarDetails() {

        $sql = 'INSERT INTO `PersonalCalendar`
                 SET `student_id` = :student_id, 
                 `title` = :title, 
                 `description` = :description, 
                 `location` = :location,
                `start` = :start,
                `end` = :end,
                `status_id` = :status_id,
                `priority_id` = :priority_id,
                `activity_id` = :activity_id';

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }

    public function editPersonalCalendar($personalCalendarID) {
        $sql = "SELECT
        pc.*,
        p.priority_colour,
        s.status_level,
        col.colour_class `status_colour`,
        p.priority_level,
        actType.type,
        actType.colour_id,
        colAct.hex_colour AS `activity_colour`
    FROM
        PersonalCalendar pc
    LEFT JOIN Priority p ON
        p.priority_id = pc.priority_id
    LEFT JOIN `Status` s ON
        s.status_id = pc.status_id
    LEFT JOIN `Colours` col ON
        s.colour_id = col.colour_id
    LEFT JOIN `Colours` col_priority ON
        p.colour_id = col_priority.colour_id
    LEFT JOIN ActivityType actType ON
        pc.activity_id = actType.activity_id
    LEFT JOIN Colours colAct ON
        actType.colour_id = colAct.colour_id
    WHERE
        pc.personal_calendar_id = :personal_calendar_id
    LIMIT 1";


        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':personal_calendar_id', $personalCalendarID);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function updatePersonalCalendar() {

        $sql = "UPDATE `PersonalCalendar`
                 SET 
                 `title` = :title,
                 `description` = :description,
                 `location` = :location,
                 `start` = :start,
                 `end` = :end,
                 `status_id` = :status_id,
                 `priority_id` = :priority_id,
                 `activity_id` = :activity_id
                 WHERE `personal_calendar_id` = :personal_calendar_id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }




    // campuses
    public function getCampuses() {
        $sql = 'SELECT * FROM Campuses WHERE student_id = :student_id';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getStudentCampusID($studentID) {
        $sql = "SELECT `campus_id` FROM `Campuses` WHERE `student_id` = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $studentID);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function duplicateCampus($campus) {
        $sql = 'SELECT COUNT(*) AS `campus_found` 
        FROM `Campuses` 
        WHERE `student_id` = :student_id
        AND campus = :campus';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':campus', $campus);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['campus_found'] > 0 ? true : false;
    }


    public function getCampusesDetails($campusID) {
        $sql = 'SELECT * FROM Campuses WHERE campus_id = :campus_id';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':campus_id', $campusID);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getTotalCampuses() {
        $sql = 'SELECT COUNT(*) AS `campuses_found` FROM Campuses WHERE student_id = :student_id';

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['campuses_found'];
    }


    public function addCampus() {

        $sql = "INSERT INTO `Campuses`
                 SET `student_id` = :student_id, 
                    `campus` = :campus, 
                    `address` = :address, 
                    `city` = :city, 
                    `postcode` = :postcode";
        return $this->getConnection()->prepare($sql)->execute($this->data);
    }
    public function deleteCampus($campusID) {
        return $this->getConnection()->prepare('DELETE FROM `Campuses` WHERE campus_id = :campus_id')->execute(['campus_id' => $campusID]);
    }

    public function updateCampus() {

        $sql = "UPDATE `Campuses` SET `campus` = :campus, `address` = :address, `address` = :address ,`city` = :city  WHERE `campus_id` = :campus_id";
        return $this->getConnection()->prepare($sql)->execute($this->data);
    }


    public function duplicateClasses($moduleID, $typeID, $semesterID) {
        $sql = 'SELECT COUNT(*) AS `duplicate_modules_classes` FROM `Classes` WHERE 
        `module_id` = :module_id 
        AND `type_id` = :typeID
        AND `semester_id` = :semester_id
        ';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':module_id', $moduleID);
        $stmt->bindParam(':typeID', $typeID);
        $stmt->bindParam(':semester_id', $semesterID);

        $stmt->execute();
        $row = $stmt->fetch();
        return $row['duplicate_modules_classes'] > 0 ? true : false;
    }

    public function addClassDetails() {

        $sql = 'INSERT INTO `Classes`
                 SET `module_id` = :module_id, 
                 `semester_id` = :semester_id, 
                 `campus_id` = :campus_id, 
                 `day_id` = :day_id, 
                 `start_time` = :start_time,
                `end_time` = :end_time,
                `room` = :room,
                `colour` = :colour,
                `type_id` = :typeID
                ';

        $stmt = $this->getConnection()->prepare($sql);
        if ($stmt->execute($this->data)) {
            return true;
        }
        return false;
    }



    public function updateClassDetails() {

        $sql = "UPDATE `Classes`
                 SET 
                 `module_id` = :module_id,
                 `semester_id` = :semester_id,
                 `campus_id` = :campus_id,
                 `day_id` = :day_id,
                 `start_time` = :start_time,
                 `end_time` = :end_time,
                 `room` = :room,
                 `colour` = :colour,
                 `type_id` = :typeID
                 WHERE `class_id` = :class_id";

        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }


    // visualisation
    public function getTotalYearlyCW($startDate) {

        $sql = "SELECT DISTINCT
        DATE_FORMAT(due_date, '%M %Y') AS `month`,
        COUNT(coursework_id) AS total
    FROM
        `Coursework` cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    WHERE
        m.student_id = :student_id AND due_date BETWEEN :start_date AND CONCAT(YEAR(CURDATE()),'-08-01')
    GROUP BY
        MONTH(cw.due_date)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalYearlyCWByMonth($start, $end) {

        $sql = "SELECT
        CONCAT(module_code, ' ' ,module_name) AS module,
        COUNT(coursework_id) AS total
    FROM
        Coursework cw
    JOIN Modules m ON
        m.module_id = cw.module_id
    WHERE
        student_id = :student_id AND due_date BETWEEN :start AND :end
    GROUP BY
        cw.due_date";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);

        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function communicationType($type) {
        $sql = "SELECT
        COUNT(p.type) AS found
    FROM
        CommunicationPreferences cp
    JOIN Preferences p ON
        p.pref_id = cp.pref_id
    WHERE
        cp.student_id = :student_id AND type = :type";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['found'] > 0 ? true : false;
    }

    public function getPhoneNumber() {
        $sql = "SELECT `phone` FROM `Students` WHERE `phone` = :phone AND student_id = :student_id LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


    public function getTotalYearlyPCActivities($startDate) {

        $sql = "SELECT
        student_id,
        DATE_FORMAT(pc.end, '%M %Y') AS `month`,
        IF(
            s.status_level = 'Completed',
            'Completed',
            'Completed'
        ) AS status_level_completed,
        COUNT(
            IF(
                pc.status_id = 1,
                pc.status_id,
                NULL
            )
        ) AS `total_completed`,
        IF(
            s.status_level = 'Not completed',
            'Not completed',
            'Not completed'
        ) AS `status_level_in_completed`,
        COUNT(
            IF(
                pc.status_id = 2,
                pc.status_id,
                NULL
            )
        ) AS `total_not_completed`,
        IF(
            s.status_level = 'In progress',
            'In progress',
            'In progress'
        ) AS `status_level_in_progress`,
        COUNT(
            IF(
                pc.status_id = 3,
                pc.status_id,
                NULL
            )
        ) AS `total_in_progress`,
        COUNT(pc.personal_calendar_id) AS `total_activity`
    FROM
        PersonalCalendar pc
    JOIN `Status` s ON
        s.status_id = pc.status_id
    WHERE
        student_id = :student_id AND pc.end BETWEEN :start_date AND CONCAT(YEAR(CURDATE()),'-08-01')
    GROUP BY
        MONTH(pc.end)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id'],);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // admin functionality 
    public function viewAllStudents() {
        $sql = 'SELECT
        s.*,
        accSus.student_id AS student_account_deleted,
        accSus.reason
        FROM
            Students s
        LEFT JOIN AccountSuspended accSus ON
            accSus.student_id = s.student_id';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function termsAndConditions() {
        $sql = 'SELECT * FROM TermsAndConditions';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTermsAndConditionsDetails($terms) {
        $sql = "SELECT * FROM TermsAndConditions WHERE termsAndConditions_id = :termsAndConditions_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':termsAndConditions_id', $terms);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function updateTermsAndConditions($id, $content) {

        $sql = "UPDATE `TermsAndConditions` SET `content` = :content WHERE termsAndConditions_id = :termsAndConditions_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':termsAndConditions_id', $id);
        return $stmt->execute();
    }




    public function getTotalStudents() {
        $sql = 'SELECT COUNT(*) AS students_found FROM Students';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['students_found'];
    }

    public function getTotalSemester() {
        $sql = 'SELECT COUNT(*) AS semester_found FROM Semester';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['semester_found'];
    }

    public function getTotalActivities() {
        $sql = 'SELECT COUNT(*) AS activity_found FROM ActivityType';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['activity_found'];
    }
    public function addSemester() {

        $sql = "INSERT INTO `Semester`
                 SET `name` = :name, 
                 `start_date` = :start_date, 
                 `end_date` = :end_date";
        return $this->getConnection()->prepare($sql)->execute($this->data);
    }

    public function editSemester($id) {
        $sql = "SELECT * FROM Semester WHERE semester_id = :semester_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':semester_id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function deleteSemester($semesterID) {
        $sql = "DELETE FROM `Semester` WHERE `semester_id` = :semester_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":semester_id", $semesterID);
        return $stmt->execute();
    }
    public function addActivity() {

        $sql = "INSERT INTO `ActivityType`
             SET
            `type` = :type, 
             `colour_id` = :colour_id";
        return $this->getConnection()->prepare($sql)->execute($this->data);
    }

    public function editActivity($id) {
        $sql = "SELECT * FROM ActivityType WHERE activity_id = :activity_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':activity_id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateActivity() {

        $sql = "UPDATE `ActivityType`
         SET 
         `type` = :type,
         `colour_id` = :colour_id
          WHERE activity_id = :activity_id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }

    public function deleteActivity($activityID) {
        $sql = "DELETE FROM `ActivityType` WHERE `activity_id` = :activity_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":activity_id", $activityID);
        $stmt->execute();
    }

    public function updateSemester() {

        $sql = "UPDATE `Semester`
         SET 
         `name` = :name,
         `start_date` = :start_date,
         `end_date` = :end_date
          WHERE semester_id = :semester_id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute($this->data);
    }



    public function getStudentDetails($studentID) {
        if (isset($_SESSION['student_id']) && $studentID !== $_SESSION['student_id']) {
            echo $this->showErrorMessage('You do not have permission to modify other student details!');
            exit;
        }

        $sql = 'SELECT
        s.*,
        accSus.student_id AS student_account_deleted,
        accSus.reason
        FROM
            Students s
        LEFT JOIN AccountSuspended accSus ON
            accSus.student_id = s.student_id 
        WHERE s.student_id = :student_id
        LIMIT 1';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $studentID);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function reviewStudentAccount($studentID, $currentStatus, $reason) {

        $sql = "UPDATE `Students` SET 
                `account_suspended` = :current_status,
                reason = :reason
                WHERE student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':current_status', $currentStatus);
        $stmt->bindParam(':reason', $reason);
        $stmt->bindParam(':student_id', $studentID);
        return $stmt->execute();
    }

    public function getUpcomingCWChkList() {

        $sql = "SELECT
        CONCAT(module_code, ' ', module_name) AS `module`,
        cw.coursework_id,
        cw.title AS coursework_title    
    FROM
        Checklist chk
    JOIN Coursework cw ON
        cw.coursework_id = chk.coursework_id
    JOIN Modules m ON
        m.module_id = cw.module_id
    JOIN `Status` s ON
        s.status_id = chk.status_id
    WHERE
        student_id = :student_id AND DATE_FORMAT(cw.due_date, '%Y-%m-%d') BETWEEN DATE_FORMAT(NOW(), '%Y-%m-01') AND LAST_DAY(CURRENT_DATE)
    GROUP BY
        cw.coursework_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
    }



    public function manageTeacherToModules($teachersList, $moduleID) {
        $this->deleteModuleTeachers($moduleID);

        if (!empty($teachersList)) {

            foreach ($teachersList as $teacher) {

                $sql = 'INSERT INTO `ModuleTeachers` 
                SET 
                `module_id` = :module_id, 
                `teacher_id` = :teacher_id';
                $stmt = $this->getConnection()->prepare($sql);
                $stmt->bindParam(':module_id', $moduleID);
                $stmt->bindParam(':teacher_id', $teacher);

                // $stmt->bindParam(':student_id', $_SESSION['student_id']);
                // $stmt->bindParam(':pref_id', $_POST['communication'][$k]);
                $stmt->execute();
            }
        }

        return true;
    }

   
    function getTeachersAndModuleList() {
        $sql = "SELECT
        mt.*,
        CONCAT(m.module_code, ' ', m.module_name) AS module,
        CONCAT(t.firstname, ' ', t.lastname) AS teacher
    FROM
        ModuleTeachers mt
    JOIN Teachers t ON
        mt.teacher_id = t.teacher_id
    JOIN Modules m ON
        m.module_id = mt.module_id
    WHERE
        m.student_id = :student_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':student_id', $_SESSION['student_id']);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
