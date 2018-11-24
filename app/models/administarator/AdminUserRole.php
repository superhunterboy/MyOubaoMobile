<?php
# Deprecated 管理员角色关联
class AdminUserRole extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_role_admin_user';
    public static $resourceName = 'AdminUserRole';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
    protected $guarded = [];
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
    //     'user_id' => 'aAdminUsers',
    //     'role_id' => 'aRoles',
    // ];
    public $orderColumns = [
        'updated_at' => 'asc'
    ];
    public static $rules = [
        'user_id'        => 'required|numeric',
        'role_id'        => 'required|numeric',
    ];

    public static function checkUserRoleRelation ($role_id, $user_id)
    {
        if (!$role_id || !$user_id) return false;
        return self::where('role_id', '=', $role_id)->where('user_id', '=', $user_id)->exists();
    }
}