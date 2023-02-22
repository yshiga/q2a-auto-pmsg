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

    $user = array('userid' => '3240', 'handle' => 'devuser');
    
    $fromuserid = 1;
    $fromhandle = qa_userid_to_handle($fromuserid);

    $message = "ミツバチのQ&Aにご登録いただき、誠にありがとうございます。\n\n ミツバチのQ&Aには、ユーザー同士でメッセージをやり取りする機能があります。\n\n お互いにメールアドレスを公開することなく、メッセージが送れます。ぜひ交流にお役立てください。\n\n なお、メッセージを送信できるのは、お互いにフォローしているユーザーだけです。\n\n";
    
    if (!q2a_auto_pmsg_db_client::is_user_posted($user['userid'])) {
        $message .= "なお、質問の投稿は、次のページから行うことができます。困ったことがあればお気軽に質問してください。\n\nhttps://38qa.net/ask \n\n";
    } 
    $message .= "今後ともミツバチのQ&Aをよろしくお願いいたします。";
    
    $messageid = qa_db_message_create($fromuserid, $user['userid'], $message, '', false);

    qa_report_event('u_message', $fromuserid, $fromhandle, null, array(
        'userid' => $user['userid'],
        'handle' => $user['handle'],
        'messageid' => $messageid,
        'message' => $message,
    ));
}

