<?php

/**
 * 智付平台
 *
 */
class PaymentZHIFU extends BasePlatform {

    public $successMsg = 'SUCCESS';
    public $signColumn = 'sign';
    public $accountColumn = 'merchant_code';
    public $orderNoColumn = 'order_no';
    public $paymentOrderNoColumn = 'trade_no';
    public $successColumn = 'trade_status';
    public $successValue = 'SUCCESS';
    public $amountColumn = 'order_amount';
    public $bankNoColumn = 'bank_seq_no';
    public $unSignColumns = [ 'sign_type', 'sign'];
    public $serviceOrderTimeColumn = 'trade_time';
    public $queryResultColumn = 'trade_status';
    //商家私钥，由RSA-S密钥对生成工具生成(merchant private key,generated by the key pair generate tools for RSA-S)
    private $priKey = '-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKfObR77hmCRvE/7
m4P2N1v74nk3y86YHSNDWgo2vf7l7GWvbNq6W62ZLH/4PWojSEs5DaLjks4wwxlM
Kwue1m6+NzhpE6bvFtHuAjtJ2Ct6TGIr4rLNoWHFNMD+UP721f7LURCjikr1qFHb
vB8OrfDNiUSrYvW0nsrbb5NftlFxAgMBAAECgYA86fQ2oPuApqaDKkSjvIcP/vmR
Iy36isFZAaP3vTNvCiusJegP5kJNXCMJOSWiF7iwhb9rd8zcyFqqHjop97jC1/wb
2rBsebHUsp01FwQaWSGFSMz4Q8hmbNipIW2MstXBWLAZVQRvCDEijCpCcRPZfpF3
0dSD/DJQiL+AfUbP2QJBANarwvweYgvkrfKy+5U6PBA9ai14I0oHDJZvw93JJjeM
gSQzCNpMjUTLf2XAsay7mGim3lY/8rQcEXGPLHo1UNMCQQDIHOdaRjiTaWzp68zt
nWzv0SHvoM4iS9zR+lzauodepmXYV+FhJLt3qAACGdSxktj7PurIyl21RIpVlM36
EIorAkBAOVz5fsGIm17rSF76U1Ta6vTUK6grIpbCfyeTN/XGErQkN1yDqvlsxpET
ySWe7vT3Ak1scm9TMT6KwfHlkgPfAkEAivGGsWeQYMoSlVjkMRfdS6Ypqfg9KBME
f8cWMcjRtSZUEKL0Gj8m6y3603qb86/CeLB21HOuHO46HrHzUm2pgQJAJvkPuvku
tFbD/q0CGIMS0/L5VS5cXOIi9KnqvuvZwVRS+3dFlzG8jY7Z8C5gwsBgXw1w4ML2
/r9wOXqjHwCRkA==
-----END PRIVATE KEY-----';
//智付公钥，每个商家对应一个固定的智付公钥，即为商家后台"公钥管理"->"智付公钥"里的内容
//Dinpay public key,every merchant has a unique Dinpay public key,you can find it on our merchant system,Pay Management - > Public Key - >Dinpay Public Key.
    private $pubKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnzm0e+4ZgkbxP+5uD9jdb++J5
N8vOmB0jQ1oKNr3+5exlr2zaulutmSx/+D1qI0hLOQ2i45LOMMMZTCsLntZuvjc4
aROm7xbR7gI7SdgrekxiK+KyzaFhxTTA/lD+9tX+y1EQo4pK9ahR27wfDq3wzYlE
q2L1tJ7K22+TX7ZRcQIDAQAB
-----END PUBLIC KEY-----';
        private $dinpayKey = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDhzVHDYLOgOC1YteqznMD
8bzikjWD46RcINVorn90fc/UMudlPL+ZbxYqIIQ3XI5Jq7Fg9bei/u/5sg+Cu+7bcyXs
mlYHx4GJHbFfo7JpReF7WYbbR+YqHw/SmT2wKF6vklBDwgEZgmyL1YVweqKEfYu
DVlO8sAZ3r/weUyas/dwIDAQAB 
-----END PUBLIC KEY-----';
    public $signNeedColumnsForNotify = [
        'bank_seq_no',
        'extra_return_param',
        'interface_version',
        'merchant_code',
        'notify_id',
        'notify_type',
        'order_amount',
        'order_no',
        'order_time',
        'trade_no',
        'trade_status',
        'trade_time',
    ];

