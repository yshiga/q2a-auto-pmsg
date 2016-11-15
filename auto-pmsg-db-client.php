<?php
if (!defined('QA_VERSION')) {
    header('Location: ../../');
    exit;
}

require_once QA_INCLUDE_DIR.'db/users.php';
require_once QA_INCLUDE_DIR.'db/selects.php';

class q2a_auto_pmsg_db_client
{
    public static function get_users_day_after_registration($day = 3)
    {
        $sql = "SELECT userid, handle, email";
        $sql .= " FROM ^users";
        $sql .= " WHERE (flags & #) = 0";
        $sql .= " AND DATE_FORMAT(created, '%Y-%m-%d') LIKE DATE_FORMAT((NOW() - INTERVAL # DAY), '%Y-%m-%d')";
        // ブロックユーザーを含めない
        $flag = QA_USER_FLAGS_USER_BLOCKED;
        return qa_db_read_all_assoc(qa_db_query_sub($sql, $flag, $day));
    }
    
    public static function is_user_posted($userid)
    {
        $sql = "SELECT count(*)";
        $sql .= " FROM ^posts";
        $sql .= " WHERE userid = #";
        $result = qa_db_read_one_value(qa_db_query_sub($sql, $userid));
        if (isset($result) && $result > 0) {
            return true;
        } else {
            return false;
        }
    }
}
