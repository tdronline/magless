<?php
/**
 * Created by PhpStorm.
 * User: trajakaruna
 * Date: 3/9/2018
 * Time: 12:34 PM
 */

require_once("functions.php");

$less_file = $_POST['lessfile'];
$less = file_get_contents(SITE_ROOT.VAR_FOLDER.'/'.$less_file);
$less_array =  preg_split('/\r\n|\r|\n/', $less);

//print_r($less_array); exit;
$less_array = array_filter($less_array);
foreach ($less_array as $less_var) {
    if (strpos($less_var, '@') !== false) {
        $vars = explode(':', $less_var);
        if (sizeof($vars) > 1) {
            lessElement($vars[0], $vars[1]);
        } else {
            if (strpos($less_var, '/*') !== false) {
                $less_var = substr($less_var, 2, -2);
                echo "<h2>$less_var</h2>";
            } else {
                lessElement($less_var, '');
            }
        }
    }
}