<?php
/**
 * 2.16.3 => 2.17.0
 */
function install_package(){

    $core = cmsCore::getInstance();
    $admin = cmsCore::getController('admin');
    $content_model = cmsCore::getModel('content');

    if(!$core->db->isFieldExists('tags', 'description', false)){
        $core->db->query("ALTER TABLE `{#}tags` ADD `description` TEXT NULL DEFAULT NULL AFTER `tag`;");
    }

    if(!$core->db->isFieldExists('widgets_bind', 'url_mask_not', false)){
        $core->db->query("ALTER TABLE `{#}widgets_bind` ADD `url_mask_not` TEXT NULL DEFAULT NULL COMMENT 'Отрицательные маски виджета' AFTER `groups_hide`;");
    }

    $ctypes = $content_model->getContentTypes();

    foreach($ctypes as $ctype){

        $table_name = $content_model->table_prefix . $ctype['name'] . '_props';

        $content_model->db->query("UPDATE `{#}{$table_name}` SET `type`='listbitmask' WHERE `type` = 'list_multiple'");
    }

    ////////////////////////////////////////////////////////////////////////////
    ////////////// Новые правила доступа ///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////
    ///////////////// Индексы //////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////

    $remove_table_indexes = [];
    $add_table_indexes = [];

    if($remove_table_indexes){
        foreach ($remove_table_indexes as $table=>$indexes) {
            foreach ($indexes as $index_name) {
                $core->db->dropIndex($table, $index_name);
            }
        }
    }
    if($add_table_indexes){
        foreach ($add_table_indexes as $table=>$indexes) {
            foreach ($indexes as $index_name => $fields) {
                $core->db->addIndex($table, $fields, $index_name);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////
    ////////////// Обновляем события ///////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    $diff_events = $admin->getEventsDifferences();

    if($diff_events['added']){
        foreach ($diff_events['added'] as $controller => $events) {
            foreach ($events as $event){
                $admin->model->addEvent($controller, $event);
            }
        }
    }

    if($diff_events['deleted']){
        foreach ($diff_events['deleted'] as $controller => $events) {
            foreach ($events as $event){
                $admin->model->deleteEvent($controller, $event);
            }
        }
    }

    //compile_scss_if_necessary();

    return true;
}

// добавление прав доступа
function add_perms($data, $type, $options = null) {

    $model = new cmsModel();

    foreach ($data as $controller => $names) {

        foreach ($names as $name) {

            if(!$model->db->getRowsCount('perms_rules', "controller = '{$controller}' AND name = '{$name}'", 1)){
                $model->insert('perms_rules', array(
                    'controller' => $controller,
                    'name'       => $name,
                    'type'       => $type,
                    'options'    => $options
                ));
            }

        }

    }

}

// настройки контроллеров для пересохранения
function save_controller_options($controllers) {

    $model = new cmsModel();

    foreach ($controllers as $controller) {
        $controller_root_path = cmsConfig::get('root_path').'system/controllers/'.$controller.'/';
        $form_file = $controller_root_path.'backend/forms/form_options.php';
        $form_name = $controller.'options';
        cmsCore::loadControllerLanguage($controller);
        cmsCore::includeFile('system/controllers/'.$controller.'/model.php');
        try {
            $form = cmsForm::getForm($form_file, $form_name, false);
            if ($form) {
                $options = $form->parse(new cmsRequest(cmsController::loadOptions($controller)));
                $model->filterEqual('name', $controller)->updateFiltered('controllers', array(
                    'options' => $options
                ));
            }
        } catch (Exception $exc) {
            cmsUser::addSessionMessage('Настройки компонента '.$controller.' сохранились с ошибкой. Пересохраните их самостоятельно в админке.', 'error');
        }
    }

}

function compile_scss_if_necessary() {

    $template_name = cmsConfig::get('template');

    $template = new cmsTemplate($template_name);

    $options = $template->getOptions();

    $manifest = $template->getManifest();

    if($manifest !== null && !empty($manifest['properties']['style_middleware'])){

        $renderer = cmsCore::getController('renderer', new cmsRequest([
            'middleware' => $manifest['properties']['style_middleware']
        ]), cmsRequest::CTX_INTERNAL);

        $renderer->cms_template = $template;

        $renderer->render($template_name, $options);
    }

}
