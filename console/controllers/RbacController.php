<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        echo "Cleaning auth tables.\n";
        Yii::$app->db->createCommand('SET foreign_key_checks=0')->execute();
        Yii::$app->db->createCommand()->truncateTable('{{%auth_item}}')->execute();
        Yii::$app->db->createCommand()->truncateTable('{{%auth_item_child}}')->execute();
        Yii::$app->db->createCommand('SET foreign_key_checks=1')->execute();


        echo "Initializing auth tables.\n";
        // Create permissions
        /* SETTING */
        $setting['update'] = $auth->createPermission('setting-update');
        $setting['update']->description = 'Update setting';
        $auth->add($setting['update']);

        /* USER */
        $user['view'] = $auth->createPermission('user-view');
        $user['view']->description = 'View user';
        $auth->add($user['view']);

        $user['create'] = $auth->createPermission('user-create');
        $user['create']->description = 'Create user';
        $auth->add($user['create']);

        $user['update'] = $auth->createPermission('user-update');
        $user['update']->description = 'Update user';
        $auth->add($user['update']);

        $user['delete'] = $auth->createPermission('user-delete');
        $user['delete']->description = 'Delete user';
        $auth->add($user['delete']);

        /* PACKAGE */
        $package['view'] = $auth->createPermission('package-view');
        $package['view']->description = 'View package';
        $auth->add($package['view']);

        $package['create'] = $auth->createPermission('package-create');
        $package['create']->description = 'Create package';
        $auth->add($package['create']);

        $package['update'] = $auth->createPermission('package-update');
        $package['update']->description = 'Update package';
        $auth->add($package['update']);
    
        $package['delete'] = $auth->createPermission('package-delete');
        $package['delete']->description = 'Delete package';
        $auth->add($package['delete']);

        // Assign permission to roles
        $role['super'] = $auth->createRole('super');
        $auth->add($role['super']);
        $auth->addChild($role['super'], $setting['update']);
        $auth->addChild($role['super'], $user['view']);
        $auth->addChild($role['super'], $user['create']);
        $auth->addChild($role['super'], $user['update']);
        $auth->addChild($role['super'], $user['delete']);

        $role['admin'] = $auth->createRole('admin');
        $auth->add($role['admin']);
        $auth->addChild($role['admin'], $setting['update']);
        $auth->addChild($role['admin'], $user['view']);
        $auth->addChild($role['admin'], $user['create']);
        $auth->addChild($role['admin'], $user['update']);
        $auth->addChild($role['admin'], $package['view']);
        $auth->addChild($role['admin'], $package['create']);
        $auth->addChild($role['admin'], $package['update']);
        $auth->addChild($role['admin'], $package['delete']);

        // Frontend Only Roles
        $registered = $auth->createRole('registered');
        $auth->add($registered);

        echo "RBAC init completed.\n\n";
        return \yii\console\Controller::EXIT_CODE_NORMAL;
    }
}