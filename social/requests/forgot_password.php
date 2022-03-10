<?php
$data['message'] = $lang['password_reset_mail_unknown'];

if (! isLogged())
{
    $forgotpassId = $escapeObj->stringEscape($_POST['forgotpass_id']);
    $forgotUserId = getUserId($conn, $forgotpassId);
    $query = $conn->query("SELECT id,password,username,email,name FROM " . DB_ACCOUNTS . " WHERE id=$forgotUserId AND type='user' AND active=1");
    
    if ($query->num_rows == 1)
    {
        $fetch = $query->fetch_array(MYSQLI_ASSOC);
        
        if (isset($fetch['id']))
        {
            $fetch['url'] = smoothLink('index.php?tab1=welcome&tab2=password_reset&id=' . $fetch['id'] . '_' . $fetch['password']);
            $to = $fetch['email'];
            $subject = $config['site_name'] . ' - Password Reset';
            
            $headers = "From: " . $config['email'] . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            $themeData['mail_user_name'] = $fetch['name'];
            $themeData['mail_reset_url'] = $fetch['url'];
            
            $message = \miuan\UI::view('emails/password-reset-email');
            
            if (mail ($to, $subject, $message, $headers))
            {
                $data = array(
                    'status' => 200,
                    'message' => $lang['password_reset_mail_confirm']
                );
            }
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();