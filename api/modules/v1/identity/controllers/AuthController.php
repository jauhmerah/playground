<?php

namespace api\modules\v1\identity\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use api\models\OauthToken;
use common\models\User;

/**
 * Auth controller
 */
class AuthController extends Controller
{
    /**
     * @inheritdoc
     * Disable CSRF validation
     */
    public function beforeAction($action) 
    {
        if (in_array($action->id, ['token'])) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Handles generation of access token
     */
    public function actionToken()
    {
        $headers = Yii::$app->request->headers;
        $posts = Yii::$app->request->post();

        if (isset($headers['authorization'], $posts['grant_type'])) 
        {
            if (!\api\utilities\AppAuth::authenticate()) {
                throw new \yii\web\UnauthorizedHttpException('Not authorized');
            }

            switch ($posts['grant_type']) 
            {
                case 'password':
                    if (isset($posts['username'], $posts['password'])) {
                        $user = User::findOne(['email' => $posts['username'], 'is_deleted' => 0]);
                        if ($user && $user->validatePassword($posts['password'])) {
                            $access_token = $this->generateAccessToken($user->id);
                        }
                    }
                    break;

                default: // Do nothing
                    break;
            }

            if (isset($access_token)) {
                $user->touch('last_login_at');

                return ['access_token' => $access_token, 'expires_in' => OauthToken::ACCESS_LIFETIME, 'token_type' => 'bearer'];
            } else throw new \yii\web\UnauthorizedHttpException('Access Denied');
        }

        throw new \yii\web\UnauthorizedHttpException('Invalid Authorization');
    }

    /**
     * Generate a unique randomized token
     */
    protected function generateAccessToken($user_id) 
    {
        // Remove old records
        OauthToken::deleteAll(['user_id' => $user_id]);

        $access_token = bin2hex(openssl_random_pseudo_bytes(32));

        $model = new OauthToken;
        $model->access_token = $access_token;
        $model->user_id = $user_id;

        if ($model->save()) return $access_token;
        else return false;
    }
}
