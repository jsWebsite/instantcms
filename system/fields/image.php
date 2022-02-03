<?php

class fieldImage extends cmsFormField {

    public $title       = LANG_PARSER_IMAGE;
    public $sql         = 'text';
    public $allow_index = false;
    public $var_type    = 'array';

    protected $teaser_url = '';
    
    protected $use_language = true;

    public function getOptions() {

        // Чтобы при выводе поля ненужное не грузилось
        $preset_generator = function (){
            static $presets = null;
            if($presets === null){
                $presets = cmsCore::getModel('images')->getPresetsList(true);
                $presets['original'] = LANG_PARSER_IMAGE_SIZE_ORIGINAL;
            }
            return $presets;
        };

        return [
            new fieldList('size_teaser', [
                'title'     => LANG_PARSER_IMAGE_SIZE_TEASER,
                'default'   => 'small',
                'generator' => function () use($preset_generator) {
                    return $preset_generator();
                },
                'extended_option' => true
            ]),
            new fieldList('size_full', [
                'title'     => LANG_PARSER_IMAGE_SIZE_FULL,
                'default'   => 'big',
                'generator' => function () use($preset_generator) {
                    return $preset_generator();
                }
            ]),
            new fieldList('size_modal', [
                'title'     => LANG_PARSER_IMAGE_SIZE_MODAL,
                'default'   => '',
                'generator' => function () use($preset_generator) {
                    return ['' => ''] + $preset_generator();
                }
            ]),
            new fieldListMultiple('sizes', [
                'title'     => LANG_PARSER_IMAGE_SIZE_UPLOAD,
                'default'   => 0,
                'generator' => function () use($preset_generator) {
                    return $preset_generator();
                },
                'rules' => [['required']]
            ]),
            new fieldCheckbox('allow_import_link', [
                'title' => LANG_PARSER_IMAGE_ALLOW_IMPORT_LINK
            ]),
            new fieldImage('default_image', [
                'title'           => LANG_PARSER_IMAGE_DEFAULT,
                'extended_option' => true
            ]),
			new fieldCheckbox('show_to_item_link', [
                'title' => LANG_F_IMAGE_TO_ITEM_LINK,
                'default' => true
            ])
        ];
    }

    public function setTeaserURL($url){
        $this->teaser_url = $url;
        return $this;
    }

    private function getParsePaths($value){

        $paths = is_array($value) ? $value : cmsModel::yamlToArray($value);

        if (!$paths && ($this->hasDefaultValue() || $this->getOption('default_image'))){
            $paths = $this->parseDefaultPaths();
        }

        return $paths ?: [];
    }

    public function parseTeaser($value){

        $paths = $this->getParsePaths($value);

        $size_teaser = $this->getOption('size_teaser');

        if (!$paths || !isset($paths[$size_teaser])){ return ''; }

        $url = $this->teaser_url ?
                $this->teaser_url :
                href_to($this->item['ctype']['name'], $this->item['slug'] . '.html');

        if (!empty($this->item['is_private_item'])) {
            $paths = default_images('private', $size_teaser);
        }

        $img_html = html_image($paths, $size_teaser, (empty($this->item['title']) ? $this->name : $this->item['title']));

        $show_to_item_link = $this->getOption('show_to_item_link');

        return !empty($this->item['is_private_item']) || !$show_to_item_link ? $img_html : '<a href="'.$url.'">'.$img_html.'</a>';
    }

    public function parse($value){

        $paths = $this->getParsePaths($value);

        $size_full = $this->getOption('size_full');
        $size_modal = $this->getOption('size_modal');

        if (!$paths || !isset($paths[$size_full])){ return ''; }

        $presets = [$size_full, false];

        // Для анимации конвертированных GIF необходим модуль Imagick для PHP
        if(!empty($paths['original']) && strtolower(pathinfo($paths['original'], PATHINFO_EXTENSION)) === 'gif'){
            $img_func = 'html_gif_image';
        } else {
            $img_func = 'html_image';
            if($size_modal){ $presets[1] = $size_modal; }
        }

        return $img_func($paths, $presets, (empty($this->item['title']) ? $this->name : $this->item['title']));
    }