    public function compileSign($oPaymentAccount, $aInputData, $aNeedKeys = []) {
        ksort($aInputData);
//            pr($aInputData);
        $aInputValues = [];
        $sQueryString = '';
        $sForSafe = '';
        foreach ($aInputData as $key => $value) {
            if ($aNeedKeys) {
                if (!in_array($key, $aNeedKeys)) {
                    continue;
                }
            }
            if (!empty($value)) {
                $aInputValues[] = "$key=$value";
            }
        }
        $sQueryString = implode('&', $aInputValues);
        $priKey = openssl_get_privatekey($this->priKey);
        openssl_sign($sQueryString, $sign_info, $priKey, OPENSSL_ALGO_MD5);
        return base64_encode($sign_info);
    }

    public function compileSignReturn($oPaymentAccount, $aInputData, $aNeedKeys = []) {
        $sPostedSign = base64_decode($aInputData[$this->signColumn]);
        foreach ($this->signNeedColumnsForNotify as $sColumn) {
            if (isset($aInputData[$sColumn]) && $aInputData[$sColumn] != "") {
                $aData[$sColumn] = $sColumn . '=' . $aInputData[$sColumn];
            }
        }
        $sMsg = implode('&', $aData);
        Log::info("zhifu:" . $sMsg);
        $dinpayKey = openssl_get_publickey($this->dinpayKey);
        return openssl_verify($sMsg, $sPostedSign, $dinpayKey, OPENSSL_ALGO_MD5);
    }

    public function & compileInputData($oPaymentPlatform, $oPaymentAccount, $oDeposit, $oBank, & $sSafeStr) {
        $data = $aInputData = [
            'bank_code' => $oBank->identifier,
            'input_charset' => 'UTF-8',
            'interface_version' => 'V3.0',
            'merchant_code' => $oPaymentAccount->account,
            'notify_url' => $oPaymentPlatform->notify_url,
            'order_amount' => $oDeposit->amount,
            'order_no' => $oDeposit->order_no,
            'order_time' => date('Y-m-d H:i:s'),
            'product_name' => 'Vitrual' . intval(mt_rand(1, 99999)),
            'return_url' => $oPaymentPlatform->return_url, // 可选，同步回调地址
            'service_type' => 'direct_pay',
//                'client_ip'         => get_client_ip(), // 可选
        ];
        $data['sign'] = $sSafeStr = $this->compileSign($oPaymentAccount, $data);
        $data['sign_type'] = 'RSA-S';

        return $data;
    }

    public function & compileQueryData($oPaymentAccount, $sOrderNo, $sServiceOrderNo) {
        $data = $aInputData = [
            'service_type' => 'single_trade_query',
            'merchant_code' => $oPaymentAccount->account,
            'interface_version' => 'V3.0',
            'order_no' => $sOrderNo,
        ];
        empty($sServiceOrderNo) or $data['trade_no'] = $sServiceOrderNo;
//        pr($oPaymentAccount->toArray());
//        exit;
        $data['sign'] = $this->compileSign($oPaymentAccount, $data);
        $data['sign_type'] = 'MD5';
//        pr($data);
        return $data;
    }

    public function compileQueryUrl($data) {
        $aQueryStr = [];
        $aNeed = [
            'service_type',
            'merchant_code',
            'interface_version',
            'sign_type',
            'sign',
            'order_no'
        ];
//        $aQueryStr[] = $key . '=' . $value;
        foreach ($aNeed as $key) {
            $aQueryStr[] = $key . '=' . $data[$key];
        }
        return $oPaymentPlatform->query_url . '?' . implode('&', $aQueryStr);
    }

