<?php
require_once('assets/includes/core.php');
$redirect = true;

function importMedia($url='')
{
    global $conn;
    
    if (empty($url))
    {
        return false;
    }
    
    if (($source = @file_get_contents($url)) == false)
    {
        return false;
    }
    
    if (! file_exists('photos/' . date('Y')))
    {
        mkdir('photos/' . date('Y'), 0777, true);
    }
    
    if (! file_exists('photos/' . date('Y') . '/' . date('m')))
    {
        mkdir('photos/' . date('Y') . '/' . date('m'), 0777, true);
    }
    
    $photo_dir = 'photos/' . date('Y') . '/' . date('m');
    $name = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $url);
    $url_ext = $url;
    
    if (($qs_ext_pos = strrpos($url, '?')) !== false) {
        $url_ext = substr($url, 0, $qs_ext_pos);
    }
    
    $dot_ext_pos = strrpos($url_ext, '.');
    $url_ext = strtolower(substr($url_ext, $dot_ext_pos + 1, strlen($url_ext) - $dot_ext_pos));
    
    if (!preg_match('/^(jpg|jpeg|png)$/', $url_ext)) {
        return false;
    }
    
    $query = $conn->query("INSERT INTO " . DB_MEDIA . " (extension,name,type) VALUES ('$url_ext','$name','photo')");
    
    if (! $query)
    {
        return false;
    }
    
    $sqlId = $conn->insert_id;
    $original_file_name = $photo_dir . '/' . generateKey() . '_' . $sqlId . '_' . md5($sqlId);
    $original_file = $original_file_name . '.' . $url_ext;
    $register_cover = @file_put_contents($original_file, $source);
    
    if ($register_cover)
    {
        list($width, $height) = getimagesize($original_file);
        $min_size = $width;
        
        if ($width > $height)
        {
            $min_size = $height;
        }
        
        $min_size = floor($min_size);
        
        if ($min_size > 920)
        {
            $min_size = 920;
        }
        
        $imageSizes = array(
            'thumb' => array(
                'type' => 'crop',
                'width' => 64,
                'height' => 64,
                'name' => $original_file_name . '_thumb'
            ),
            '100x100' => array(
                'type' => 'crop',
                'width' => $min_size,
                'height' => $min_size,
                'name' => $original_file_name . '_100x100'
            ),
            '100x75' => array(
                'type' => 'crop',
                'width' => $min_size,
                'height' => floor($min_size * 0.75),
                'name' => $original_file_name . '_100x75'
            )
        );
        
        foreach ($imageSizes as $ratio => $data)
        {
            $save_file = $data['name'] . '.' . $url_ext;
            processMedia($data['type'], $original_file, $save_file, $data['width'], $data['height']);
        }
        
        $conn->query("UPDATE " . DB_MEDIA . " SET url='$original_file_name',temp=0,active=1 WHERE id=$sqlId");
        createCover($sqlId);
        
        $get = array(
            'id' => $sqlId,
            'active' => 1,
            'extension' => $url_ext,
            'name' => $name,
            'url' => $original_file_name
        );
        
        return $get;
    }
}

