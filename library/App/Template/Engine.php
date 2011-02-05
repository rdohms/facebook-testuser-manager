<?php
namespace App\Template;

/**
 * Wraps the Twig Engine, for configuration
 * 
 * @category FBTUM
 * @package App
 */
class Engine extends \Twig_Environment
{
    /**
     * Loads the Twig loader and configures it
     */
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(\TPL_PATH);

        //parent::__construct($loader, array('cache', \TPL_PATH . 'cache'));
        parent::__construct($loader);

    }

}

?>
