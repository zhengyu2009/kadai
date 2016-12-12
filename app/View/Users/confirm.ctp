<div>
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('登録情報のご確認'); ?></legend>
	<p>氏名： <?php echo $this->data['User']['name']; ?></p>
	<p>メールアドレス：<?php echo $this->data['User']['email']; ?></p>
	<?php
		echo $this->Form->hidden('name');
		echo $this->Form->hidden('email');
	?>
	</fieldset>
<div style="display:inline-flex">
<?php echo $this->Form->submit('完了', array('label' => 'save', 'name' => 'save')); ?>
<?php echo $this->Form->submit('修正', array('label' => 'edit', 'name' => 'edit', 'style' => 'background-color:grey;background-image:none')); ?>
<?php echo $this->Form->end(); ?>
</div>
</div>
