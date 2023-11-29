<?php
use App\Core\App;
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
 * This function is used for dark mode functionality,
 * it returns the first (dark) class string
 * or second (light class string).
 */
function theme($class, $secondClass) {
    if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == true) {
        return $class;
    }
    return $secondClass;
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
 * This function is used for generating pagination links.
 */
function paginate($table, $page, $limit, $count)
{
    $totalPages = ceil($count / $limit);
    $offset = ($page - 1) * $limit;
    $output = "<span class='". theme('text-white-75', 'text-dark')  ."'>";

    $showFirstLast = App::Config()['pagination']['show_first_last'];
    
    if ($showFirstLast && $page > 1) {
        $output .= "<a href='/{$table}/1' class='".  theme('text-light', 'text-primary') ."'>First</a> ";
    }
    
    if ($page > 1) {
        $prev = $page - 1;
        $output .= "<a href='/{$table}/{$prev}' class='".  theme('text-light', 'text-primary') ."'>Prev</a> ";
    }

    $output .= " Page $page ";
    
    if ($count > ($offset + $limit)) {
        $next = $page + 1;
        $output .= "<a href='/{$table}/{$next}' class='".  theme('text-light', 'text-primary')  ."'>Next</a> ";
    }
    
    if ($showFirstLast && $page < $totalPages) {
        $output .= "<a href='/{$table}/{$totalPages}' class='".  theme('text-light', 'text-primary') ."'>Last</a>";
    }

    $output .= "</span>";
    return $output;
}

/*
 * This function displays a session variable's value if it exists.
*/
function session($name) {
    return $_SESSION[$name] ?? "";
}

/*
 * This function displays a session variable's value and unsets it if it exists.
 */
function session_once($name) {
    if (isset($_SESSION[$name])) {
        $value = $_SESSION[$name];
        unset($_SESSION[$name]);
        return $value;
    }
    return "";
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
