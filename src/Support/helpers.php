<?php

if (! function_exists('last_str_replace')) {
	function last_str_replace($search, $replace, $subject){
	    $pos = strrpos($subject, $search);
	    if($pos !== false){
	        $subject = substr_replace($subject, $replace, $pos, strlen($search));
	    }
	    return $subject;
	}
}

if (!function_exists('alert_array')) {
    function alert_array($array) {
        return ['alert' => $array];
    }
}

if (!function_exists('alert_success')) {
    function alert_success($message) {
        return alert_array(['type' => 'success', 'message' => $message]);
    }
}

if (!function_exists('alert_error')) {
    function alert_error($message) {
        return alert_array(['type' => 'danger', 'message' => $message]);
    }
}

if (!function_exists('alert_warning')) {
    function alert_warning($message) {
        return alert_array(['type' => 'warning', 'message' => $message]);
    }
}

if (!function_exists('alert_info')) {
    function alert_info($message) {
        return alert_array(['type' => 'info', 'message' => $message]);
    }
}

if (! function_exists('notification_array')) {
	function notification_array($type, $title, $message){
		return [
			'notification' => [
				'title' => $title,
				'message' => $message
			]
		];
	}
}

if (! function_exists('notification_success')) {
	function notification_success($title, $message){
		return notification_array('succes', $title, $message);
	}
}

if (! function_exists('notification_error')) {
	function notification_error($title, $message){
		return notification_array('error', $title, $message);
	}
}

if (! function_exists('notification_warning')) {
	function notification_warning($title, $message){
		return notification_array('warning', $title, $message);
	}
}

if (! function_exists('notification_info')) {
	function notification_info($title, $message){
		return notification_array('info', $title, $message);
	}
}

if (! function_exists('pluck_table')) {
	function pluck_table($table, $selectRaw = 'name, id', $where = [], $pluckValue = 'name', $pluckId = 'id'){
		$result = \DB::table($table);
		$result = $result->selectRaw($selectRaw);
		foreach ($where as $conditions) {
			if (count($conditions) == 2) {
				$result = $result->where($conditions[0], $conditions[1]);
			}elseif (count($conditions) == 3) {
				$result = $result->where($conditions[0], $conditions[1], $conditions[2]);
			}elseif (is_string($conditions)) {
				$result = $result->whereRaw($conditions);
			}
		}
		return $result->pluck($pluckValue, $pluckId)->all();
	}
}

if (! function_exists('json_table')) {
	function json_table($table, $selectRaw = 'name, id', $where = []){
		$result = \DB::table($table);
		$result = $result->selectRaw($selectRaw);
		foreach ($where as $conditions) {
			if (count($conditions) == 2) {
				$result = $result->where($conditions[0], $conditions[1]);
			}elseif (count($conditions) == 3) {
				$result = $result->where($conditions[0], $conditions[1], $conditions[2]);
			}elseif (is_string($conditions)) {
				$result = $result->whereRaw($conditions);
			}
		}
		return $result->get()->toJson();
	}
}