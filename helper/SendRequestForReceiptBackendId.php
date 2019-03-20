<?php

namespace app\helper;

use app\models\Client;
use Yii;

/**
 * Class SendRequestForReceiptBackendId
 * @package app\helper
 */
abstract class SendRequestForReceiptBackendId
{
    /**
     * Query path
     *
     * @var array
     */
    private static $path = 'http://test.vrgsoft.net/feedbacks';

    /**
     * Formation request and get feedbackDataId
     *
     * @param Client $client
     * @return bool|string
     */
    public static function getFeedbackDataId(Client $client): array
    {
        $data = [
            'client_id' => $client->id,
            'address' => $client->address,
            'comment' => $client->comment,
        ];
        $jsonEncode = json_encode($data);

        $ch = curl_init(self::$path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonEncode);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonEncode)
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);
        if (!empty($result['error'])) {
            Yii::error($result['error'],'getFeedbackDataId');
        }

        return $result;
    }
}