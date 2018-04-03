<?php
namespace api\utilities;

use Yii;

class AppAuth
{
    public static function authenticate()
    {
        $app['id'] = Yii::$app->params['app.id'];
        $app['secret'] = Yii::$app->params['app.secret'];

        $headers = Yii::$app->request->headers;
        if (isset($headers['authorization'])) {
            $type = substr($headers['authorization'], 0, 5); // Basic
            $auth = substr($headers['authorization'], 6);
            if ($auth) {
                list($app_id, $app_secret) = explode(':', base64_decode($auth));
                if (($app_id == $app['id']) && ($app_secret == $app['secret'])) return true;
            }
        }

        return false;
    }
}