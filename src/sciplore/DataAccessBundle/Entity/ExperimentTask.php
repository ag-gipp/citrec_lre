<?php

namespace sciplore\DataAccessBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="experiment_task")
 */
class ExperimentTask {
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumn(name="ref_doc_id", referencedColumnName="pmcid")
     */
    protected $reference_document;
    
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Experiment")
     * @ORM\JoinColumn(name="experiment_id", referencedColumnName="id")
     */
    protected $experiment;
    
   /**
     * @ORM\Column(type="integer",nullable=false)
     */
    protected $position;


    /**
     * Set position
     *
     * @param integer $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set reference_document
     *
     * @param sciplore\DataAccessBundle\Entity\Document $referenceDocument
     */
    public function setReferenceDocument(\sciplore\DataAccessBundle\Entity\Document $referenceDocument)
    {
        $this->reference_document = $referenceDocument;
    }

    /**
     * Get reference_document
     *
     * @return sciplore\DataAccessBundle\Entity\Document 
     */
    public function getReferenceDocument()
    {
        return $this->reference_document;
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
}