<?php

if (!defined('QA_VERSION')) {
    require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
}

require_once QA_PLUGIN_DIR.'q2a-auto-pmsg/auto-pmsg-db-client.php';
require_once QA_INCLUDE_DIR.'db/messages.php';
require_once QA_INCLUDE_DIR.'app/emails.php';

error_log('start send direct message'.PHP_EOL);

$users = q2a_auto_pmsg_db_client::get_users_day_after_registration();


foreach ($users as $user) {
    
    $fromhandle = qa_opt('qa_auto_pmsg_from_handle');
    if (empty($fromhandle)) {
        $fromhandle = qa_lang_html('qa_apmsg_lang/default_handle');
    }
    $fromuserid = qa_handle_to_userid($fromhandle);
    
    if (q2a_auto_pmsg_db_client::is_user_posted($user['userid'])) {
        $message = qa_opt('qa_auto_pmsg_message_for_posted');
    } else {
        $message = qa_opt('qa_auto_pmsg_message_for_no_posted');
    }
    
    if (qa_opt('show_message_history'))
        $messageid = qa_db_message_create($fromuserid, $user['userid'], $message, '', false);
    else
        $messageid = null;

    qa_report_event('u_message', $fromuserid, $fromhandle, null, array(
        'userid' => $user['userid'],
        'handle' => $user['handle'],
        'messageid' => $messageid,
        'message' => $message,
    ));
}

error_log('end send direct message'.PHP_EOL);
