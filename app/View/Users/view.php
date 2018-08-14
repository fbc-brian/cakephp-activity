 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-6 col-md-10 mx-auto">

		<div class="users view">
			<h1><?php echo __('User Profile'); ?></h1>
			<?php echo $this->Flash->render(); ?>
			<div class="row info-main">
		    	<div class="col-lg-4 col-md-10">
		    		<div class="user-image">
		    			<?php if ($user['User']['image'] != null): ?>
	                    <?php echo $this->Html->image('uploads/'.$user['User']['image'], array('alt' => 'Profile', 'id' => 'profile')); ?>
	                    <?php else: ?>
	                    <?php echo $this->Html->image('avatar.jpg', array('alt' => 'Profile', 'id' => 'profile')); ?>
	                    <?php endif; ?>
	                </div>
		    	</div>
		    	<div class="col-lg-8 col-md-10">
		    		<h3><?php echo h($user['User']['name']); ?></h3>
		    		<ul>
		    			<li><?php echo __('Gender'); ?>: <?php echo h($user['User']['gender']); ?></li>
		    			<li><?php echo __('Birthdate'); ?>: <?php echo h($user['User']['birthdate']); ?></li>
		    			<li><?php echo __('Joined'); ?>: <?php echo h($user['User']['created']); ?></li>
		    			<li><?php echo __('Last Login'); ?>: <?php echo h($user['User']['last_login_time']); ?></li>
		    		</ul>
		    	</div>
		    </div>
			<div class="row">
	    		<div class="col-md-12 margin-top-two border-top user-details">
	    			<strong><?php echo __('Hubby'); ?></strong>
	    			<p><?php echo h($user['User']['hubby']); ?></p>
	    		</div>
	    	</div>

	    	<div class="row margin-top-two border-top">
	    		<div class="col-md-6">
	    			<?php echo $this->Html->link(__('Change Password'), array('action' => 'changepass', AuthComponent::user('id'))); ?>
	    		</div>
	    		<div class="col-md-6">
	    			<?php echo $this->Html->link(__('Update Profile'), array('action' => 'edit', AuthComponent::user('id'))); ?>
	    		</div>
	    	</div>
		</div>

		</div>
	</div>
</div>
