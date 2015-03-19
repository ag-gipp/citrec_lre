<?php

namespace sciplore\DataAccessBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * @ORM\Table(name="pmcfileabstract")
 */
class Document {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="pmcid")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=2047, nullable=false)
     */
    protected $title;
     /**
     * @ORM\Column(type="string", length=2047, nullable=false)
     */
    protected $abstract;   

    
    
    public function getId()
    {
        return $this->id;
    }
    public function getPMCID(){
        return $this->id;
    }


    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    public function getPMCUrl(){
        return 'http://www.ncbi.nlm.nih.gov/pmc/articles/PMC'.$this->getPMCID().'/pdf/';
    }
     /**
     * Get Reference to Abstract Instance
     *
     * @return Abstract 
     */
    public function getAbstractText(){
        return $this->abstract;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Get abstract
     *
     * @return string 
     */
    public function getAbstract()
    {
        return $this->abstract;
    }
}