    /**
     * Query from Payment Platform
     * @param PaymentPlatform $oPaymentPlatform
     * @param string $sOrderNo
     * @param string $sServiceOrderNo
     * @param array & $aResonses
     * @return integer | boolean
     *  1: Success
     *  -1: Query Failed
     *  -2: Parse Error
     *  -3: Sign Error
     *  -4: Unpay
     *  -5: Amount Error
     */
    public function queryFromPlatform($oPaymentPlatform, $oPaymentAccount, $sOrderNo, $sServiceOrderNo = null, & $aResonses) {
        $data = $this->compileQueryData($oPaymentAccount, $sOrderNo, $sServiceOrderNo);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $oPaymentPlatform->getQueryUrl($oPaymentAccount));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //将数据传给变量
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //取消身份验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch); //接收返回信息
        file_put_contents('/tmp/zf_' . $sOrderNo, $response);
        if (curl_errno($ch)) {//出错则显示错误信息
            print curl_error($ch);
        }

        curl_close($ch); //关闭curl链接
//        var_dump($response);
        if ($response === '') {     // query failed
            return self::PAY_QUERY_FAILED;
        }
        $resParser = xml_parser_create();
        if (!xml_parse_into_struct($resParser, $response, $values, $index)) {   // parse error
            return self::PAY_QUERY_PARSE_ERROR;
        }
//            pr($values);
//            pr($index);
        $aResonses = [];
        foreach ($values as $aInfo) {
            if ($aInfo['type'] != 'complete') {
                continue;
            }
            $aResonses[strtolower($aInfo['tag'])] = $aInfo['value'];
        }
//        pr($aResonses);
//        exit;
        if ($aResonses['is_success'] == 'F') {      // NO ORDER
            return self::PAY_NO_ORDER;
        }
        $sDinpaySign = $aResonses['sign'];
        $sDinpaySignType = $aResonses['sign_type'];
        unset($aResonses['sign'], $aResonses['sign_type']);
//        pr($aResonses);
        $aNeed = [
            'merchant_code', 'order_no', 'order_time', 'order_amount', 'trade_no', 'trade_time', 'trade_status'
        ];
        $sign = $this->compileSign($oPaymentPlatform, $aResonses, $aNeed);
//        pr($sign);
//        pr($sDinpaySign);
//        exit;
//            $sign         = md5($sQueryString . '&key=' . $sMerchantKey);
//        pr($sign);
        if ($sign != $sDinpaySign) {
            return self::PAY_SIGN_ERROR;
        }

        switch ($aResonses['trade_status']) {
            case 'UNPAY':
                return self::PAY_UNPAY;
            case 'SUCCESS':
//                if ($aResonses['order_amount'] != $oDeposit->amount) {
//                    return self::PAY_AMOUNT_ERROR;
//                }
                return self::PAY_SUCCESS;
        }
//        return $aResonses['is_success'] == 'T' && $aResonses['trade_status'] == 'SUCCESS';
//        exit;
    }

    public static function & compileCallBackData($data, $ip) {
        $aData = [
            'order_no' => $data['order_no'],
            'service_order_no' => $data['trade_no'],
            'merchant_code' => $data['merchant_code'],
            'amount' => $data['order_amount'],
            'ip' => $ip,
            'status' => DepositCallback::STATUS_CALLED,
            'post_data' => var_export($data, true),
            'callback_time' => time(),
            'callback_at' => date('Y-m-d H:i:s'),
            'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
            'http_user_agent' => array_get($_SERVER, 'HTTP_USER_AGENT'),
        ];
        return $aData;
    }

    public static function & getServiceInfoFromQueryResult(& $aResponses) {
        return $aResponses;
    }

}