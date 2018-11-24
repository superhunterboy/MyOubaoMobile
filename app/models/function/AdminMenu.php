<?php

class AdminMenu extends BaseModel {
    static $cacheLevel = self::CACHE_LEVEL_FIRST;
    protected $table = 'admin_menus';

    /**
     * 资源名称
     * @var string
     */
    public static $resourceName = 'AdminMenu';

    /**
     * If Tree Model
     * @var Bool
     */
    public static $treeable = true;
    public static $sequencable = true;
    /**
     * the columns for list page
     * @var array
     */
    public static $columnForList = [
        'title',
        'parent',
        'functionality_id',
        'controller',
        'action',
        'description',
        'params',
        'new_window',
        'disabled',
        'sequence',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */

    public static $htmlSelectColumns = [
        'parent_id' => 'aMenuTree',
        'functionality_id' => 'aFunctionalities',
    ];

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;

    protected $fillable = [
        'title',
        'parent_id',
        'parent',
        'functionality_id',
        'controller',
        'action',
        'description',
        'params',
        'new_window',
        'disabled',
        'sequence',
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    public static $rules = [
        'title'     => 'between:1,30',
        'params'  => 'between:1,100',
        'disabled'  => 'in:0,1',
        'new_window'   => 'in:0,1',
        'sequence'  => 'numeric'
    ];

    /**
     * order by config
     * @var array
     */
    public $orderColumns = [
        'sequence' => 'asc'
    ];

    /**
     * The array of custom error messages.
     *
     * @var array
     */
    public static $customMessages = [

    ];

    public function functionalities()
    {
        return $this->hasMany('FunctionalityRelation');
    }

    public function admin_roles()
    {
        return $this->belongsToMany('AdminRole')->withTimestamps();
    }

    public function admin_menus()
    {
        return $this->hasMany('AdminMenu', 'functionality_id')->withTimestamps();
    }

    /**
     * Explode the rules into an array of rules.
     *
     * @param  string|array  $rules
     * @return array
     */
    protected function explodeRules($rules)
    {
        foreach ($rules as $key => &$rule)
        {
            $rule = (is_string($rule)) ? explode('|', $rule) : $rule;
        }

        return $rules;
    }

    /**
     * run before save()
     */
    protected function beforeValidate(){
        if ($this->functionality_id){
            if (!$oFunctionality = Functionality::find($this->functionality_id)){
                return false;
            }
            $this->controller = $oFunctionality->controller;
            $this->action = $oFunctionality->action;
            $this->title or $this->title = $oFunctionality->title;
        }

        return true;
    }
    
    public static function compileMenuCacheKey(){
        return self::getCachePrefix(true) . 'menus';
    }
    
    public static function & getMenus(){
        if (static::$cacheLevel != self::CACHE_LEVEL_NONE){
            $sCacheKey = self::compileMenuCacheKey();
            Cache::setDefaultDriver(static::$cacheDrivers[static::$cacheLevel]);
            if ($aMenus = Cache::get($sCacheKey)){
                return $aMenus;
            }
            else{
                $aMenus = self::_getMenusFromDb();
//                pr($obj->toArray());
                Cache::forever($sCacheKey, $aMenus);
            }
        }
        isset($aMenus) or $aMenus = self::_getMenusFromDb();
        return $aMenus;
    }
    
    private static function & _getMenusFromDb(){
        $aColumns = ['id', 'functionality_id', 'title', 'controller', 'action', 'params', 'new_window', 'sequence'];
        $aMainMenus = AdminMenu::whereNull('parent_id')->where('disabled', '=', 0)->orderBy('sequence', 'ASC')->get($aColumns);
//        print_r(count($aMainMenus));
//        exit;
//        $menus = AdminMenu::all();
        $menus = [];
        foreach ($aMainMenus as $oMainMenu) {
            $menus[$oMainMenu->id] = $oMainMenu->getAttributes();
            $menus[$oMainMenu->id]['children'] = [];
            $aSubMenus = AdminMenu::where('parent_id', '=', $oMainMenu->id)->where('disabled', '=', 0)->orderBy('sequence', 'ASC')->get($aColumns);
            foreach ($aSubMenus as $oMenu) {
                $route_name = $oMenu->controller . '@' . $oMenu->action;
//                echo $route_name . "<br>";
                // file_put_contents('/tmp/route', $route_name . "\n", FILE_APPEND);
                if ($route_name != '_main@_main'){
                    $oMenu->route_name = getRouterName($route_name);
                }
                $menus[$oMainMenu->id]['children'][] = $oMenu->getAttributes();
//                $menus[$oMainMenu->id]['children'][$oMenu->id] = $oMenu;
            }
        }
        
        return $menus;
    }
}