<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
		echo $this->Html->css('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
		echo $this->Html->css('//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css');
		echo $this->Html->css('style');
		echo $this->Html->script('//code.jquery.com/jquery-1.12.4.js');
	?>
</head>
<body>
	<?php if (AuthComponent::user()): ?>
	<nav class="navbar navbar-expand-lg">
	  <ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<p><?php echo $this->HTML->link(AuthComponent::user('name'), array('controller' => 'users', 'action' => 'view', AuthComponent::user('id'))); ?></p>
			</li>
			<li class="nav-item">
				<?php echo $this->HTML->link(__('Messages'), array('controller' => 'messages', 'action' => 'index')); ?>
			</li>
			<li class="nav-item">
				<?php echo $this->HTML->link(__('Logout'), array('controller' => 'users', 'action' => 'logout')); ?>
			</li>
	  </ul>
	  
	</nav>
	<?php endif; ?>

	<?php	
	echo $this->fetch('content'); 
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js');
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js');
	echo $this->Html->script('//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js');
	echo $this->Html->script('//code.jquery.com/ui/1.12.1/jquery-ui.js');
	echo $this->Html->script('//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js');
	echo $this->Html->script('https://www.jqueryscript.net/demo/Trim-Text-Lines-jQuery-moreLines/jquery.morelines.js');
	echo $this->Html->script('datepicker');
	?>
</body>
</html>

