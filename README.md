# entity-column-check

このプラグインはCakePHP3のEntityにおいて

- プロパティに設定されているもの
- DBのカラムに該当するもの
- 特定の例外のカラム

以外のものがセットされている場合にExceptionを返すプラグインです

## インストール
composer.json
```
{
	"require": {
		"satthi/entity-column-check": "*"
	}
}
```

`composer install`

## 使い方

Entity
```php
<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use EntityColumnCheck\Model\Entity\EntityColumnCheckTrait;

class Topic extends Entity
{
    // 追加項目
    use EntityColumnCheckTrait;
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
    // 例外として設定するカラム
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
```
