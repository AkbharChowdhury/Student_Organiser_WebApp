<?php
final class Validation {

    private $data;
    private $additionalChecks = true;
    private $errors = [];

    /* private  $VALIDATION = [

   

        'isValidNumber' => function($str) { 
            return substr($str, 0, 1) === "0";
           },
        
           'name' => function($str) { 
               return preg_match('/^[a-zA-Z]+$/', $str);
           },
        
           'isValidEmail'=> function($str) { 
               return filter_var($str, FILTER_VALIDATE_EMAIL);
           },
        
           'is8Chars'=> function($str) { 
               return strlen($str) < 8;
           },
        
        
        
        ];*/
    // Hold the class instance.
    private static $instance = null;

    private function __construct($postData) {
        $this->data = $postData;
    }


    public static function getInstance($postData) {

        return self::$instance === null ? self::$instance = new Validation($postData) : self::$instance;
    }

    // add error keys
    private function addError($key, $val) {
        $this->errors[$key] = $val;
    }
    // for password field
    public function setAdditionalChecks($value) {
        $this->additionalChecks = $value;
        return $this;
    }

    public function validateForm() {

        $this->firstName();
        $this->lastName();
        $this->email();
        $this->username();
        $this->password();
        $this->phone();
        $this->campus();
        $this->address();
        $this->city();
        $this->postcode();
        $this->moduleCode();
        $this->moduleName();
        $this->subject();
        $this->message();
        $this->termsContent();
        $this->activityType();
        $this->semesterStartDate();
        $this->semesterEndDate();
        $this->teacherList();


        // returning errors array
        return $this->errors;
    }





    public function validateCourseworkForm(){
        $this->title();
        $this->status();
        $this->priority();
        $this->module();
        $this->dueDate();

        return $this->errors;


    }
    // validateTeacherForm


    /***************************** Validation methods ********************************************************** */
    

    public function dueDate() {
        if (array_key_exists('due_date', $this->data)) {
            if (empty(trim($this->data['due_date']))) {
                $this->addError('due_date', 'due date is required');
            }
        }
    }
    public function title() {
        if (array_key_exists('title', $this->data)) {
            if (empty(trim($this->data['title']))) {
                $this->addError('title', 'title is required');
            }
        }
    }

    public function status() {
        if (array_key_exists('status_id', $this->data)) {
            if (empty(trim($this->data['status_id']))) {
                $this->addError('status', 'status is required');
            }
        }
    }
    public function priority() {
        if (array_key_exists('priority_id', $this->data)) {
            if (empty(trim($this->data['priority_id']))) {
                $this->addError('priority_id', 'priority_id is required');
            }
        }
    }
    public function module() {
        if (array_key_exists('module_id', $this->data)) {
            if (empty(trim($this->data['module_id']))) {
                $this->addError('module_id', 'module_id is required');
            }
        }
    }

    public function activityType() {
        if (array_key_exists('activity_type', $this->data)) {
            $activityType = trim($this->data['activity_type']);
            if (empty($activityType)) {
                $this->addError('activity_type', 'activity is required');
            }
        }
    }

    public function teacherList() {
        if (array_key_exists('module_teacher', $this->data)) {
            $activityType = trim($this->data['module_teacher']);
            if (empty($activityType)) {
                $this->addError('module_teacher', 'You must choose at least one teacher!');
            }
        }
    }
    public function semesterStartDate() {
        if (array_key_exists('semester_start_date', $this->data)) {
            $semesterStartDate = trim($this->data['semester_start_date']);
            if (empty($semesterStartDate)) {
                $this->addError('semester_start_date', 'semester start date is required');
            }
        }
    }
    public function semesterEndDate() {
        if (array_key_exists('semester_end_date', $this->data)) {
            $semesterEndDate = trim($this->data['semester_end_date']);
            if (empty($semesterEndDate)) {
                $this->addError('semester_end_date', 'semester end date is required');
            }
        }
    }

  

    

    public function termsContent() {
        if (array_key_exists('content', $this->data)) {
            $moduleCode = trim($this->data['content']);
            if (empty($moduleCode)) {
                $this->addError('content', 'Terms and conditions is required');
            }
        }
    }
    public function moduleCode() {
        if (array_key_exists('module_code', $this->data)) {
            $moduleCode = trim($this->data['module_code']);
            if (empty($moduleCode)) {
                $this->addError('module_code', 'Module code is required!');
            }
        }
    }

