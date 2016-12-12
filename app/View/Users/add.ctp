<div>
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('ユーザー登録'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label' => '氏名'));
		echo $this->Form->input('email', array('label' => 'メールアドレス'));
	?>
	</fieldset>
<!--<?php echo $this->Form->end(__('確認')); ?>-->

<?php echo $this->Form->submit('確認'); ?>
<?php echo $this->Form->button('リセット', array('type'=>'reset')); ?>
<?php echo $this->Form->end(); ?>

</div>
