<?php 
namespace APA_ART\Inc;

use APA_ART\Inc\Traits\Singelton;

class APA_ART {
    use Singelton;  

    protected function __construct() {

        wp_die('hello');

        //load class
        $this->set_hooks();
    }

    protected function __set_hooks() {
        
    }
}

?>