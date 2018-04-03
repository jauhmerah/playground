<?php
namespace api\modules\v1;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        $this->modules = [
            'identity' => ['class' => 'api\modules\v1\identity\Module'],
        ];
    }
}