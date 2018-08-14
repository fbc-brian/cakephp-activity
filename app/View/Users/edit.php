 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-6 col-md-10 mx-auto">
		<div class="users form">
		    <h1><?php echo __('Edit User'); ?></h1>
		    <?php echo $this->Form->create('User', array('type' => 'file')); ?>
		    <div class="clearfix">
		    	<?php echo $this->Flash->render(); ?>
			</div>
		    <div class="row info-main">
			    <div class="col-lg-4 col-md-10">
			    	<div class="user-image">
			    		<?php if ($this->request->data['User']['image']!= null): ?>
		                <?php echo $this->Html->image('uploads/'.$this->request->data['User']['image'], array('alt' => 'Profile', 'id' => 'profile')); ?>
		            	<?php else: ?> 
		                <?php echo $this->Html->image('avatar.jpg', array('alt' => 'Profile', 'id' => 'profile')); ?>
		           		<?php endif; ?>
		            </div>
		    	</div>
		    	<div class="col-lg-8 col-md-10">
		    		<?php echo $this->Form->file('image', array('id' => 'imgInp')); ?>
		    	</div>
			</div>
			<div class="row info-main">
			    <div class="col-md-12">
				<?php echo $this->Form->input('id'); ?>
					<div class="form-group">
						<?php echo $this->Form->input('name', array('class' => 'form-control')); ?>
					</div>
					<div class="form-group">
						<?php echo $this->Form->input('birthdate', array(
					    'type' => 'text',
					    'id' => 'datepicker',
					    'class' => 'form-control')); ?>
					</div>				
					<div class="form-group">
						<label><?php echo __('Gender'); ?></label>
						<div class="custom-radio">
						<?php
						$options= array(
						    '1' => 'Male',
						    '2' => 'Female'
						);
						$attributes = array(
						    'legend' => false,
						);
						echo $this->Form->radio('gender', $options, $attributes); ?>
						</div>
					</div>
					<div class="form-group">
					<?php echo $this->Form->input('email', array('class' => 'form-control')); ?>
					</div>
					<div class="form-group">
						<?php echo $this->Form->input('hubby', array('class' => 'form-control')); ?>
					</div>
				
				</div>
			</div>
			<?php echo $this->Form->end(__('Submit')); ?>
		</div>
		</div>
	</div>
</div>
