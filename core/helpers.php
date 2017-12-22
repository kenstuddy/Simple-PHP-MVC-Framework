<?php
/*
 * This function redirects the user to a page.
 */
function redirect($path)
{
    header("Location: /{$path}");
}
/*
 * This function returns the view of a page.
 */
function view($name, $data = [])
{
    extract($data);
    return require "../app/views/{$name}.view.php";
}
/*
 * This function is used for dying and dumping.
 */
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}
/*
 * This function enables displaying of errors in the web browser.
 */
function display_errors()
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
?>
