<?php

namespace App;

use App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminUser extends Authenticatable
{
    protected $rememberTokenName = '';
    protected $guarded = []; // 不可以注入的字段

    // 用户的角色
    public function roles()
    {
        // 参数1：目标类，参数2：关系表，参数3：当前对象在关系表中的外键，参数4：想要获取的对象表在关系表中的外键
        // 获取关系表的字段wothPivot
        return $this->belongsToMany(\App\AdminRole::class, 'admin_role_user', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    // 判断是否有某些角色
    public function isInRoles($roles)
    {
        return !!$roles->intersect($this->roles)->count();
    }

    // 给用户分配角色

    /**
     * 给用户分配角色
     * @param $role
     */
    public function assignRole($role)
    {
        // 有roles函数存在，直接调用
        $this->roles()->save($role);
    }

    // 删除用户角色
    public function deleteRole($role)
    {
        return $this->roles()->detach($role);
    }

    // 用户是否有权限
    public function hadPermission($permission)
    {
        // 判断该permission所属的role是否和用户的role有交集
        return $this->isInRoles($permission->roles);
    }
}
