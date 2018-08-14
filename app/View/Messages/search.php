<?php
$data = array();
$data['msg'] = '';
$data['total'] = $this;
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
			$data['msg'] .= "<strong>" .$message['Receiver']['name']. "</strong>";
		else:
			$data['msg'] .= "<strong>" .$message['User']['name']. "</strong>";
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
		<td>" .$this->Html->link('Delete', array('action' => 'delete', $message['Message']['id']), array('class' => 'delete'))."</td>";
$data['msg'] .= "</tr>";

} 

$data['status'] = true;
$data['pages'] = $this->Paginator->params()['pageCount'];

echo json_encode($data);