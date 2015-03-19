<?php

namespace sciplore\DataAccessBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="experiment")
 * 
 */
class Experiment {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
     /**
     * @ORM\Column(type="string", length=500, nullable=false)
     */
    protected $name;
     /**
     * @ORM\Column(type="string", name="Description",length=1023, nullable=true)
     */
    protected $description;

    
    /**
     *@ORM\OneToMany(targetEntity="ExperimentTask", mappedBy="experiment")
     * 
     */
    protected $tasks;
   //Now all the options are defined 
     /**
     * @ORM\Column(type="boolean", name="show_small_analysis", nullable=true)
     */    
    protected $show_small_analysis;
    
     /**
     * @ORM\Column(type="boolean", name="randomize_order", nullable=true)
     */    
    protected $randomize_order;
    
     /**
     * @ORM\Column(type="boolean", name="debug_view", nullable=true)
     */    
    protected $debug_view;
    
    
    /**
     * @ORM\Column(type="boolean", name="visible", nullable=false)
     */    
    protected $visible;
    
    /**
     * @ORM\ManyToOne(targetEntity="ResultType")
     * @ORM\JoinColumn(name="result_type_id", referencedColumnName="id")
     */
    protected $result_type;
    

    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set show_small_analysis
     *
     * @param boolean $showSmallAnalysis
     */
    public function setShowSmallAnalysis($showSmallAnalysis)
    {
        $this->show_small_analysis = $showSmallAnalysis;
    }

    /**
     * Get show_small_analysis
     *
     * @return boolean 
     */
    public function getShowSmallAnalysis()
    {
        return $this->show_small_analysis;
    }

    /**
     * Set randomize_order
     *
     * @param boolean $randomizeOrder
     */
    public function setRandomizeOrder($randomizeOrder)
    {
        $this->randomize_order = $randomizeOrder;
    }

    /**
     * Get randomize_order
     *
     * @return boolean 
     */
    public function getRandomizeOrder()
    {
        return $this->randomize_order;
    }

    /**
     * Set debug_view
     *
     * @param boolean $debugView
     */
    public function setDebugView($debugView)
    {
        $this->debug_view = $debugView;
    }

    /**
     * Get debug_view
     *
     * @return boolean 
     */
    public function getDebugView()
    {
        return $this->debug_view;
    }

    /**
     * Add tasks
     *
     * @param sciplore\DataAccessBundle\Entity\ExperimentTask $tasks
     */
    public function addExperimentTask(\sciplore\DataAccessBundle\Entity\ExperimentTask $task)
    {
        $this->tasks[] = $task;
    }

    /**
     * Get tasks
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * Set result_type
     *
     * @param sciplore\DataAccessBundle\Entity\ResultType $resultType
     */
    public function setResultType(\sciplore\DataAccessBundle\Entity\ResultType $resultType)
    {
        $this->result_type = $resultType;
    }

    /**
     * Get result_type
     *
     * @return sciplore\DataAccessBundle\Entity\ResultType 
     */
    public function getResultType()
    {
        return $this->result_type;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }
}