<?php
namespace sciplore\DataAccessBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * 
 * @ORM\Table(name="result")
 */

class Result {

    /**
    * @ORM\Id 
    * @ORM\ManyToOne(targetEntity="User")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")  
    */
    protected $user;
    
    /**
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $time;
    
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    protected $timestamp;
    
    /**
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $confidence;
    
       /**
     * @ORM\Column(type="integer",nullable=true)
     */
    protected $value;
    
    
        /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Experiment")
     * @ORM\JoinColumn(name="experiment_id", referencedColumnName="id")
     */
    protected $experiment;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Recommendation")
     * @ORM\JoinColumn(name="recommendation_id", referencedColumnName="rec_id")
     */
    protected $recommendation;

  

    /**
     * Set time
     *
     * @param integer $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set timestamp
     *
     * @param datetime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * Get timestamp
     *
     * @return datetime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set confidence
     *
     * @param integer $confidence
     */
    public function setConfidence($confidence)
    {
        $this->confidence = $confidence;
    }

    /**
     * Get confidence
     *
     * @return integer 
     */
    public function getConfidence()
    {
        return $this->confidence;
    }

    /**
     * Set value
     *
     * @param integer $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set user
     *
     * @param sciplore\DataAccessBundle\Entity\User $user
     */
    public function setUser(\sciplore\DataAccessBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return sciplore\DataAccessBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set experiment
     *
     * @param sciplore\DataAccessBundle\Entity\Experiment $experiment
     */
    public function setExperiment(\sciplore\DataAccessBundle\Entity\Experiment $experiment)
    {
        $this->experiment = $experiment;
    }

    /**
     * Get experiment
     *
     * @return sciplore\DataAccessBundle\Entity\Experiment 
     */
    public function getExperiment()
    {
        return $this->experiment;
    }

    /**
     * Set recommendation
     *
     * @param sciplore\DataAccessBundle\Entity\Recommendation $recommendation
     */
    public function setRecommendation(\sciplore\DataAccessBundle\Entity\Recommendation $recommendation)
    {
        $this->recommendation = $recommendation;
    }

    /**
     * Get recommendation
     *
     * @return sciplore\DataAccessBundle\Entity\Recommendation 
     */
    public function getRecommendation()
    {
        return $this->recommendation;
    }
}