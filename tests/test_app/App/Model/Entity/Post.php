<?php
namespace EntityColumnCheck\Test\App\Model\Entity;

use Cake\ORM\Entity;
use EntityColumnCheck\Model\Entity\EntityColumnCheckTrait;

/**
 * Post Entity.
 */
class Post extends Entity
{
use EntityColumnCheckTrait;
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public $entityProperty = 'test';
    public $entityPropertyNull = null;

    protected $entityColumnCheckAllowField = [
        'file',
        'img'
    ];

    //&getメソッドをoverride
    public function &get($property)
    {
        $value = parent::get($property);
        $this->getEntityColumnCheck($property);
        return $value;
    }

}
