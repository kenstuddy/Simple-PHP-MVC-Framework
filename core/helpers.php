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
 * This function is used for generating pagination links.
 */
function paginate($table, $page, $limit, $count)
{
    $offset = ($page - 1) * $limit;
    $output = "<span class='text-dark'>";
    if ($page > 1) {
        $prev = $page - 1;
        $output .= "<a href='/{$table}/{$prev}' class='text-primary'>Prev</a>";
    }
    $output .= " Page $page ";
    if ($count > ($offset + $limit)) {
        $next = $page + 1;
        $output .= "<a href='/{$table}/{$next}' class='text-primary'>Next</a>";
    }
    $output .= "</span>";
    return $output;
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
