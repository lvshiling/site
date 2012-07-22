<?php /* Smarty version 2.6.19, created on 2011-04-02 17:17:45
         compiled from show_right.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'show_right.tpl', 2, false),)), $this); ?>
<script type="text/javascript">
var data_id = <?php echo ((is_array($_tmp=@$this->_tpl_vars['Data']['data_id'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
;
</script>

<div class="box2">
<iframe id="ad_right" src="<?php echo $this->_tpl_vars['Config']['domain_static']; ?>
/iframe/right.html" frameborder="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>
</div>