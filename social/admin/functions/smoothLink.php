<?php
function SK_smoothLink($query='') {
    global $config;
    
    if ($config['smooth_links'] == 1) {
        $query = preg_replace(
            array(
                '/^index\.php\?tab1=timeline&tab2=([^\/]+)&tab3=([^\/]+)&recipient_id=([^\/]+)&id=([^\/]+)$/i',
                '/^index\.php\?tab1=timeline&tab2=([^\/]+)&tab3=([^\/]+)&id=([^\/]+)$/i',
                '/^index\.php\?tab1=timeline&tab2=([^\/]+)&id=([^\/]+)$/i',
                '/^index\.php\?tab1=timeline&id=([^\/]+)$/i',
                
                '/^index\.php\?tab1=story&id=([0-9]+)$/i',
                
                '/^index\.php\?tab1=welcome&tab2=forgot_password$/i',
                '/^index\.php\?tab1=welcome&tab2=password_reset&id=([A-Za-z0-9_]+)$/i',
                
                '/^index\.php\?tab1=([^\/]+)&query=([^\/]+)$/i',
                
                '/^index\.php\?tab1=([^\/]+)&tab2=([^\/]+)&tab3=([^\/]+)$/i',
                '/^index\.php\?tab1=([^\/]+)&tab2=([^\/]+)$/i',
                '/^index\.php\?tab1=([^\/]+)$/i'
            ),
            array(
                $config['site_url'] . '/@$4/$1/$2/$3',
                $config['site_url'] . '/@$3/$1/$2',
                $config['site_url'] . '/@$2/$1',
                $config['site_url'] . '/@$1',
                
                $config['site_url'] . '/story/$1',
                
                $config['site_url'] . '/forgot-password',
                $config['site_url'] . '/password-reset/$1',
                
                $config['site_url'] . '/$1/$2',
                
                $config['site_url'] . '/$1/$2/$3',
                $config['site_url'] . '/$1/$2',
                $config['site_url'] . '/$1'
            ),
            $query
        );
    } else {
        $query = $config['site_url'] . '/' . $query;
    }
    
    return $query;
}
