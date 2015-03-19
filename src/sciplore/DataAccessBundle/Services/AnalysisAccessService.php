<?php
namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;

use \Doctrine\ORM\Query\ResultSetMapping;
class AnalysisAccessService extends AbstractService{
 
 
 
    public function getDataForAnalysis($experiment_id,$resultType, $user_id=null){
        $q = self::getSQLString($experiment_id, $resultType, $user_id);//get the sql string
        $result = $this->executeSQLQuery($q);//execute the sql string
        return $result;
    }
 
 
 
    private static function getSQLString($experiment_id,$resultType, $user_id=null){
        
        $q = null;
        $user_where_string = is_null($user_id)? '' : "AND res.user_id = {strval($user_id)}";
        //concanate the sql strings depend on the resultType
        switch($resultType){
            case 'nominal':
                $q = "SELECT m.name AS method, count(X.value) AS number FROM method m
                    LEFT JOIN 
                            (SELECT * FROM recommendation rec 
                             JOIN result res ON rec.rec_id = res.recommendation_id 
                             WHERE res.value = 1 AND res.experiment_id = {$experiment_id} {$user_where_string}
                             )X
                    ON m.id = X.method_id
                    GROUP BY m.name;";
                break;
            case 'ordinal':
                
                $q = "SELECT m.name AS method, avg(X.value) AS number FROM method m
                      LEFT JOIN 
                            (SELECT * FROM recommendation rec 
                             JOIN result res ON rec.rec_id = res.recommendation_id 
                             WHERE res.experiment_id = {$experiment_id} {$user_where_string}
                             )X
                    ON m.id = X.method_id GROUP BY m.name;";
                break;
        }
        
        //AnalysisAccessService::writeQueryToLogFile($q,'/tmp/db.log');
        return $q;
   }
   //a small help function th debug
    private static function writeQueryToLogFile($q, $filename){
        $File = $filename;
        $Handle = fopen($File, 'a');
        fwrite($Handle, $q."\n"); 
        fclose($Handle);
    }

    
    private function executeSQLQuery($query){
        $rsm = new ResultSetMapping;
        $rsm->addScalarResult('method', 'method');
        $rsm->addScalarResult('number', 'number');
        $query = $this->em->createNativeQuery($query, $rsm);
        $result = $query->getResult();
        return $this->buildResultArray($result);
    }
    //map the db result to the desired data structure for the javascript
    private function buildResultArray($result){
        $arr = array();
        foreach ($result as $row){
            //cast the number to a float
            $number = (is_null($row['number']))? 0 : \floatval($row['number']);
            $arr[] = array('method' => $row['method'], 'number' =>  $number);

        }
        return $arr;
    }
}