 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-6 col-md-10 mx-auto">

		<div class="messages form">
		<h1>New Message</h1>
		<?php echo $this->Flash->render(); ?>
		<?php echo $this->Form->create('Message'); ?>
		<div class="form-group">
			<?php echo $this->Form->input('to_id', array('label' => 'Recipient', 'class' => 'form-control js-select', 'options' => $users, 'empty' => '')); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->input('content', array('label' => 'Message', 'class' => 'form-control')); ?>
		</div>
		<div class="form-group">
		<?php echo $this->Form->end(__('Submit')); ?>
		</div>

		</div>
	</div>
</div>