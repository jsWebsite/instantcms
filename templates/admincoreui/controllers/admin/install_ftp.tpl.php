<?php
    $this->setPageTitle(LANG_CP_INSTALL_PACKAGE.' «'.$manifest['info']['title'].'»');
    $this->addBreadcrumb(LANG_CP_INSTALL_PACKAGE, $this->href_to('install'));
    $this->addBreadcrumb($manifest['info']['title']);

    $this->addTplCSSName('datatree');

    $this->addMenuItem('breadcrumb-menu', [
        'title' => LANG_HELP,
        'url'   => LANG_HELP_URL_INSTALL,
        'options' => [
            'target' => '_blank',
            'icon' => 'question-circle'
        ]
    ]);

    if(!empty($manifest['notice_system_files'])){
        cmsUser::addSessionMessage($manifest['notice_system_files'], 'error');
    }

?>
<div class="alert alert-info" role="alert" id="cp_package_ftp_notices">
    <?php echo LANG_CP_INSTALL_FTP_PERM; ?><br>
    <?php echo LANG_CP_INSTALL_FTP_NOTICE; ?><br>
    <?php echo LANG_CP_INSTALL_FTP_PRIVACY; ?>
</div>

<?php
    $this->renderForm($form, $account, [
        'action' => '',
        'method' => 'post',
        'submit' => [
            'title' => LANG_CONTINUE
        ],
        'cancel' => [
            'show' => true,
            'href' => $this->href_to('addons_list')
        ]
    ], $errors); ?>

<input class="button btn btn-primary" style="display: none;" name="skip" value="<?php echo LANG_INSTALL; ?>" type="submit" id="skip">
<?php ob_start(); ?>
<script>
    $(function() {
        $('form > .buttons').prepend($('#skip'));
        $('#is_skip').on('click', function (){
            icms.forms.submitted = true;
            let form = $(this).closest('form');
            if($(this).is(':checked')){
                $(form).find('input:not([type=hidden])').not(this).not('.buttons > input').prop('disabled', true);
                $(form).find('.button-submit').hide();
                $('#skip').show();
                $(form).attr('action', '<?php echo $this->href_to('install/finish'); ?>');
            } else {
                $(form).find('input:not([type=hidden])').prop('disabled', false);
                $(form).find('.button-submit').show();
                $('#skip').hide();
                $(form).attr('action', '');
            }
        });
        $('#check_ftp').on('click', function (){
            icms.modal.openAjax($(this).attr('href'), {host: $('#host').val(), port: $('#port').val(), user: $('#user').val(), pass: $('#pass').val(), path: $('#path').val(), is_pasv: $('#is_pasv').val()}, false, '<?php echo LANG_CP_FTP_CHECK; ?>');
            return false;
        });
    });
</script>
<?php $this->addBottom(ob_get_clean()); ?>