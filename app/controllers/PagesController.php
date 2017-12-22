<?php
/*
 * This is the page controller. It returns a view for pages in the framework and 
 * is where you would put a view for any additional pages that may be added later.
 */

namespace App\Controllers;

class PagesController
{
    /*
     * This function grabs the home view.
     */
    public function home()
    {

        return view('index');
    }
    /*
     * This function grabs the about view and passes the company variable so it can be extracted by the view.
     */
    public function about()
    {
        $company = "My Company";
        return view('about', compact('company'));
    }
    /*
     * This function grabs the contact view.
     */
    public function contact()
    {
        return view('contact');
    }
}


?>
