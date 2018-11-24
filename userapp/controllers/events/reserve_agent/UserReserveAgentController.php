<?php

/**
 * 预约成为总代
 */

class UserReserveAgentController extends Controller {

    protected $modelName = 'ReserveAgent';

    public function reserve() {


        if (Request::method() == 'POST') {
            $ReserveAgent = new ReserveAgent;
            //验证码
            if ($this->validateCcodeError($sErrorMsg)) {
                Header("Location: " . $_SERVER['HTTP_REFERER'] . "?msgtype=error&message=" . $sErrorMsg);
                exit;
            }
            //上传文件验证
            if (Input::hasFile('portrait')) {
                $uplodaImgInfo = $this->saveImg();
                if ($uplodaImgInfo['status']) {
                    $ReserveAgent->screenshot = $uplodaImgInfo['PicName'];
                } else {
                    Header("Location: " . $_SERVER['HTTP_REFERER'] . "?msgtype=error&message=" . $uplodaImgInfo['error']->first('portrait'));
                    exit;
                }
            }

            //数据保存
            $ReserveAgent->qq = trim(Input::get('qq'));
            $ReserveAgent->platform = trim(Input::get('platform'));
            $ReserveAgent->sale = Input::get('sale');
            $ReserveAgent->available_date = trim(Input::get('available_date'));
            $ReserveAgent->available_time = Input::get('available_time');
            if ($ReserveAgent->save()) {
                Header("Location: " . $_SERVER['HTTP_REFERER'] . "?msgtype=success&message=预约成功");
                exit;
            } else {
                Header("Location: " . $_SERVER['HTTP_REFERER'] . "?msgtype=error&message=" . $ReserveAgent->getValidationErrorString());
                exit;
            }
        }
    }

    /**
     * 上传图片验证
     */
    public function saveImg() {
        $aInputs = Input::all();
        $sDirPath = SysConfig::readValue('reserve_agent_screenshot') . '/';
        $sFileObj = 'portrait';

        $rules = array(
            $sFileObj => 'required|mimes:jpeg,gif,png|max:1024',
        );
        // 自定义验证消息
        $messages = array(
            $sFileObj . '.required' => '请选择需要上传的图片。',
            $sFileObj . '.mimes' => '请上传 :values 格式的图片。',
            $sFileObj . '.max' => '图片的大小请控制在 1M 以内。',
        );
        $validator = Validator::make([ 'portrait' => $aInputs['portrait']], $rules, $messages);
        if ($validator->passes()) {
            $aData['status'] = true;
            $aData['PicName'] = $this->updateFile($aInputs['portrait'], $sDirPath, $rules, $messages);
        } else {
            $aData['status'] = false;
            $aData['error'] = $validator->messages();
        }

        return $aData;
    }

    /**
     * [validateCaptchaError 验证验证码]
     * @return [Boolean/Response] [验证成功/失败]
     */
    public function validateCcodeError(& $sErrorMsg) {
        $aDatas = ['captcha' => trim(Input::get('vcode'))];
        $aRules = ['captcha' => 'required|captcha'];
        $oValidator = Validator::make($aDatas, $aRules);
        if (!$oValidator->passes()) {
            $sErrorMsg = __('_basic.captcha-error');
            return true;
        }
        return false;
    }

    /*
     * 图片上传方法
     */

    private function updateFile($oFile, $sDirPath, $rules, $messages) {
        file_exists($sDirPath) or mkdir($sDirPath, 0777, 1);
        $sNewFileName = '';
        //检验一下上传的文件是否有效.
        if (is_object($oFile) && $oFile->isValid()) {
            $ext = $oFile->guessClientExtension();
            $sOriginalName = $oFile->getClientOriginalName(); // 客户端文件名，包括客户端拓展名
            $sNewFileName = md5($sOriginalName) . '.' . $ext; // 哈希处理过的文件名，包括真实拓展名
            $portrait = Image::make($oFile->getRealPath());
            $oldImage = Input::get('oldimg');
            File::delete(
                    public_path($oldImage)
            );

            $portrait->save($sDirPath . $sNewFileName);
        }
        return $sNewFileName;
    }

}