    public function getStringValue($value){ return ''; }

    public function store($value, $is_submitted, $old_value=null){

        if (!is_null($old_value) && !is_array($old_value)){

            $old_value = cmsModel::yamlToArray($old_value);

            if ($old_value != $value){
                foreach($old_value as $image_url){
                    files_delete_file($image_url, 2);
                }
            }

        }

        $sizes = $this->getOption('sizes');

        if (empty($sizes) || empty($value)) { return $value; }

        $upload_path = cmsConfig::get('upload_path');

        $image_urls = [];

        foreach($value as $size => $image_url){

            $image_url = str_replace(['"', "'", ' ', '#'], '', html_entity_decode($image_url));

            if(!is_file($upload_path.$image_url)){
                continue;
            }

            if (!in_array($size, $sizes)){
                files_delete_file($image_url, 2); continue;
            }

            $image_urls[$size] = $image_url;
        }

        return $image_urls ?: null;
    }

    public function getFiles($value){

        if (empty($value)) { return false; }

        if (!is_array($value)){ $value = cmsModel::yamlToArray($value); }

        $files = [];

        foreach($value as $image_url){
            $files[] = $image_url;
        }

        return $files;
    }

    public function delete($value){

        if (empty($value)) { return true; }

        if (!is_array($value)){ $value = cmsModel::yamlToArray($value); }

        $files_model = cmsCore::getModel('files');

        foreach($value as $image_url){

            $file = $files_model->getFileByPath($image_url);
            if (!$file) {
                files_delete_file($image_url, 2);
                continue;
            }

            $files_model->deleteFile($file['id']);
        }

        return true;
    }

    public function parseDefaultPaths() {

        $default_image = $this->getOption('default_image');
        if ($default_image) { return $default_image; }

        $string = $this->getDefaultValue();
        if (!$string) { return false; }

        $items = [];
        $rows  = explode("\n", $string);

        if (is_array($rows)) {
            foreach ($rows as $row) {
                $item = explode('|', trim($row));
                $items[trim($item[0])] = trim($item[1]);
            }
        }

        return $items;
    }

    public function getFilterInput($value = false) {
        return html_checkbox($this->name, (bool) $value);
    }

    public function applyFilter($model, $value) {
        return $model->filterNotNull($this->name);
    }

    public function getInput($value){

        $this->data['paths'] = false;

        if($value){
            $this->data['paths'] = is_array($value) ? $value : cmsModel::yamlToArray($value);
        }

        $this->data['id'] = $this->id;
        $this->data['sizes'] = $this->getOption('sizes');
        $this->data['allow_import_link'] = $this->getOption('allow_import_link');

        $this->data['images_controller'] = cmsCore::getController('images', new cmsRequest($this->context_params, cmsRequest::CTX_INTERNAL));

        return parent::getInput($value);
    }

    public function hookAfterAdd($content_table_name, $field, $model){

        if(!empty($field['options']['default_image'])){
            $this->deleteUnnecessaryDefaultImage($field['options']['default_image']);
        }

        return parent::hookAfterAdd($content_table_name, $field, $model);
    }

    public function hookAfterUpdate($content_table_name, $field, $field_old, $model) {

        if(!empty($field['options']['default_image'])){
            $this->deleteUnnecessaryDefaultImage($field['options']['default_image']);
        }

        return parent::hookAfterUpdate($content_table_name, $field, $field_old, $model);
    }

    private function deleteUnnecessaryDefaultImage($default_image) {

        $sizes = $this->getOption('sizes', []);

        foreach($default_image as $size => $image_url){

            if (!in_array($size, $sizes)){
                files_delete_file($image_url, 2);
            }
        }

        return $this;
    }

    public function hookAfterRemove($content_table_name, $field, $model){

        if(!empty($field['options']['default_image'])){
            foreach($field['options']['default_image'] as $size => $image_url){
                files_delete_file($image_url, 2);
            }
        }

        return parent::hookAfterRemove($content_table_name, $field, $model);
    }

}
