<?php
/**
 * Created by PhpStorm.
 * User: trajakaruna
 * Date: 3/9/2018
 * Time: 8:48 AM
 */
include ('config.php');

function lessElement($variable = '', $value = '')
{
    $variable = trim($variable);
    $value = trim($value);
    echo "<div class='less-mod row'><div class= 'variable'>$variable</div><div class='value'><input type='text' placeholder='$value' /></div></div>";
}