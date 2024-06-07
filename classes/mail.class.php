<?php


class Mail {
    private static $instance = null;

    private function __construct() {
    }

    public static function getInstance() {
        return self::$instance === null ? self::$instance = new Mail() : self::$instance;
    }

    private $emailTo;
    private $subject;
    private $headers;
    private $message;

    public function setEmailTo($emailTo) {
        $this->emailTo = $emailTo;
        return $this;
    }
    public function createHeaders($from): string
    {
        $headers = "From: $from\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        return $headers;

    }
    public function setSubject($subject) {
        $this->subject = $subject;
        return $this;
    }
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }
    public function setHeaders($headers) {
        $this->headers = $headers;
        return $this;
    }

    private const ADMIN_EMAIL = 'mc8852u@gre.ac.uk';
    private const TEMPLATE_EMAIL_FILE = '../includes/coursework_email_reminders.inc.php';


    public function getEmailTemplateFile() {
        return self::TEMPLATE_EMAIL_FILE;
    }
    public function getAdminEmail() {
        return self::ADMIN_EMAIL;
    }

    public function sendEmail() {
        $this->init();
        return mail($this->emailTo, $this->subject, $this->message, $this->headers);
    }

    public function renderCourseworkEmailReminder($db) {
        



        $message = '<!doctype html>
        <html lang="en">
        
        <head>
          <!-- Required meta tags -->
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <style>
          .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
          }
          .bg-success {
            background-color: #0d6efd !important;
          }
          
          .bg-secondary {
            background-color: #6c757d !important;
          }
          
          .bg-success {
            background-color: #198754 !important;
          }
          
          .bg-info {
            background-color: #0dcaf0 !important;
          }
          
          .bg-warning {
            background-color: #ffc107 !important;
          }
          
          .bg-danger {
            background-color: #dc3545 !important;
          }
          
          .bg-light {
            background-color: #f8f9fa !important;
          }
          
          .bg-dark {
            background-color: #212529 !important;
          }
          
          .bg-body {
            background-color: #fff !important;
          }
          
          .bg-white {
            background-color: #fff !important;
          }
          
        
          .text-muted {
              color: #6c757d !important;
          }
        
          .text-danger {
              color: red;
          }
        
            .card {
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
              max-width: 300px;
              margin: auto;
              text-align: center;
              font-family: arial;
            }
            .alert {
              position: relative;
              padding: 1rem 1rem;
              margin-bottom: 1rem;
              border: 1px solid transparent;
              border-radius: 0.25rem;
            }
            .alert-danger {
              color: #842029;
              background-color: #f8d7da;
              border-color: #f5c2c7;
            }
            .alert-warning {
              color: #664d03;
              background-color: #fff3cd;
              border-color: #ffecb5;
            }
            .alert-success {
              color: #0f5132;
              background-color: #d1e7dd;
              border-color: #badbcc;
            }
            .text-center {
              text-align: center !important;
            }
            
          </style>
        
          <title>Coursework reminder</title>
        </head>
        
        <body>';
        $message .= '<h1 class="text-danger text-center">You have ' . $db->countUpcomingCourseworkByMonth() . ' upcoming coursework this month (' . date('M Y') . ')</h1>';
        
        foreach ($db->getUpcomingCourseworkByMonth() as $row) { 

            $message .= '<div class="card">
                            '.(!empty($row["image"]) ? '<img src="' . $row["image"] . '" alt="coursework image" style="width:100%">': '').'
             
                            <h1>' . $row["title"] . '</h1>
                            <p class="card-text"><small class="text-muted">Description:</small><br></p>
                            <p>  ' . nl2br($row["description"]) . '</p>
                            <p class="card-text text-' . Helper::cwDateColour($row["due_date"], $row["status_level"]) . '">Due in ' . Helper::calculateDeadlineDate($row["due_date"]) . '' . '</p>
                            <p class="card-text text-' . Helper::cwDateColour($row["due_date"], $row["status_level"]) . '">Due <strong>' . Helper::dueDateMsg($row['due_date']) . '' . date("dS M Y", strtotime($row["due_date"])) . '' . '</strong></p>
                            <p class="card-text"><small class="text-muted">Status:</small>
                            <span class="badge bg-' . $row["status_colour"] . '"> ' . $row["status_level"] . '</span>
                          </p>

                          '.($row['status_level'] !== 'Completed' ? '<p class="card-text"><small class="text-muted">Priority:</small>
                          <span> ' .  Helper::getPriorityMessage($row["priority_level"]) . '</span>
                        </p>': '').'.
          </div>';
        }

        $message .= '</body></html>';

        return $message;
    }


    private static function showSMS($db){
      
      $message = 'You have ' . $db->countUpcomingCourseworkByMonth() . ' upcoming coursework this month (' . date('M Y') . ')'."%0a";
      foreach ($db->getUpcomingCourseworkByMonth() as $row) { 
        $message.= "{$row['title']} Due: ".date("dS M Y", strtotime($row["due_date"]))."%0a";

      }
      return $message;

    }

    public static function sendSMSReminder($db){

        // Authorisation details.
        $username = 'akbhar1999@hotmail.com';
        $hash = '414077cff9bfcf488639da01b0ab40dbd93c9a1349cbd1c7543fe90fdf1e881d';

        // Config variables. Consult http://api.txtlocal.com/docs for more info.
        $test = '0';

        // Data for text message. This is the text message data.
        $sender = 'StudentPlanner'; // This is who the message appears to be from.
        $numbers = $db->getPhoneNumber(); // A single number or a comma-seperated list of numbers
        //self::showSMS($db)
        // 612 chars or less
        // A single number or a comma-seperated list of numbers
        $message = urlencode(self::showSMS($db));
        $data = 'username=' . $username . '&hash=' . $hash . '&message=' . $message . '&sender=' . $sender . '&numbers=' . $numbers . '&test=' . $test;
        $ch = curl_init('http://api.txtlocal.com/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch); // This is the result from the API
        print_r(var_dump($result));
        curl_close($ch);
    }



    // init method provides default configuration values for mail
    private static function init() {
        ini_set('SMTP', 'smtp.gre.ac.uk');
        ini_set('sendmail_from', self::ADMIN_EMAIL);
    }
}
