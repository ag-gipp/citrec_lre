<?php
namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;

use \Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\DependencyInjection\ContainerInterface;
use sciplore\DataAccessBundle\Entity\Experiment;
class OptionsService{
    protected $container;
    protected static $opt_cache = null;
    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }
    public function getContainer(){
        return $this->container;
    }
    private function __getGeneralOptions(){
        if(self::$opt_cache == null){
            $container = $this->getContainer();
            $options = array();
            $options['min_confidence'] = $container->getParameter('sciplore.validation.confidence.min');
            $options['max_confidence'] = $container->getParameter('sciplore.validation.confidence.max');
            $options['def_confidence'] = $options['min_confidence'] + floor(($options['max_confidence'] - $options['min_confidence'])/2);//result always round !!down!! to integer
           // # $container->getParameter('sciplore.measurement.json_path');
            $arr= $container->getParameter('sciplore.measurement.levels');
            $options['levels'] = $arr;
            $options['min_points'] = min(array_keys($arr));
            $options['max_points'] = max(array_keys($arr));
            //var_dump($options['min_points']);
            //var_dump( $options['max_points']);
            $options['points_selection_prefix'] = 'points_';
    
            
            //$options['min_points'] = $container->getParameter('sciplore.measurement.value.min');
            //$options['max_points'] = $container->getParameter('sciplore.measurement.value.max');
            //$options['def_points'] = $options['min_points'] + floor(($options['max_points'] - $options['min_points'])/2);//result always round !!down!! to integer
            $options['points_selection_prefix'] = 'points_';
            
            $options['autologin_enable'] = $container->getParameter('sciplore.autologin.enable');
            $options['authentifiaction_requires_password'] = $container->getParameter('sciplore.authentification.requirePassword');
            $options['autologin_create_user'] = $container->getParameter('sciplore.autologin.create_user');

            self::$opt_cache = $options;
        }
        return  self::$opt_cache;
          
    }
    public function getGeneralOptions(){
        return $this->__getGeneralOptions();
    }
    
    private function laodLevelFromJson($path){
        $json = file_get_contents($path);
        $levels = json_decode($json,true);
        return $levels;
    }
    public function retrieveOptionsForExperiment(Experiment $experiment){
        $options = array();
      
        
        $options['show_analysis'] = $experiment->getShowSmallAnalysis();
        $options['randomize_order'] = $experiment->getRandomizeOrder();
        $options['result_type'] = $experiment->getResultType()->getName();
        return array_merge($options, $this->__getGeneralOptions());
    }
}
?>