<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\SystemLog;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function insertSystemLog($action_type, $action_description, $perform_by, $target_id, $target_category, $result){
        $system_log_array = array(
            'action_type' => $action_type,
            'action_description' => $action_description,
            'perform_by' => $perform_by,
            'ip_address_of_initiator' => $_SERVER["REMOTE_ADDR"],
            'target_id' => $target_id,
            'target_category' => $target_category,
            'result' => $result,
        );
        SystemLog::create($system_log_array);
    }
}