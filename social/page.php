<?php


require_once('assets/includes/core.php');

foreach ($_GET as $key => $value)
{
    $themeData['get_' . $escapeObj->stringEscape(strtolower($key))] = $escapeObj->stringEscape($value);
}

if (! isset($_GET['tab1']))
{
    $_GET['tab1'] = 'welcome';
}

switch ($_GET['tab1'])
{
    // Welcome page source
    case 'welcome':
        include('sources/welcome.php');
    break;
    
    // Email verification source
    case 'email-verification':
        include('sources/email_verification.php');
    break;
    
    // Home page source
    case 'home':
        include('sources/home.php');
    break;
    
    // Messages page source
    case 'messages':
        include('sources/messages.php');
    break;
    
    // Timeline page source
    case 'timeline':
        include('sources/timeline.php');
    break;
    
    // Story page source
    case 'story':
        include('sources/story.php');
    break;

    // Album page source
    case 'album':
        include('sources/album.php');
    break;
    
    // Create page source
    case 'create_page':
        include('sources/create_page.php');
    break;
    
    // Create group page source
    case 'create_group':
        include('sources/create_group.php');
    break;
    
    // Hashtag page source
    case 'hashtag':
        include('sources/hashtag.php');
    break;
    
    // Search page source
    case 'search':
        include('sources/search.php');
    break;
    
    // User settings page source
    case 'settings':
        include('sources/user_settings.php');
    break;
    
    // More features page source
    case 'more':
        include('sources/more.php');
    break;
    
    // Terms page source
    case 'terms':
        include('sources/terms.php');
    break;
    
    // Logout source
    case 'logout':
        include('sources/logout.php');
    break;
    
}

// If no sources found
if (empty($themeData['page_content']))
{
    $themeData['page_content'] = \miuan\UI::view('welcome/error');
}

$themeData['page_content'] .= '<script>updateAlerts();</script>';

echo $themeData['page_content'];
$conn->close();