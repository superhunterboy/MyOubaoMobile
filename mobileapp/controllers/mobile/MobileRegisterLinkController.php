<?php

class MobileRegisterLinkController extends UserRegisterLinkController {

    protected $resourceView = 'registerlink';
    protected $sRoutePre = 'mobile-links';
    protected $isMobile = true;
    
}
