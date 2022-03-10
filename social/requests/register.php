<?php
$proceed = false;
$data['error_message'] = $lang['error_bad_captcha'];

if ($config['captcha'] == false)
{
    $proceed = true;
}
elseif ($_POST['captcha'] == $_SESSION['captcha_key'])
{
    $proceed = true;
}

if ($proceed == true)
{
    $data['error_message'] = $lang['error_empty_registration'];

    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $mailQuery = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE email='" . $escapeObj->stringEscape($_POST['email']) . "'");
        
        if ($mailQuery->num_rows > 0)
        {
            $data['error_message'] = $lang['error_email_exists'];
        }
    }
    
    $registerObj = new \miuan\registerUser();
    $registerObj->setName($_POST['name']);
    $registerObj->setUsername($_POST['username']);
    $registerObj->setEmail($_POST['email']);
    $registerObj->setPassword($_POST['password']);
    $registerObj->setGender($_POST['gender']);
    $registerObj->setBirthday($_POST['birthday']);
    $registerObj->setLocation($_POST['location']);
    $registerObj->setHometown($_POST['hometown']);
    $registerObj->setAbout($_POST['about']);

    if ($register = $registerObj->register())
    {
        $register['verification_link'] = $config['site_url'] . '/?tab1=email-verification&email=' . $register['email'] . '&key=' . $register['email_verification_key'];
        
        $to = $register['email'];
        $subject = $config['site_name'] . ' - Email Verification';
        
        $headers = "From: " . $config['email'] . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $themeData['mail_user_name'] = $register['name'];
        $themeData['mail_verify_link'] = $register['verification_link'];
        
        $message = \miuan\UI::view('emails/email-verification');
        mail ($to, $subject, $message, $headers);
        
        if ($config['email_verification'] == 0)
        {
            $_SESSION['user_id'] = $register['id'];
            $_SESSION['user_pass'] = md5 (trim ($_POST['password']));
            
            $data['status'] = 200;
            $data['redirect_url'] = smoothLink('index.php?tab1=home');
        }
        else
        {
            $data['error_message'] = $lang['verification_email_sent'];
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();