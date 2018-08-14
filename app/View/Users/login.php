 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-4 col-md-10 mx-auto">
	    	<h1>Login</h1>
	    	<?php echo $this->Flash->render(); ?>
	    	<?php echo $this->Form->create('User'); ?>
	    	<div class="form-group">
	    		<?php echo $this->Form->input('email', array('class' => 'form-control', 'data-validation' => 'email')); ?> 
	    	</div>
	    	<div class="form-group">
	    	<?php echo $this->Form->input('password', array('class' => 'form-control', 'data-validation' => 'required')); ?>
	    	</div>
	    	<?php echo $this->Form->button('Login',array('class'=>'btn btn-primary')); ?>
	    	<?php echo $this->Form->end(); ?>
	    </div>
	 </div>
</div>