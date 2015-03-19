<?php

namespace sciplore;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerInterface;
abstract class AbstractSciploreBundle extends Bundle
{
        private static $containerInstance = null;
        public function setContainer(ContainerInterface $container = null)
        {
            parent::setContainer($container);
            self::$containerInstance = $container;
        }
        
        public static function getContainer()
        {
            return self::$containerInstance;
        }
        public static function getGeneralOptions(){
               return self::getContainer()->get('sciplore.options')->getGeneralOptions();
        }
}
?>