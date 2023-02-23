<?php

namespace App\Classes;

use App\Models\Company;
use App\Models\Settings;
use App\Scopes\CompanyScope;

class NotificationSeed
{
    public static $emailNotificaiotnArray = [

        // Users
        'staff_member_create' => [
            'type' => "email_templates",
            'title' => "Staff Member created",
            'content' => "A new staff Member added with ##user_name## name in your company ##company_name##.",
            'other_data' => []
        ],
        'staff_member_update' => [
            'type' => "email_templates",
            'title' => "Staff Member updated",
            'content' => "Staff Member with name ##user_name## updated in your company ##company_name##.",
            'other_data' => []
        ],
        'staff_member_delete' => [
            'type' => "email_templates",
            'title' => "Staff Member deleted",
            'content' => "Staff member with name ##user_name## deleted from your company ##company_name##.",
            'other_data' => []
        ],
    ];


    public static function getNotificationArray($moduleName)
    {
        return self::$emailNotificaiotnArray;
    }

    public static function seedNotifications($companyId, $moduleName = '')
    {
        $notifications = self::getNotificationArray($moduleName);

        foreach ($notifications as $key => $notification) {
            $notificationCount = Settings::withoutGlobalScope(CompanyScope::class)
                ->where('setting_type', $notification['type'])
                ->where('name_key', $key)
                ->where('company_id', $companyId)
                ->count();

            if ($notificationCount == 0) {
                $newNotification = new Settings();
                $newNotification->company_id = $companyId;
                $newNotification->setting_type = $notification['type'];
                $newNotification->name = $notification['title'];
                $newNotification->name_key = $key;
                $newNotification->credentials = [
                    'title' => $notification['title'],
                    'content' => $notification['content'],
                ];
                $newNotification->save();
            }
        }
    }

    public static function seedAllModulesNotifications($companyId)
    {
        // Main Module
        self::seedNotifications($companyId);
    }
}
