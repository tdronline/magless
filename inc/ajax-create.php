<?php
/**
 * Created by PhpStorm.
 * User: trajakaruna
 * Date: 3/14/2018
 * Time: 1:27 PM
 */
require_once ('functions.php');

$project_path = trim($_REQUEST['prj_path']);
$prj_name = trim($_REQUEST['prj_name']);
$theme = strtolower($prj_name);

$XML = "
<theme xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"urn:magento:framework:Config/etc/theme.xsd\">
    <title>$prj_name</title>
    <parent>Magento/blank</parent>
    <media>
        <preview_image>media/preview.png</preview_image>
    </media>
</theme>
";

$REGISTRATION = "
<?php
/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::THEME,
    'frontend/Netstarter/$prj_name',
    __DIR__
);
";

$COMPOSER = "
{
    \"name\": \"magento/theme-frontend-$theme\",
    \"description\": \"N/A\",
    \"require\": {
        \"php\": \"~5.6.5|7.0.2|7.0.4|~7.0.6\",
        \"magento/framework\": \"100.1.*\"
    },
    \"type\": \"magento2-theme\",
    \"version\": \"100.1.6\",
    \"license\": [
        \"OSL-3.0\",
        \"AFL-3.0\"
    ],
    \"autoload\": {
        \"files\": [
            \"registration.php\"
        ]
    }
}
";

if(!empty($prj_name && $project_path)){
    $theme_dir = SITE_ROOT.THEME_FOLDER.'/'.$prj_name;
    $less_var_dir = $theme_dir.'/web/css/source/variables';
    if(!is_dir($theme_dir)) {
        if(mkdir($theme_dir,0775, true)) {
            echo "<div class='alert alert-success' role='alert'>Theme Folder [$theme_dir] Created.</div>";
        }
        if(file_put_contents($theme_dir.'/theme.xml', $XML)){
            echo "<div class='alert alert-success' role='alert'>Theme XML Created.</div>";
        };
        if(file_put_contents($theme_dir.'/registration.php', $REGISTRATION)){
            echo "<div class='alert alert-success' role='alert'>Registration File Created.</div>";
        };
        if(file_put_contents($theme_dir.'/composer.json', $COMPOSER)){
            echo "<div class='alert alert-success' role='alert'>Composer File Created.</div>";
        };
        if(mkdir($less_var_dir,0775, true)){
            echo "<div class='alert alert-success' role='alert'>LESS Variable Directory Created.</div>";
        };
        if(mkdir($theme_dir.'/media',0775, true) && copy('preview.png',$theme_dir.'/media/preview.png')){
            echo "<div class='alert alert-success' role='alert'>Theme Preview Image Created.</div>";
        };
    }else {
        echo "<div class='alert alert-danger' role='alert'>Theme folder Already Exist, Please Remove!</div>";
    }
}