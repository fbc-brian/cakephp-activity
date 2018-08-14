<?php
$data = array();
$data['msg'] = '';
$data['total'] = count($messages);
foreach ($messages as $message){
	$data['msg'] .= "
	<tr class='convo-".h($message['Message']['con_id'])."''>
		<td>
			<div class='user-image inbox'>";

				if (AuthComponent::user('id') == $message['Message']['from_id']):
					if ($message['Receiver']['image'] != null) {
						$data['msg'] .= $this->Html->image('uploads/' . $message['Receiver']['image'], array('alt' => 'Profile', 'id' => 'profile'));
					} else {
						$data['msg'] .= '<img src="/messageboard/img/avatar.jpg" alt="' .h($message['User']['name']). '" id="profile">';
					}
				else:
					if ($message['User']['image'] != null) {
						$data['msg'] .= $this->Html->image('uploads/' . $message['User']['image'], array('alt' => 'Profile', 'id' => 'profile'));
					}
					else {
						$data['msg'] .= '<img src="/messageboard/img/avatar.jpg" alt="' .h($message['User']['name']). '" id="profile">';
					}
				endif;
						
$data['msg'] .= "</div>
		</td>
		<td>";
		if (AuthComponent::user('id') == $message['Message']['from_id']):
			$data['msg'] .= "<strong>" .$this->Html->link(h($message['Receiver']['name']), array('controller' => 'users', 'action' => 'view', $message['Receiver']['id'])). "</strong>";
		else:
			$data['msg'] .= "<strong>" .$this->Html->link(h($message['User']['name']), array('controller' => 'user', 'action' => 'view', $message['User']['id'])). "</strong>";
		endif;
$data['msg'] .= "</td>
		<td>";
			if (AuthComponent::user('id') != $message['Message']['from_id']): 
				$shorttext = $this->My->shortText(h($message['Message']['content']), 60);
				$data['msg'] .= $this->Html->link($shorttext, array('action' => 'from', $message['Message']['from_id']));
			else:
				$shorttext = $this->My->shortText(h($message['Message']['content']), 60);
				$data['msg'] .= $this->Html->link($shorttext, array('action' => 'from', $message['Message']['to_id']));
			endif;
$data['msg'] .= "</td>
		<td>" .$this->My->timeElapsed(h($message['Message']['created'])). "</td>
		<td>" .$this->Html->link('Delete', array('action' => 'delcon', $message['Message']['con_id']), array('class' => 'delete_convo'))."</td>";
$data['msg'] .= "</tr>";

} 

$data['status'] = true;

echo json_encode($data);