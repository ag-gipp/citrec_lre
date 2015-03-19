<?php
namespace sciplore\UIBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use sciplore\UIBundle\sciploreUIBundle;
class sciploreExtension extends Twig_Extension
{
    protected $options;
    public function __construct() {

    }

    public function getFilters()
    {
        return array(
            'level' => new Twig_Filter_Method($this, 'levelFilter'),
        );
    }

    public function levelFilter($number)
    {
        //load the levels from the Options-File
        $options = sciploreUIBundle::getGeneralOptions();
        $levels = $options['levels'];
        return $levels[$number];
    }

    public function getName()
    {
        return 'sciplore_extension';
    }
}
?>