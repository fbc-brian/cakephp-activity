 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-4 col-md-10 mx-auto">
		<div class="users form">
		<h1><?php echo __('Registration'); ?></h1>
		<?php echo $this->Flash->render(); 
		echo $this->Form->create('User'); ?>				
			<div class="form-group">
			<?php echo $this->Form->input('name', array('class' => 'form-control', 'data-validation' => 'length', 'data-validation-length' => 'min5')); ?>
			</div>
			<div class="form-group">
			<?php echo $this->Form->input('email', array('class' => 'form-control', 'data-validation' => 'email')); ?>
			</div>
			<div class="form-group">
			<?php echo $this->Form->input('password', array('class' => 'form-control', 'data-validation' => 'required')); ?>
			</div>
			<div class="form-group">
			<?php echo $this->Form->input('confirm_password', array('type'  =>  'password', 'class' => 'form-control', 'data-validation' => 'required')); ?>
			</div>
			<?php echo $this->Form->button('Register', array('class' => 'btn btn-primary')); ?>
		<?php echo $this->Form->end(); ?>
		</div>

		</div>
	</div>
</div>
