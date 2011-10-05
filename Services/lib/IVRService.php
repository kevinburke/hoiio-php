<?php

/**
* IVRService class provides acccess to IVR-related Hoiio API.
* Currently, includes:
*  - Answer
*  - Dial
*  - Play
*  - Gather
*  - Transfer
*  - Hangup
*/
class IVRService extends HTTPService {
    /* endpoints for IVR APIs */
    const I_DIAL        = 'https://secure.hoiio.com/open/ivr/start/dial';
    const I_PLAY        = 'https://secure.hoiio.com/open/ivr/middle/play';
    const I_GATHER      = 'https://secure.hoiio.com/open/ivr/middle/gather';
    const I_TRANSFER    = 'https://secure.hoiio.com/open/ivr/end/transfer';
    const I_HANGUP      = 'https://secure.hoiio.com/open/ivr/end/hangup';

    public static function dial($appID, $accessToken, $to, $notifyURL, $msg = '', $callerID = '', $tag = '') {
        // prepare HTTP POST variables
        $fields = array(    'app_id' => urlencode($appID),
                            'access_token' => urlencode($accessToken),
                            'dest' => urlencode($to),
                            'notify_url' => urlencode($notifyURL)
        );

        if($msg != '')
            $fields['msg'] = urlencode($msg);

        if($callerID != '')
            $fields['callerID'] = urlencode($callerID);

        if($tag != '')
            $fields['tag'] = urlencode($tag);

        // do the actual post to Hoiio servers
        $result = self::doHoiioPost(self::I_DIAL, $fields);

        return array('session' => $result->{'session'}, 'txnRef' => $result->{'txn_ref'});
    }

    public static function play($appID, $accessToken, $session, $notifyURL, $msg = '', $tag = '') {
        // prepare HTTP POST variables
        $fields = array(    'app_id' => urlencode($appID),
                            'access_token' => urlencode($accessToken),
                            'session' => urlencode($session),
                            'notify_url' => urlencode($notifyURL)
        );

        if($msg != '')
            $fields['msg'] = urlencode($msg);

        if($tag != '')
            $fields['tag'] = urlencode($tag);

        // do the actual post to Hoiio servers
        $result = self::doHoiioPost(self::I_PLAY, $fields);

        return true;
    }

    public static function gather($appID, $accessToken, $session, $notifyURL, $msg = '',
                                    $maxDigits = 0, $timeout = 15, $attempts = 1, $tag = '') {
        // prepare HTTP POST variables
        $fields = array(    'app_id' => urlencode($appID),
                            'access_token' => urlencode($accessToken),
                            'session' => urlencode($session),
                            'notify_url' => urlencode($notifyURL),
                            'max_digits' => urlencode(strval($maxDigits)),
                            'timeout' => urlencode(strval($timeout)),
                            'attempts' => urlencode(strval($attempts))
        );

        if($msg != '')
            $fields['msg'] = urlencode($msg);

        if($tag != '')
            $fields['tag'] = urlencode($tag);

        // do the actual post to Hoiio servers
        $result = self::doHoiioPost(self::I_GATHER, $fields);

        return true;
    }

    public static function transfer($appID, $accessToken, $session, $to, $notifyURL, $msg = '', $callerID = '', $tag = '') {
        // prepare HTTP POST variables
        $fields = array(    'app_id' => urlencode($appID),
                            'access_token' => urlencode($accessToken),
                            'session' => urlencode($session),
                            'dest' => urlencode($to),
                            'notify_url' => urlencode($notifyURL)
        );

        if($msg != '')
            $fields['msg'] = urlencode($msg);

        if($callerID != '')
            $fields['callerID'] = urlencode($callerID);

        if($tag != '')
            $fields['tag'] = urlencode($tag);

        // do the actual post to Hoiio servers
        $result = self::doHoiioPost(self::I_TRANSFER, $fields);

        return true;
    }

    public static function hangup($appID, $accessToken, $session, $notifyURL, $msg = '', $tag = '') {
        // prepare HTTP POST variables
        $fields = array(    'app_id' => urlencode($appID),
                            'access_token' => urlencode($accessToken),
                            'session' => urlencode($session),
                            'notify_url' => urlencode($notifyURL)
        );

        if($msg != '')
            $fields['msg'] = urlencode($msg);

        if($tag != '')
            $fields['tag'] = urlencode($tag);

        // do the actual post to Hoiio servers
        $result = self::doHoiioPost(self::I_HANGUP, $fields);

        return true;
    }

    public static function parseIVRNotify($post_var) {
        $dialStatus = array_key_exists('dial_status', $post_var) ? $post_var['dial_status'] : '';
        $digits = array_key_exists('digits', $post_var) ? $post_var['digits'] : '';
        $transferStatus = array_key_exists('transfer_status', $post_var) ? $post_var['transfer_status'] : '';
        $from = array_key_exists('from', $post_var) ? $post_var['from'] : '';
        $to = array_key_exists('to', $post_var) ? $post_var['to'] : '';

        $date = array_key_exists('date', $post_var) ? $post_var['date'] : '';
        $currency = array_key_exists('currency', $post_var) ? $post_var['currency'] : '';
        $rate = array_key_exists('rate', $post_var) ? floatval($post_var['rate']) : '';
        $duration = array_key_exists('duration', $post_var) ? floatval($post_var['duration']) : '';
        $debit = array_key_exists('debit', $post_var) ? floatval($post_var['debit']) : '';

        $tag = array_key_exists('tag', $post_var) ? $post_var['tag'] : '';

        return new IVRNotification(    $post_var['call_state'],
                                       $post_var['session'],
                                       $post_var['txn_ref'],
                                       $dialStatus,
                                       $digits,
                                       $transferStatus,
                                       $from,
                                       $to,
                                       $date,
                                       $currency,
                                       $rate,
                                       $duration,
                                       $debit,
                                       $tag);
    }
}