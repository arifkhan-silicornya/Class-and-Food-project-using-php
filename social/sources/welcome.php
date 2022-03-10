<?php
if (!empty($_COOKIE['sk_u_i']) && !empty($_COOKIE['sk_u_p'])) {
    $u_i = $escapeObj->stringEscape($_COOKIE['sk_u_i']);
    $u_p = $escapeObj->stringEscape($_COOKIE['sk_u_p']);

    $_SESSION['user_id'] = $u_i;
    $_SESSION['user_pass'] = $u_p;

    header('Location: ' . smoothLink('index.php?tab1=home'));
}

if ($logged == true) {
    header('Location: ' . smoothLink('index.php?tab1=home'));
}

/* Core */
require_once("assets/includes/core.php");

/* */
$themeData['login_tab_url'] = smoothLink('index.php?tab1=welcome&tab2=login');
$themeData['forgot_password_tab_url'] = smoothLink('index.php?tab1=welcome&tab2=forgot_password');
$themeData['welcome_to_sitename'] = str_replace('%sitename%', $config['site_name'], $lang['welcome_to_sitename']);

/* Birth Dates */
$listBirthDates = '';
for ($i = 1; $i < 32; $i++) {
    $themeData['birth_date_value'] = $i;
    $listBirthDates .= \miuan\UI::view('welcome/list-signup-birth-date-each');
}
$themeData['list_birth_dates'] = $listBirthDates;

/* Birth Months */
$listBirthMonths = '';
foreach (getMonths() as $month_number => $month_data) {
    $themeData['birth_month_value'] = $month_number;
    $themeData['birth_month_label'] = $month_data[1];

    $listBirthMonths .= \miuan\UI::view('welcome/list-signup-birth-month-each');
}
$themeData['list_birth_months'] = $listBirthMonths;

/* Birth Years */
$listBirthYears = '';
for ($i = date('Y')-100; $i < date('Y')-12; $i++) {
    $themeData['birth_year_value'] = $i;
    $listBirthYears .= \miuan\UI::view('welcome/list-signup-birth-year-each');
}
$themeData['list_birth_years'] = $listBirthYears;

/* Sign Up Inputs */
if ($config['reg_req_birthday'] == true) {
    $themeData['signup_birthday_input'] = \miuan\UI::view('welcome/signup-birthday-input');
}

if ($config['reg_req_currentcity'] == true) {
    $themeData['signup_location_input'] = \miuan\UI::view('welcome/signup-location-input');
}

if ($config['reg_req_hometown'] == true) {
    $themeData['signup_hometown_input'] = \miuan\UI::view('welcome/signup-hometown-input');
}

if ($config['reg_req_about'] == true) {
    $themeData['signup_about_input'] = \miuan\UI::view('welcome/signup-about-input');
}

if ($config['captcha'] == true) {
    $captcha = createCaptcha();
    $themeData['captcha_image_src'] = $config['site_url'] . '/' . $captcha['image'];
    $themeData['signup_captcha_input'] = \miuan\UI::view('welcome/signup-captcha-input');
}

/* Tabs */
$signupTab = true;
$tabContent = '';

$themeData['reset_password_tab'] = \miuan\UI::view('welcome/reset-password-tab');
$themeData['reset_password_invalid'] = \miuan\UI::view('welcome/reset-password-invalid');
$themeData['forgot_password_tab'] = \miuan\UI::view('welcome/forgot-password-tab');
$themeData['login_tab'] = \miuan\UI::view('welcome/login-tab');

if (isset($_GET['tab2']) && $_GET['tab2'] == "password_reset") {

    if (isset($_GET['id']) && isValidPasswordResetToken($_GET['id']) != false) {
        $tabContent .= $themeData['reset_password_tab'];

    } else {
        $tabContent .= $themeData['reset_password_invalid'];
    }

    $signupTab = false;

} elseif (isset($_GET['tab2']) && $_GET['tab2'] == "forgot_password") {
     $tabContent .= $themeData['forgot_password_tab'];

} else {
    $tabContent .= $themeData['login_tab'];
}

if ($signupTab == true) {
    $tabContent .= \miuan\UI::view('welcome/signup-tab');
}
$themeData['tab_content'] = $tabContent;

/* Facebook Login */
require_once("assets/imports/facebook/facebook.php");
$fb_config = array(
    'appId' => $fb_app_id,
    'secret' => $fb_app_secret,
    'fileUpload' => false,
    'allowSignedRequest' => false,
);
$facebook = new Facebook($fb_config);
$params = array(
  'scope' => 'email',
  'redirect_uri' => $config['site_url'] . '/import.php?type=facebook'
);
$fb_login_url = $facebook->getLoginUrl($params);
$themeData['facebook_login_url'] = $fb_login_url;
/* */

$themeData['page_content'] = \miuan\UI::view('welcome/content');
