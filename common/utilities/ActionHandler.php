<?php
namespace common\utilities;

use Yii;

class ActionHandler extends \codetitan\handlers\ActionHandler
{
    public function populate()
    {
        parent::populate();

        $action['block'] = function () {
            $model = get_class($this->model);
            $count = $model::updateAll(['is_disabled' => 1], ['id' => $this->selections, 'is_deleted' => 0]);
            if ($count) $this->setFlash('success', static::t('{count} item blocked', ['count' => $count]).'.');
        };

        $action['unblock'] = function () {
            $model = get_class($this->model);
            $count = $model::updateAll(['is_disabled' => 0], ['id' => $this->selections, 'is_deleted' => 0]);
            if ($count) $this->setFlash('success', static::t('{count} item unblocked', ['count' => $count]).'.');
        };

        $this->actions = array_merge($this->actions, $action);
    }
}