<?php

class onRssCtypeBeforeAdd extends cmsAction {

    public function run($ctype) {

        $this->model->addFeed([
            'ctype_name'  => $ctype['name'],
            'title'       => $ctype['title'],
            'description' => $ctype['description'],
            'mapping'     => [
                'title'       => 'title',
                'description' => 'content',
                'pubDate'     => 'date_pub',
                'image'       => '',
                'image_size'  => 'normal'
            ],
            'is_enabled'  => $ctype['options']['is_rss']
        ]);

        return $ctype;
    }

}
