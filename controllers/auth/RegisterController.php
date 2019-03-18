<?php

namespace app\controllers\auth;

use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Cookie;

/**
 * Class RegisterController
 * @package app\controllers
 */
class RegisterController extends Controller
{
    /**
     * Get information about registration
     *
     * @param null $data
     * @return array
     */
    public function actionInfo($data = null)
    {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('registration')) {
            $data = $cookies->getValue('registration');
            if (!empty($data['clientId']) && $user = User::findOne($data['clientId'])->toArray()) {
                unset($user['id']);
                $data = array_merge($data, ['values' => $user]);
            }
        }

        return $data;
    }

    /**
     * Register user by parameters
     *
     * @param $step
     * @return User
     */
    public function actionRegister($step)
    {
        $data = Yii::$app->request->post();

        if ($step == 1) {
            $user = !empty($data['clientId']) ? (User::findOne($data['clientId']) ?? new User()) : new User();
            $user->load($data, '');
            $user->save();
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'registration',
                'value' => [
                    'clientId' => $user->id,
                    'step' => $step,
                ]
            ]));
        }

        return $user;
    }
}