    public function moduleName(){
        if (array_key_exists('module_name', $this->data)) {
            $moduleName = trim($this->data['module_name']);
            if (empty($moduleName)) {
                $this->addError('module_name', 'Module name is required!');
            }
        }


        //
    }
    public function campus() {
        if (array_key_exists('campus', $this->data)) {
            $campus = trim($this->data['campus']);
            if (empty($campus)) {
                $this->addError('campus', 'campus is required!');
            }
        }
    }

    public function address() {
        if (array_key_exists('address', $this->data)) {
            $address = trim($this->data['address']);
            if (empty($address)) {
                $this->addError('address', 'address is required!');
            }
        }
    }
    public function city() {
        if (array_key_exists('city', $this->data)) {
            $city = trim($this->data['city']);
            if (empty($city)) {
                $this->addError('city', 'city is required!');
            }
        }
    }

    public function postcode() {
        if (array_key_exists('postcode', $this->data)) {
            $postcode = trim($this->data['postcode']);
            if (empty($postcode)) {
                $this->addError('postcode', 'postcode is required!');
            }
        }
    }
    public function phone() {
        if (array_key_exists('phone', $this->data)) {
            // getting post values and validating them
            $phone = trim($this->data['phone']);
            if (empty($phone)) {
                $this->addError('phone', 'Phone is required');
                return;
            }
            if ($phone[0] !== '0') {
                $this->addError('phone', 'Phone number must start with 0');
                return;
            }
            if (strlen($phone) !== 11) {
                $this->addError('phone', 'Phone number must be 11 digits long!');
                return;
            }
        }
    }


    final protected function firstName() {
        if (array_key_exists('firstname', $this->data)) {
            // getting post values and validating them
            $firstname = trim($this->data['firstname']);

            if (empty($firstname)) {
                $this->addError('firstname', 'firstname is required');
                return;
            }

            if (!preg_match('/^[a-zA-Z]+$/', $firstname)) {
                $this->addError('firstname', 'firstname cannot contain spaces, numbers or special characters');
            }
        }
    }

    final protected function lastName() {
        if (array_key_exists('lastname', $this->data)) {
            // getting post values and validating them
            $lastname = trim($this->data['lastname']);

            if (empty($lastname)) {
                $this->addError('lastname', 'lastname is required');
                return;
            }

            if (!preg_match('/^[a-zA-Z]+$/', $lastname)) {
                $this->addError('lastname', 'lastname cannot contain spaces, numbers or special characters');
            }
        }
    }

    final protected function email() {
        if (array_key_exists('email', $this->data)) {
            $email = trim($this->data['email']);

            if (empty($email)) {
                $this->addError('email', 'email is required');
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addError('email', 'Please enter a valid email address');
            }
        }
    }

    final protected function password() {
        if (array_key_exists('password', $this->data)) {
            $password = $this->data['password'];
            if (trim(empty($password))) {
                $this->addError('password', 'password is required');
                return;
            }

            if ($this->additionalChecks) {

                if (trim(strlen($password)) < 8) {
                    $this->addError('password', 'password must be at least 8 characters');
                }
            }
        }
    }

    final protected function subject() {
        if (array_key_exists('subject', $this->data)) {
            $subject = $this->data['subject'];
            if (trim(empty($subject))) {
                $this->addError('subject', 'subject is required');
            }
        }
    }


    final protected function message() {

        if (array_key_exists('message', $this->data)) {
            $message = $this->data['message'];
            if (trim(empty($message))) {
                $this->addError('message', 'message is required');
            }
        }
    }









    public function description() {

        if (array_key_exists('description', $this->data)) {
            $description = trim($this->data['description']);

            if (empty($description)) {
                $this->addError('description', 'description is required');
                return;
            }

            // check the length of the string
            if (strlen($description) < 20) {
                $this->addError('description', 'description must be at least 20 characters long');
            }
        }
    }


    final protected function image() {
        if (array_key_exists('image', $this->data)) {
            $image = trim($this->data['image']);

            if (empty($image)) {
                $this->addError('image', 'image is required');
                return;
            }

            if (!filter_var($image, FILTER_VALIDATE_URL)) {
                $this->addError('image', 'Please enter a valid url address');
            }
        }
    }

    public function username() {
        if (array_key_exists('username', $this->data)) {
            $campus = trim($this->data['username']);
            if (empty($campus)) {
                $this->addError('username', 'username is required!');
            }
        }
    }
}
