<?php /* Smarty version 2.6.19, created on 2011-04-02 17:17:45
         compiled from show_common.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'urlencode', 'show_common.tpl', 14, false),)), $this); ?>
<ul class="tabs">
<?php if ($this->_tpl_vars['Current'] == 'general'): ?>
<li class="current"><a href="#" onclick="return false;">查看内容</a></li>
<?php else: ?>
<li><a href="<?php echo $this->_tpl_vars['Data']['show_url']; ?>
">查看内容</a></li>
<?php endif; ?>

<?php if ($this->_tpl_vars['Current'] == 'comment'): ?>
<li class="current"><a href="#" onclick="return false;">网友评论</a></li>
<?php else: ?>
<li><a href="<?php echo $this->_tpl_vars['Config']['domain_comment']; ?>
/<?php echo $this->_tpl_vars['Data']['hash_id']; ?>
-1.html">网友评论</a></li>
<?php endif; ?>

<li><a href="javascript:void(0);" onclick="reportWindow('<?php echo ((is_array($_tmp=$this->_tpl_vars['Data']['show_url'])) ? $this->_run_mod_handler('urlencode', true, $_tmp) : urlencode($_tmp)); ?>
');return false;">举报</a></li>
</ul>

<h1 id="title"><?php echo $this->_tpl_vars['Data']['data_title']; ?>
</h1>