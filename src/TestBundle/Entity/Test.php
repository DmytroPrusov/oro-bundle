<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\CaseBundle\Entity\CaseEntity;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnit;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * @ORM\Entity
 * @ORM\Table(name="orocrm_test_entity")
 * @ORM\HasLifecycleCallbacks
 * @Config
 */
class Test
{
    /**
     * @ORM\Id
     * @ConfigField
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @ConfigField
     */
    private $name;

    /**
     * @var CaseEntity
     * @ConfigField
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\CaseBundle\Entity\CaseEntity")
     * @ORM\JoinColumn(name="case_entity_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $case;

    /**
     * @var string
     * @ConfigField
     * @ORM\Column(name="type", type="string", columnDefinition="enum('option1', 'option2', 'option3')")
     */
    private $type;
    /**
     * @ConfigField
     * @var BusinessUnit
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\OrganizationBundle\Entity\BusinessUnit")
     * @ORM\JoinColumn(name="business_unit_owner_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $owner;

    /**
     * @var boolean
     * @ConfigField
     * @ORM\Column(name="is_primary", type="boolean", nullable=true)
     */
    protected $primary = true;

    /**
     * @var \Datetime $created
     * @ConfigField
     * @ORM\Column(type="datetime")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="oro.ui.created_at"
     *          }
     *      }
     * )
     */
    protected $createdAt;

    /**
     * @var \Datetime $updated
     * @ConfigField
     * @ORM\Column(type="datetime")
     * @ConfigField(
     *      defaultValues={
     *          "entity"={
     *              "label"="oro.ui.updated_at"
     *          }
     *      }
     * )
     */
    protected $updatedAt;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return CaseEntity
     */
    public function getCase()
    {
        return $this->case;
    }

    /**
     * @param CaseEntity|null $case
     * @return Test
     */
    public function setCase(CaseEntity $case = null)
    {
        $this->case = $case;

        return $this;
    }

    /**
     * @return BusinessUnit
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param BusinessUnit $owningBusinessUnit
     * @return Test
     */
    public function setOwner(BusinessUnit $owningBusinessUnit = null)
    {
        $this->owner = $owningBusinessUnit;

        return $this;
    }

    /**
     * Get created date/time
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set created date/time
     *
     * @param \DateTime $created
     * @return Test
     */
    public function setCreatedAt(\DateTime $created)
    {
        $this->createdAt = $created;

        return $this;
    }

    /**
     * Get last update date/time
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set last update date/time
     *
     * @param \DateTime $updated
     * @return Test
     */
    public function setUpdatedAt(\DateTime $updated)
    {
        $this->updatedAt = $updated;

        return $this;
    }

    /**
     * Pre update event handler
     * @ORM\PreUpdate
     */
    public function doUpdate()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
    }

    /**
     * @param string $type
     *
     * @return Test
     */
    public function setType($type)
    {
        if (!in_array($type, ['option1', 'option2', 'option3'])) {
            throw new \InvalidArgumentException("Invalid type");
        }
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}