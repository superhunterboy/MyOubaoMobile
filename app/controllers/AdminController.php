<?php

class AdminController extends AdminBaseController
{
    /**
     * 后台首页
     * @return Response
     */
    public function getIndex()
    {
        $sysInfo = [
            'php_version' => PHP_VERSION,
            'os'          => PHP_OS,
            'web_server'  => $_SERVER['SERVER_SOFTWARE'],
            'user_agent'  => $_SERVER['HTTP_USER_AGENT'],
            'app_version' => SysConfig::readValue('sys_version')
        ];
        return View::make('index')->with(compact('sysInfo'));
    }

    public function getFrameset()
    {
        $title = $this->generateTitle();
        return View::make('l.frameset')->with(compact('title'));
    }
    public function gethome()
    {
        $title = $this->generateTitle();
        $menus = $this->getUserMenus();
        return View::make('l.home')->with(compact('title','menus'));
    }

    protected function generateTitle()
    {
        $appTitle = SysConfig::readValue('app_title');
        $appName = SysConfig::readValue('app_name');
        $appTitle or $appTitle = $appName;
        $appTitle = __($appTitle);
        $appVersion = SysConfig::readValue('sys_version');
        return $appTitle . ' ' . $appVersion;
    }

     public function getUserMenus() {
        $aColumns = ['id', 'functionality_id', 'title', 'controller', 'action', 'params', 'new_window', 'sequence'];
        $rightIds = $this->getUserRights(3, true);
        $aMainMenus = AdminMenu::whereNull('parent_id')->where('disabled', '=', 0)->orderBy('sequence', 'ASC')->get($aColumns);
        $aMenuMenus = AdminMenu::getMenus();
//        pr($aMenuMenus);
//        exit;
        $menus = [];
        foreach ($aMainMenus as $oMainMenu) {
            $menus[$oMainMenu->id] = $oMainMenu->getAttributes();
            $menus[$oMainMenu->id]['children'] = [];
            $aSubMenus = AdminMenu::where('parent_id', '=', $oMainMenu->id)->where('disabled', '=', 0)->whereIn('functionality_id', $rightIds)->orderBy('sequence', 'ASC')->get($aColumns);
            foreach ($aSubMenus as $oMenu) {
                $route_name = $oMenu->controller . '@' . $oMenu->action;
                if ($route_name != '_main@_main')
                    $oMenu->route_name = $this->_getRouterName($route_name);
                $menus[$oMainMenu->id]['children'][] = $oMenu->getAttributes();
            }
        }
        unset($aSubMenus, $aMainMenus, $oMainMenu, $oMenu, $rightIds, $aColumns);

        return $menus;
    }


}
