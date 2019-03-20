<?php

namespace app\controllers\auth;

use app\helper\SendRequestForReceiptBackendId;
use app\models\Client;
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
     * @return array|null
     */
    public function actionInfo(): ?array
    {
        $cookies = Yii::$app->request->cookies;
        return $cookies->has('registration') ? $cookies->getValue('registration') : null;
    }

    /**
     * Register user by parameters
     *
     * @param $step
     * @return array
     */
    public function actionRegister($step): array
    {
        $request = Yii::$app->request->post();
        $data['values'] = $request;
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'registration',
            'value' => array_merge($data, ['step' => (int)$step]),
        ]));
        return ['success' => true];
    }

    /**
     * Create user with feedbackDataId
     *
     * @return array
     */
    public function actionCreateUser(): array
    {
        $data = Yii::$app->request->post();
        $cookies = Yii::$app->request->cookies;
        $client = $cookies->has('client_id') ? (Client::findOne($cookies->getValue('client_id')) ?? new Client()) : new Client();
        $client->load($data, '');
        $client->save();
        // if during receipt feedbackDataId, we have an error, we can find our user
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'client_id',
            'value' => (int)$client->id,
        ]));
        $response = SendRequestForReceiptBackendId::getFeedbackDataId($client);
        if (!empty($response['feedbackDataId'])) {
            $client->feedbackDataId = $response['feedbackDataId'];
            $client->save();
            Yii::$app->response->cookies->remove('registration');
            Yii::$app->response->cookies->remove('client_id');
        }
        return $response;
    }
}