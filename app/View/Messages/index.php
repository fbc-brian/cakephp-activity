 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-10 col-md-10 mx-auto">

		<div class="messages index">
			<h2><?php echo __('Messages List'); ?></h2>
			<div class="clearfix pad-vertical">
				<?php echo $this->HTML->link(__('New Message'), array('action' => 'add'), array('class' => 'btn btn-primary', 'style' => 'float:right')); ?>
			</div>
			<div class="clearfix notify">
			<?php echo $this->Flash->render(); ?>
			</div>	
			<?php echo $this->Form->create('Message', array(
						'url'   => array(
			               'controller' => 'messages',
			               'action' => 'search'
			           	), 
						'id' => 'search')); 
			?>
			<div class="input-group mb-3">
			  <?php echo $this->Form->input('search', array('class' => 'form-control', 'placeholder' => 'Search', 'label' => false)); ?>
			  <div class="input-group-append">
			    <?php echo $this->Form->button('Submit', array('class' => 'btn btn-success')); ?> 
			   </div>
			</div>		
			<?php echo $this->Form->end(); ?>

			<table cellpadding="0" cellspacing="0" class="table table-bordred table-striped">
				<thead>
				<tr>
						<th colspan="5"><?php echo __('Messages'); ?></th>
				</tr>
				</thead>
				<tbody id="tbody" <?php echo $this->Paginator->counter(array('format' => __('data-total="{:pages}'))); ?>">
				<?php 
				$ctr = 0;
				foreach ($messages as $message): 
				?>
				<tr class="convo-<?php echo h($message['Message']['con_id']); ?>">
					<td>
						<div class="user-image inbox">
							<?php 
							if (AuthComponent::user('id') == $message['Message']['from_id']):
								if ($message['Receiver']['image'] != null):
									echo $this->Html->image('uploads/' . $message['Receiver']['image'], array('alt' => 'Profile', 'id' => 'profile'));
								else:
									echo '<img src="/messageboard/img/avatar.jpg" alt="' .h($message['User']['name']). '" id="profile">';
								endif;
							else:
								if ($message['User']['image'] != null) {
									echo $this->Html->image('uploads/' . $message['User']['image'], array('alt' => 'Profile', 'id' => 'profile'));
								}
								else {
									echo '<img src="/messageboard/img/avatar.jpg" alt="' .h($message['User']['name']). '" id="profile">';
								}
							endif;
							?>
							
						</div>
					</td>
					<td>
						<?php if (AuthComponent::user('id') == $message['Message']['from_id']): ?>
						<strong><?php echo $this->Html->link(h($message['Receiver']['name']), array('controller' => 'users', 'action' => 'view', $message['Receiver']['id'])); ?></strong>
						<?php else: ?>
						<strong>
							<?php echo $this->Html->link(h($message['User']['name']), array('controller' => 'user', 'action' => 'view', $message['User']['id'])); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if (AuthComponent::user('id') != $message['Message']['from_id']): 
								$shorttext = $this->My->shortText(h($message['Message']['content']), 60);
								echo $this->Html->link($shorttext, array('action' => 'from', $message['Message']['from_id']));
							  else: 
								$shorttext = $this->My->shortText(h($message['Message']['content']), 60);
								echo $this->Html->link($shorttext, array('action' => 'from', $message['Message']['to_id'])); 
							  endif; ?>
					 </td>
					<td><?php echo $this->My->timeElapsed(h($message['Message']['created'])); ?>&nbsp;</td>
					<td><?php echo $this->Html->link('Delete', array('action' => 'delcon', $message['Message']['con_id']), array('class' => 'delete_convo'));?></td>
					
				</tr>
			<?php endforeach; ?>
				</tbody>
			</table>


			<div class="paging text-center">
				<a href="/messageboard/messages/index/page" class="btn" data-search="false" data-current="<?php echo $this->Paginator->counter(array('format' => __('{:page}'))); ?>" id="loadmore">Show more...</a>
			</div>
		</div>

		</div>
	</div>
</div>
