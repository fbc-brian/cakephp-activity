<?php
App::uses('HtmlHelper', 'View/Helper');

class MyHelper extends HtmlHelper {
    public function printR($var) {
    	echo '<pre>';
    	print_r($var);
    	echo '</pre>';
    } 

     public function shortText($text, $max_length = 140, $cut_off = '...', $keep_word = false) {
	    if (strlen($text) <= $max_length) {
	        return $text;
	    }

	    if (strlen($text) > $max_length) {
	        if ($keep_word) {
	            $text = substr($text, 0, $max_length + 1);

	            if ($last_space = strrpos($text, ' ')) {
	                $text = substr($text, 0, $last_space);
	                $text = rtrim($text);
	                $text .=  $cut_off;
	            }
	        } else {
	            $text = substr($text, 0, $max_length);
	            $text = rtrim($text);
	            $text .=  $cut_off;
	        }
	    }

	    return $text;
	}
	public function timeElapsed($datetime, $full = false) {
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	public function convoWith($id){
		App::import('Controller', 'Users');
		$Users = new UsersController;
		return $Users->getUserDetails($id);
	}
}