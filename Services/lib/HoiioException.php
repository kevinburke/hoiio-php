<?php

class HoiioException extends Exception {
    const SUCCESS                       = 'success_ok';
    
    /* Generic error codes */
    const INVALID_HTTP_METHOD           = 'error_invalid_http_method';
    const MISSING_PARAMS                = 'error_param_missing';
    const MALFORMED_PARAMS              = 'error_malformed_params';
    const INVALID_ACCESS_TOKEN          = 'error_invalid_access_token';
    const INVALID_APP_ID                = 'error_invalid_app_id';
    const TAG_INVALID_LENGTH            = 'error_tag_invalid_length';
    const INVALID_NOTIFY_URL            = 'error_invalid_notify_url';
    const UNABLE_TO_RESOLVE_NOTIFY_URL  = 'error_unable_to_resolve_notify_url';
    const INSUFFICIENT_CREDIT           = 'error_insufficient_credit';
    const RATE_LIMIT_EXCEEDED           = 'error_rate_limit_exceeded';
    const INTERNAL_SERVER_ERROR         = 'error_internal_server_error';
    const INVALID_TXN_REF               = 'error_invalid_txn_ref';

    /* Call error codes */
    const DEST1_INVALID                 = 'error_dest1_invalid';
    const DEST2_INVALID                 = 'error_dest2_invalid';
    const SAME_DEST1_DEST2              = 'error_same_dest1_dest2';
    const CONCURRENT_CALL_LIMIT_REACHED = 'error_concurrent_call_limit_reached';
    
    /* SMS error codes */
    const DEST_INVALID                  = 'error_dest_invalid';
    const DEST_NOT_SUPPORTED            = 'error_dest_not_supported';
    const MSG_EMPTY                     = 'error_msg_empty';
    const MSG_TOO_BIG                   = 'error_msg_too_big';
    const SMS_REBRAND_NOT_ENABLED       = 'error_sms_rebrand_not_enabled';
    const INVALID_SENDER_NAME           = 'error_invalid_sender_name';

    /* Call and SMS history error codes */
    const FROM_INVALID                  = 'error_from_invalid';
    const TO_INVALID                    = 'error_to_invalid';
    const TO_BEFORE_FROM                = 'error_to_before_from';
    const PAGE_INVALID                  = 'error_page_invalid';

    /* IVR error codes */
    const MSG_INVALID_LENGTH            = 'error_msg_invalid_length';
    const SPEECH_TO_TEXT_FAILED         = 'error_speech_to_text_failed';
    const SESSION_ACCESS_DENIED         = 'error_session_access_denied';
    const CALLER_ID_INVALID             = 'error_caller_id_invalid';
    const INVALID_MAX_DIGITS            = 'error_invalid_max_digits';
    const INVALID_TIMEOUT               = 'error_invalid_timeout';
    const INVALID_ATTEMPTS              = 'error_invalid_attempts';
    
    protected $status = '';
    
    public function __construct($status) {
        if(strpos($status, '_param_missing') !== false)
            $this->status = self::MISSING_PARAMS;
        else
            $this->status = $status;
        
        parent::__construct($status);
    }
    
    public function getStatus() {
        return $this->status;
    }   
}