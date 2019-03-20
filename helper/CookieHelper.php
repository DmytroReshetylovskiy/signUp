<?php

namespace app\helper;

use yii\web\CookieCollection;
use app\models\User;
use Yii;
use yii\web\Cookie;

/**
 * Class CookieHelper
 */
abstract class CookieHelper
{
    /**
     * Cookies's name for check on exist
     *
     * @var array
     */
    private static $cookieNames = [
        'registration',
        'step',
        'additionally',
    ];

    /**
     * @var null|array
     */
    private static $data = null;

    /**
     * Helper for create cookie
     *
     * @param $name
     * @param $value
     */
    public static function setCookie($name, $value)
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => $name,
            'value' => $value,
        ]));
    }

    /**
     * @param $cookies
     * @return array|boolean
     */
    public static function getCookie(CookieCollection $cookies)
    {
        foreach (self::$cookieNames as $name) {
            if ($cookies->has($name)) {
                self::{$name}($cookies);
            }
        }
        return self::$data;
    }

    /**
     * Get values from register
     *
     * @param $cookies
     */
    protected static function registration($cookies)
    {
        $data = $cookies->getValue('registration');
        if (!empty($data['clientId']) && $user = User::findOne($data['clientId'])->toArray()) {
            unset($user['id']);
            self::$data = array_merge($data, ['values' => $user]);
        }
    }

    /**
     * Get values from step
     *
     * @param $cookies
     */
    protected static function step($cookies)
    {
        $step = $cookies->getValue('step');
        self::$data = array_merge(self::$data, ['step' => $step]);
    }

    /**
     * Get values from additionally
     *
     * @param $cookies
     */
    protected static function additionally($cookies)
    {
        $additionally = $cookies->getValue('additionally');
        foreach ($additionally as $key => $value) {
            self::$data['values'][$key] = $value;
        }
    }
}