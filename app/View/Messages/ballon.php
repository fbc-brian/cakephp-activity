<?php 
$data = array();
$data['msg'] = '';
foreach ($messages as $message):
	if(AuthComponent::user('id') != $message['Message']['from_id']):
		$data['msg'] .= '
        <li class="left clearfix"><span class="chat-img pull-left">';
        	if ($message['User']['image'] != null ) { 
        		$data['msg'] .= $this->Html->image('uploads/'.$message['User']['image'], array('alt' => 'Profile', 'id' => 'profile', 'class' => 'img-circle'));
        	} else {
            	$data['msg'] .= '<img src="http://placehold.it/50/55C1E7/fff&amp;text=U" alt="User Avatar" class="img-circle">';
        	}
    $data['msg'] .= "
		</span>
            <div class=\"chat-body clearfix\">
                <div class=\"header\">
                    <strong class=\"primary-font\">" .$this->Html->link(ucwords(h($message['User']['name'])), array('controller' => 'users', 'action' => 'view', $message['User']['id'])). "</strong> 
                </div>
                <div class=\"clearfix\">
                    <p class=\"take-short\">".h($message['Message']['content'])." </p><br/>
                    <small class=\"pull-right text-muted\">
                        <span class=\"glyphicon glyphicon-time\"></span>12 mins ago
                    </small>
                </div>
            </div>
        </li>";
    else: 
    $data['msg'] .= '<li class="right clearfix"><span class="chat-img pull-right">';
        	if ($message['User']['image'] != null ) { 
        		$data['msg'] .= $this->Html->image('uploads/'.$message['User']['image'], array('alt' => 'Profile', 'id' => 'profile', 'class' => 'img-circle'));
        	} else {
            	$data['msg'] .= '<img src="http://placehold.it/50/FA6F57/fff&amp;text=ME" alt="User Avatar" class="img-circle">';
        	}
    $data['msg'] .= '
		</span>
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="pull-right primary-font">' .ucwords(h($message['User']['name'])). '</strong>
                </div>
                <div class="clearfix">
                    <p class="take-short">' .h($message['Message']['content']). '</p><br/>
                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>' .$this->My->timeElapsed(h($message['Message']['created'])). '
                    </small>
                </div>
                '. $this->Html->link(__('Delete'), array('controller' => 'messages', 'action' => 'delete', $message['Message']['id']), array('class' => 'delete')) . '
            </div>
        </li>';
    endif; 	                        
endforeach;

$data['status'] = true;
$data['total'] = count($messages);

echo json_encode($data);