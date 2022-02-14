<?php
//Router file. If using php built in server (thus why I had to include mime_content_type I want this literally no framework) set this as your router file
//other wise do the usual vhost / .htaccess

include_once('controller.php');
include_once('routes.php');
//set up path to front end
//I ran vue create html but did't include it with the repo as you can literally do whatever
$static_folder = "./html/dist";
//set default file. These are static files. They should not be php.
$default_file = "index.html";


$REQUEST_URI = $_SERVER['REQUEST_URI'];
$Request_Path = strtok($REQUEST_URI, '?');


foreach (array_keys($routes) as $key) {
    if (preg_match($key, $Request_Path, $matches)) {
        call_user_func($routes[$key], $matches);
        exit;
    }
}

//not a route so we check for default file
//Make sure if it ends in / to add index.html

if (str_ends_with($Request_Path, '/')) {
    $Request_Path .= $default_file;
}

//todo: more file santi but realpath does a ok job. More is better here.
$file_path = realpath($static_folder . $Request_Path);


if (file_exists(realpath($static_folder . $Request_Path))) {
    $contentType = mime_content_type2($file_path);

    header('Content-Type: ' . $contentType);
    echo file_get_contents($file_path);
    exit;
}

//oops no file
http_response_code(404);
echo "No route for  {$REQUEST_URI}";
exit;


//lifted from the php docs and then improved the if/else cuz shitty
//This can be removed (I'm not counting it towards my file size because some php installs have it, some don't
// it's only here if you need it. If mime_content_type exists you can comment this out.


function mime_content_type2($filename)
{

    $mime_types = array(

        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );
    if (strpos($filename, '.') < 0) {
        return 'application/octet-stream';
    }

    $array = explode('.', $filename);
    $ext = strtolower(array_pop($array));
    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    }

    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);
        return $mimetype;
    }

    return 'application/octet-stream';
}