// Get type
if (! empty($_GET['type']))
{
    $type = $_GET['type'];
    $escapeObj = new \miuan\Escape();
    
    // if type is facebook
    if ($type == "facebook")
    {
        if (! empty($_GET['code']))
        {
            $code = $_GET['code'];
            $client_id = $fb_app_id;
            $client_secret = $fb_app_secret;
            $redirect_uri = $config['site_url'] . '/import.php?type=facebook';
            
            $getAccessTokenUrl = "https://graph.facebook.com/oauth/access_token?client_id=$client_id&redirect_uri=$redirect_uri&client_secret=$client_secret&code=$code";
            $getAccessToken = @file_get_contents($getAccessTokenUrl);
            
            $explodeAccessTokenStageOne = explode('&', $getAccessToken);
            $explodeAccessTokenStageTwo = explode('=', $explodeAccessTokenStageOne[0]);
            $access_token = $explodeAccessTokenStageTwo[1];
            
            if (! empty($access_token))
            {
                $getApiUrl = "https://graph.facebook.com/me?access_token=$access_token&fields=email,birthday,gender,name,cover,picture.width(720).height(720)";
                $getApi = @file_get_contents($getApiUrl);
                $getJson = @json_decode($getApi, true);
                
                if (! empty($getJson['name']) && ! empty($getJson['id']))
                {
                    $getJson['name'] = $escapeObj->stringEscape($getJson['name']);
                    $getJson['id'] = $escapeObj->stringEscape($getJson['id']);
                    $getJson['username'] = 'fb_' . $getJson['id'];
                    $possibleUsername = preg_replace('/([^a-z_])/i', '', strtolower($getJson['name']));

                    if (! empty ($getJson['birthday']) && is_array($getJson['birthday']) && count($getJson['birthday']) > 0)
                    {
                        $fbBdayArray = explode('/', $getJson['birthday']);

                        $fbBdayArray[0] = (empty($fbBdayArray[0])) ? 1 : $fbBdayArray[0];
                        $fbBdayArray[1] = (empty($fbBdayArray[1])) ? 1 : $fbBdayArray[1];
                        $fbBdayArray[2] = (empty($fbBdayArray[2])) ? 1990 : $fbBdayArray[2];

                        $getBday = array($fbBdayArray[1], $fbBdayArray[0], $fbBdayArray[2]);
                        $getJson['birthday'] = implode('-', $getBday);
                    }

                    if (strlen($possibleUsername) > 3)
                    {
                        $query = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE username='$possibleUsername' AND type='user' AND active=1");
                        
                        if ($query->num_rows == 0)
                        {
                            $getJson['username'] = $possibleUsername;
                        }
                    }
                    
                    if (! empty($getJson['email']))
                    {
                        $getJson['email'] = $escapeObj->stringEscape($getJson['email']);
                    }
                    else
                    {
                        $getJson['email'] = $getJson['username'] . '@facebook.com';
                    }
                    
                    if (! empty($getJson['gender']))
                    {
                        $getJson['gender'] = $escapeObj->stringEscape($getJson['gender']);
                    }
                    else
                    {
                        $getJson['gender'] = 'male';
                    }
                    
                    $getJson['password'] = md5($getJson['email']);
                    $query2 = $conn->query("SELECT id,password FROM " . DB_ACCOUNTS . " WHERE email='" . $getJson['email'] . "' AND type='user' AND active=1");
                    
                    if ($query2->num_rows == 1)
                    {
                        $fetch2 = $query2->fetch_array(MYSQLI_ASSOC);
                        
                        $_SESSION['user_id'] = $fetch2['id'];
                        $_SESSION['user_pass'] = $fetch2['password'];
                        
                        setcookie('sk_u_i', $_SESSION['user_id'], time() + (60 * 60 * 24 * 7));
                        setcookie('sk_u_p', $_SESSION['user_pass'], time() + (60 * 60 * 24 * 7));
                    }
                    else
                    {
                        $registerObj = new \miuan\registerUser();
                        $registerObj->setName($getJson['name']);
                        $registerObj->setUsername($getJson['username']);
                        $registerObj->setEmail($getJson['email']);
                        $registerObj->setPassword($getJson['password']);
                        $registerObj->setGender($getJson['gender']);
                        $registerObj->setBirthday($getJson['birthday']);
                        $registerObj->setLocation($getJson['location']);
                        $registerObj->setHometown($getJson['hometown']);
                        $registerObj->setAbout($getJson['about']);

                        if ($register = $registerObj->register())
                        {
                            $register['password'] = $getJson['password'];
                            
                            $_SESSION['user_id'] = $register['id'];
                            $_SESSION['user_pass'] = md5($getJson['password']);
                            
                            setcookie('sk_u_i', $_SESSION['user_id'], time() + (60 * 60 * 24 * 7));
                            setcookie('sk_u_p', $_SESSION['user_pass'], time() + (60 * 60 * 24 * 7));
                            
                            $to = $register['email'];
                            $subject = $config['site_name'] . ' - Account Password';
                            
                            $headers = "From: " . $config['email'] . "\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                            $themeData['mail_user_name'] = $register['name'];
                            $themeData['mail_user_password'] = $register['password'];
                            
                            $message = \miuan\UI::view('emails/facebook-registration');
                            mail ($to, $subject, $message, $headers);
                            
                            if (! empty($getJson['cover']) && is_array($getJson['cover']))
                            {
                                $cover = importMedia($getJson['cover']['source']);
                                
                                if (is_array($cover))
                                {
                                    $query3 = $conn->query("UPDATE " . DB_ACCOUNTS . " SET cover_id=" . $cover['id'] . " WHERE id=" . $register['id']);
                                }
                            }
                            
                            if (is_array($getJson['picture']) && ! empty($getJson['picture']['data']['url']))
                            {
                                $avatar = importMedia($getJson['picture']['data']['url']);
                                
                                if (is_array($avatar))
                                {
                                    $query_two = $conn->query("UPDATE " . DB_ACCOUNTS . " SET avatar_id=" . $avatar['id'] . " WHERE id=" . $register['id']);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

if ($redirect)
{
    header('Location: ' . smoothLink('index.php?tab1=welcome'));
}

?>