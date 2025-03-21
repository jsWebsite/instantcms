<?php

class actionSubscriptionsList extends cmsAction {

    use icms\traits\controllers\actions\listgrid;

    public function __construct($controller, $params = []) {

        parent::__construct($controller, $params);

        $this->table_name = 'subscriptions';
        $this->grid_name  = 'subscriptions';
        $this->title      = LANG_SBSCR_LIST;

        $this->item_callback = function ($item, $model) {

            $item['params'] = cmsModel::stringToArray($item['params']);

            return $item;
        };

        $this->items_callback = function ($items) {

            return cmsEventsManager::hook('admin_subscriptions_list', $items);
        };
    }

}
