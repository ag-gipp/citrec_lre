<?php


namespace sciplore\DataAccessBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * 
 * @ORM\Table(name="recommendation")
 */
class Recommendation {
         /**
     * 
     * 
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumn(name="doc_id", referencedColumnName="pmcid")
     */
    protected $document;
     
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Method")
     * @ORM\JoinColumn(name="method_id", referencedColumnName="id")
     */    
    protected $method;
    
    /**
     * @ORM\Column(type="integer", name="rec_id")
     *  @ORM\Id
     *  
     */
    protected $rec_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumn(name="rec_doc_id", referencedColumnName="pmcid")
     
     */
    protected $recommended_document;
    



    /**
     * Get document
     *
     * @return Document 
     */
    public function getDocument()
    {
        return $this->document;
    }


    /**
     * Get method
     *
     * @return Method 
     */
    public function getMethod()
    {
        return $this->method;
    }


    /**
     * Get rec_id
     *
     * @return integer 
     */
    public function getRecId()
    {
        return $this->rec_id;
    }


    /**
     * Get recommended_document
     *
     * @return Document 
     */
    public function getRecommendedDocument()
    {
        return $this->recommended_document;
    }

    /**
     * Set rec_id
     *
     * @param integer $recId
     */
    public function setRecId($recId)
    {
        $this->rec_id = $recId;
    }

    /**
     * Set document
     *
     * @param sciplore\DataAccessBundle\Entity\Document $document
     */
    public function setDocument(\sciplore\DataAccessBundle\Entity\Document $document)
    {
        $this->document = $document;
    }

    /**
     * Set method
     *
     * @param sciplore\DataAccessBundle\Entity\Method $method
     */
    public function setMethod(\sciplore\DataAccessBundle\Entity\Method $method)
    {
        $this->method = $method;
    }

    /**
     * Set recommended_document
     *
     * @param sciplore\DataAccessBundle\Entity\Document $recommendedDocument
     */
    public function setRecommendedDocument(\sciplore\DataAccessBundle\Entity\Document $recommendedDocument)
    {
        $this->recommended_document = $recommendedDocument;
    }
}