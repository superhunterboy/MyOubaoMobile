<?php

# 用户和角色的关联

class UserRole extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_role_user';
    public static $resourceName = 'UserRole';
    public static $mainParamColumn = 'role_id';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    protected $guarded = [];
    public static $titleColumn = 'name';

    /**
     * 软删除
     * @var boolean
     */
    protected $softDelete = false;
    protected $fillable = [
        'id',
        'user_id',
        'role_id',
        'username',
        'role_name',
    ];
    public static $columnForList = [
        'username',
        'role_name',
        'created_at',
        'updated_at',
    ];

    /**
     * 下拉列表框字段配置
     * @var array
     */
    // public static $htmlSelectColumns = [
    //     'user_id' => 'aUsers',
    //     'role_id' => 'aRoles',
    // ];
    public $orderColumns = [
        'updated_at' => 'asc'
    ];
    public static $rules = [
        'user_id' => 'required|numeric',
        'role_id' => 'required|numeric',
    ];
    public static $htmlSelectColumns = [
        'role_id' => 'aUserRoles',
    ];

    public static function checkUserRoleRelation($role_id, $user_id) {
        if (!$role_id || !$user_id)
            return false;
        return self::where('role_id', '=', $role_id)->where('user_id', '=', $user_id)->exists();
    }

    /**
     * 根据role_id获取用户id信息数组
     * @param int $iRoleId  角色id
     */
    public static function getUserIdsFromRoleId($iRoleId) {
        $data = [];
        $oUserIds = self::where('role_id', '=', $iRoleId)->get(['user_id']);
        foreach ($oUserIds as  $value) {
            $data[] = $value->user_id;
        }
        return $data;
    }

}
