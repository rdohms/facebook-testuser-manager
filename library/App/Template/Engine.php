<?php
namespace App\Template;

class Engine extends \Twig_Environment
{
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(\TPL_PATH);

        //parent::__construct($loader, array('cache', \TPL_PATH . 'cache'));
        parent::__construct($loader);

    }

}

?>
