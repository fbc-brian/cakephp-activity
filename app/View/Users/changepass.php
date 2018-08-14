 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-6 col-md-10 mx-auto">
		<div class="users form">
		    <h1><?php echo __('Edit Password'); ?></h1>
		    <?php echo $this->Form->create('User'); ?>
		    <?php echo $this->Flash->render(); ?>
			<div class="row info-main">
			    <div class="col-md-12">
				<?php echo $this->Form->input('id'); ?>
					<div class="form-group">
						<?php echo $this->Form->input('old_password', array('class' => 'form-control', 'type' => 'password', 'data-validation' => 'required')); ?>
					</div>			
				</div>

			    <div class="col-md-12">
					<div class="form-group">
						<?php echo $this->Form->input('password', array('class' => 'form-control', 'type' => 'password', 'data-validation' => 'required')); ?>
					</div>			
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?php echo $this->Form->input('confirm_password', array('class' => 'form-control', 'type' => 'password', 'data-validation' => 'required')); ?>
					</div>			
				</div>
			</div>
			<?php echo $this->Form->end(__('Submit')); ?>
		</div>
		</div>
	</div>
</div>
