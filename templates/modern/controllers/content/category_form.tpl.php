<?php

    $page_title =   $do=='add' ?
                    $ctype['title'] . ': <span class="text-muted">' . LANG_ADD_CATEGORY . '</span>':
                    $ctype['title'] . ': <span class="text-muted">' . LANG_EDIT_CATEGORY . '</span>';

    $this->setPageTitle($do=='add' ? LANG_ADD_CATEGORY : LANG_EDIT_CATEGORY);

    if ($ctype['options']['list_on']){
        $this->addBreadcrumb($ctype['title'], href_to($ctype['name']));
    }

    $this->addBreadcrumb($do=='add' ? LANG_ADD_CATEGORY : LANG_EDIT_CATEGORY);

    $this->addToolButton([
        'class' => 'save process-save',
        'title' => LANG_SAVE,
        'href'  => '#',
        'icon'  => 'save'
    ]);

    $this->addToolButton([
        'class' => 'cancel',
        'icon'  => 'undo',
        'title' => LANG_CANCEL,
        'href'  => $back_url ? $back_url : href_to($ctype['name'])
    ]);

?>

<h1><?php echo $page_title ?></h1>

<?php

    $category['ctype_name'] = $ctype['name'];

    $this->renderForm($form, $category, [
        'action' => '',
        'cancel' => ['show' => true, 'href' => $back_url ? $back_url : href_to($ctype['name'])],
        'method' => 'post',
        'toolbar' => false
    ], $errors);
