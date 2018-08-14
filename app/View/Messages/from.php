 <div class="container pad-vertical">
	<div class="row">
	    <div class="col-lg-10 col-md-10 mx-auto">
	    	<div class="messages from">
				<h2><?php echo __('Messages Details'); ?></h2>
				<div class="clearfix" id="MessageStatus">
					<?php echo $this->Flash->render(); ?>
				</div>
				<div class="clearfix">
					<?php echo $this->Form->create('Message'); ?>
					<div class="form-group">
						<?php echo $this->Form->input('content', array('label' => 'Message', 'class' => 'form-control')); ?>
						<?php echo $this->Form->input('id'); ?>
					</div>
						<?php echo $this->Form->button(__('Reply Message')); ?>
					<?php echo $this->Form->end(); ?>
				</div>
				
				<div class="panel panel-primary">
	                <div class="panel-heading" id="accordion">
	                    <strong><?php echo __('Conversation with ').ucwords($fromPerson['User']['name']); ?></strong>
	                </div>
		            <div class="panel">
		                <div class="panel-body">
		                    <ul class="chat" id="tbody" <?php echo $this->Paginator->counter(array('format' => __('data-total="{:pages}"'))); ?>>
		                    	<?php foreach ($messages as $message): ?>
		                    	<?php if(AuthComponent::user('id') != $message['Message']['from_id']): ?>
			                        <li class="left clearfix"><span class="chat-img pull-left">
			                        	<?php if ($message['User']['image'] != null ): ?>  
			                        		<?php echo $this->Html->image('uploads/'.$message['User']['image'], array('alt' => 'Profile', 'id' => 'profile', 'class' => 'img-circle')); ?>
			                        	<?php else: ?>
			                            <img src="http://placehold.it/50/55C1E7/fff&amp;text=U" alt="User Avatar" class="img-circle">
			                            <?php endif; ?>
			                        </span>
			                            <div class="chat-body clearfix">
			                                <div class="header">
			                                    <strong class="primary-font"><?php echo $this->Html->link(ucwords(h($message['User']['name'])), array('controller' => 'users', 'action' => 'view', $message['User']['id'])); ?></strong> 
			                                </div>
			                                <div class="clearfix">
			                                    <p class="take-short"><?php echo h($message['Message']['content']); ?></p><br/>
			                                    <small class="pull-right text-muted">
			                                        <span class="glyphicon glyphicon-time"></span>12 mins ago
			                                    </small>
			                                </div>
			                            </div>
			                        </li>
		                        <?php else: ?>
			                        <li class="right clearfix"><span class="chat-img pull-right">
			                        	<?php if ($message['User']['image'] != null ): ?>  
			                        		<?php echo $this->Html->image('uploads/'.$message['User']['image'], array('alt' => 'Profile', 'id' => 'profile', 'class' => 'img-circle')); ?>
			                        	<?php else: ?>
			                            	<img src="http://placehold.it/50/FA6F57/fff&amp;text=ME" alt="User Avatar" class="img-circle">
			                            <?php endif; ?>
			                        </span>
			                            <div class="chat-body clearfix">
			                                <div class="header">
			                                    <strong class="pull-right primary-font"><?php echo ucwords(h($message['User']['name'])); ?></strong>
			                                </div>
			                                <div class="clearfix">
			                                   <p class="take-short"><?php echo h($message['Message']['content']); ?></p><br/>
			                                    <small class="text-muted"><span class="fa fa-time"></span><?php echo $this->My->timeElapsed(h($message['Message']['created'])); ?>
			                                    </small>
			                                </div>
			                                <?php echo $this->Html->link(__('Delete'), array('controller' => 'messages', 'action' => 'delete', $message['Message']['id']), array('class' => 'delete')); ?>
			                            </div>
			                        </li>
		                        <?php endif; ?>		                        
		                        <?php endforeach; ?>		                        
		                    </ul>
		                </div>
		            </div>
	            </div>

				<p>
				<?php
				/*echo $this->Paginator->counter(array(
					'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
				));*/
				?>	</p>
				<div class="paging text-center">
					<a href="/messageboard/messages/from/<?php echo $fromPerson['User']['id']; ?>/page" class="btn" data-search="false" data-current="<?php echo $this->Paginator->counter(array('format' => __('{:page}'))); ?>" id="loadmore">Show more...</a>

				</div>
			</div>
	    </div>
	</div>
</div>
