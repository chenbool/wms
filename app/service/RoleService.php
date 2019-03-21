<?php
namespace app\service;

use think\Request,
	app\model\Role,
	app\model\Menu,
	app\validate\RoleValidate;

class RoleService
{

	public function page()
	{
		return Role::where('status', 0)->paginate(10);
	}

	public function menu()
	{
		$menu = new MenuService();
		return $menu->getPermissionTree();
	}

    // 保存数据
	public function save()
	{
		Request::instance()->isPost() || die('request not  post!');

		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if (is_null($error)) {

			if (Role::get(['name' => $param['name']])) {
				return ['error' => 100, 'msg' => '名称已经存在'];
				exit();
			}

			$role = new Role();
			$role->name = $param['name'];
			$role->ids = $param['ids'];
			$role->desc = $param['desc'];
			$role->add_time = time();

			// 检测错误
			if ($role->save()) {
				return ['error' => 0, 'msg' => '保存成功'];
			} else {
				return ['error' => 100, 'msg' => '保存失败'];
			}

		} else {
			return ['error' => 100, 'msg' => $error];
		}
	}

	public function update()
	{
		Request::instance()->isPost() || die('request not  post!');

		$param = Request::instance()->param();	//获取参数
		$error = $this->_validate($param); 		// 是否通过验证

		if (is_null($error)) {

			$role = Role::get($param['id']);
			$role->name = $param['name'];
			$role->ids = $param['ids'];
			$role->desc = $param['desc'];

			// 检测错误
			if ($role->save()) {
				return ['error' => 0, 'msg' => '修改成功'];
			} else {
				return ['error' => 100, 'msg' => '修改失败'];
			}

		} else {
			return ['error' => 100, 'msg' => $error];
		}


	}

    // 验证器
	private function _validate($data)
	{
		// 验证
		$validate = validate('RoleValidate');
		if (!$validate->check($data)) {
			return $validate->getError();
		}
	}

	public function edit($id)
	{
		return Role::get($id);
	}


	public function delete($id)
	{
		if (Role::destroy($id)) {
			return ['error' => 0, 'msg' => '删除成功'];
		} else {
			return ['error' => 100, 'msg' => '删除失败'];
		}

		// 支持批量删除多个数据
		// User::destroy('1,2,3');
		// // 或者
		// User::destroy([1,2,3]);
	}

}
