<?php

namespace app\controllers\auth;

use app\models\User;
use Yii;
use yii\rest\Controller;

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
        $session = Yii::$app->session;
        if ($session->has('registration')) {
            $data = $session->get('registration');
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
        }

        return $user;
    }
}