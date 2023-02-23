<?php

namespace App\Classes;

use App\Models\Company;
use App\Models\Settings;
use App\Notifications\MainNotificaiton;
use Examyou\RestAPI\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;

class Notify
{
    public static function getData($sendFor, $sendData)
    {
        $data = [];

        if (in_array($sendFor, ['staff_member_create', 'staff_member_update', 'staff_member_delete'])) {
            $company = Company::find($sendData->company_id);

            $data['to'] = $company;
            $data['company'] = $company;
            $data['user'] = $sendData;
        }

        return $data;
    }

    public static function isAbleToSendMail($sendFor, $dataArray)
    {
        $isAbleToSendMail = false;
        $content = "";
        $title = "";

        if (app_type() == 'saas') {
            $globalCompany = Company::where('is_global', 1)->first();
            $mailSetting = DB::table('settings')->where('setting_type', 'email')
                ->where('name_key', 'smtp')
                ->where('is_global', 1)
                ->where('company_id', $globalCompany->id)
                ->first();
        } else {
            $mailSetting = Settings::where('setting_type', 'email')
                ->where('name_key', 'smtp')
                ->first();
        }


        // For Email
        if ($mailSetting && $mailSetting->status && $mailSetting->verified) {
            // $emailNameKey = self::getNameKey($sendFor);

            $sendMailSettings = Settings::where('setting_type', 'send_mail_settings')
                // ->where('name_key', $emailNameKey)
                ->first();

            if ($sendMailSettings && $sendMailSettings->credentials && in_array($sendFor, $sendMailSettings->credentials)) {
                $isAbleToSendMail = true;

                // Retrieve $content and $title from database using $sendFor
                $notificationSetting = Settings::where('setting_type', 'email_templates')
                    ->where('name_key', $sendFor)
                    ->first();

                if (!$notificationSetting) {
                    throw new ApiException('No email template found for ' . $sendFor);
                }

                $title = $notificationSetting && $notificationSetting->credentials ? $notificationSetting->credentials['title'] : '';
                $content = $notificationSetting && $notificationSetting->credentials ? $notificationSetting->credentials['content'] : '';

                $title = self::getReplacedHtml($title, $dataArray);
                $content = self::getReplacedHtml($content, $dataArray);
            }
        }

        return [
            'setting' => $mailSetting,
            'isAbleToSend' => $isAbleToSendMail,
            'content' => $content,
            'title' => $title
        ];
    }

    public static function getDataArray($data)
    {
        $newDataKey = [
            'user_name' => $data && isset($data['user']) && isset($data['user']['name']) ? $data['user']['name'] : '',
            'company_name' => $data && isset($data['company']) && isset($data['company']['name']) ? $data['company']['name'] : '',
        ];

        return $newDataKey;
    }

    public static function getReplacedHtml($html, $dataArray)
    {
        preg_match_all("/##(\w+)##/m", $html, $matches);

        if (isset($matches[1])) {
            foreach ($matches[1] as $match) {
                $html = str_replace('##' . $match . '##', $dataArray[$match], $html);
            }
        }

        return $html;
    }

    public static function send($sendFor, $sendData)
    {
        $data = self::getData($sendFor, $sendData);
        $dataArray = self::getDataArray($data);
        $sender = $data['to'];

        $notficationData = [
            'send_for' => $sendFor,
            'to' => $data['to'],
            'mail' => self::isAbleToSendMail($sendFor, $dataArray),
            'data' => $data,
        ];

        $sender->notify(new MainNotificaiton($notficationData));
    }
}
