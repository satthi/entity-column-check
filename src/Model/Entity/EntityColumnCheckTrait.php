<?php

namespace EntityColumnCheck\Model\Entity;

use Cake\Core\Configure;
use Cake\Network\Exception\InternalErrorException;
use Cake\Utility\Inflector;

trait EntityColumnCheckTrait
{
    /**
     * getEntityColumnCheck
     * @author hagiwara
     */
    private function getEntityColumnCheck($property)
    {
        // debug時のみ発動する
        if (!Configure::read('debug')) {
            return;
        }
        // 設定されていなくても例外的にOKとするメソッド
        $exceptOkProperties = [
            'entityColumnCheckAllowField',
            '_method',
        ];
        // フィールド許可用のメソッドは対象外とする
        if (in_array($property, $exceptOkProperties, true)) {
            return;
        }

        // 新規の場合はチェックしない
        if ($this->isNew()) {
            return;
        }

        // プロパティに値がいる場合はOK
        if (array_key_exists($property, $this->_properties)) {
            return;
        }

        // プロパティが設定されている場合はOK
        if (property_exists($this, $property)) {
            return;
        }

        // getterがセットされている場合はOK
        $snakeMethod = '_get' . Inflector::underscore($property);
        $titleMethod = '_get' . ucfirst($property);
        if (
            method_exists($this, $snakeMethod ) ||
            method_exists($this, $titleMethod )
        ) {
            return;
        }

        // entityColumnCheckAllowFieldに値がセットされている場合はOKとする
        if (is_array($this->entityColumnCheckAllowField) && in_array($property, $this->entityColumnCheckAllowField)) {
            return;
        }

       // 上記条件に当てはまらない場合はException
        throw new InternalErrorException('invalid entity(' . get_class($this) . ') paramater(' . $property . ')');
    }
}
