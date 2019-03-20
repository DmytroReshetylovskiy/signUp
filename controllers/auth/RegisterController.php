<?php

namespace app\controllers\auth;

use app\helper\CookieHelper;
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
     * @return array|null
     */
    public function actionInfo(): ?array
    {
        $cookies = Yii::$app->request->cookies;
        $data = CookieHelper::getCookie($cookies);
        return $data;
    }

    /**
     * Register user by parameters
     *
     * @param $step
     * @return array
     */
    public function actionRegister($step): array
    {
        $data = Yii::$app->request->post();

        if ($step == 1) {
            $user = !empty($data['clientId']) ? (User::findOne($data['clientId']) ?? new User()) : new User();
            $user->load($data, '');
            $user->save();
            $data = [
                'clientId' => $user->id,
            ];
            CookieHelper::setCookie('registration', $data);
        } elseif ($step == 2) {
            $data = [
                'address' => $data['address'],
            ];
            CookieHelper::setCookie('additionally', $data);
        } elseif ($step == 3) {
            $data = [
                'address' => $data['address'],
                'comment' => $data['comment'],
            ];
            CookieHelper::setCookie('additionally', $data);
        }
        CookieHelper::setCookie('step', (int)$step);
        return ['success' => true];
    }
}