<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Scopes\CompanyScope;

class Settings extends BaseModel
{
    protected $table = 'settings';

    protected $default = ['xid'];

    protected $guarded = ['id', 'is_global', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $appends = ['xid'];

    protected $casts = [
        'credentials' => 'array',
        'other_data' => 'array',
        'status' => 'integer',
        'verified' => 'integer',
    ];

    public static $awsRegions = [
        'us-east-2' => 'US East (Ohio) us-east-2',
        'us-east-1' => 'US East (N. Virginia) us-east-1',
        'us-west-1' => 'US West (N. California) us-west-1',
        'us-west-2' => 'US West (Oregon) us-west-2',
        'af-south-1' => 'Africa (Cape Town) af-south-1',
        'ap-east-1' => 'Asia Pacific (Hong Kong) ap-east-1',
        'ap-south-1' => 'Asia Pacific (Mumbai) ap-south-1',
        'ap-northeast-3' => 'Asia Pacific (Osaka-Local) ap-northeast-3',
        'ap-northeast-2' => 'Asia Pacific (Seoul)	ap-northeast-2',
        'ap-northeast-1' => 'Asia Pacific (Singapore)	ap-southeast-1',
        'ap-southeast-2' => 'Asia Pacific (Sydney) ap-southeast-2',
        'ap-northeast-1' => 'Asia Pacific (Tokyo)	ap-northeast-1',
        'ca-central-1' => 'Canada (Central) ca-central-1',
        'eu-central-1' => 'Europe (Frankfurt) eu-central-1',
        'eu-west-1' => 'Europe (Ireland) eu-west-1',
        'eu-west-2' => 'Europe (London)  eu-west-2',
        'eu-south-1' => 'Europe (Milan) eu-south-1',
        'eu-west-3' => 'Europe (Paris) eu-west-3',
        'eu-north-1' => 'Europe (Stockholm) eu-north-1',
        'me-south-1' => 'Middle East (Bahrain) me-south-1',
        'sa-east-1' => 'South America (São Paulo)	 sa-east-1'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);
    }

    public function verifySmtp()
    {
        if ($this->name_key == 'smtp') {
            try {
                $transport = new \Swift_SmtpTransport($this->credentials['host'], $this->credentials['port'], $this->credentials['encryption']);
                $transport->setUsername($this->credentials['username']);
                $transport->setPassword($this->credentials['password']);

                $mailer = new \Swift_Mailer($transport);
                $mailer->getTransport()->start();

                if ($this->verified == 0) {
                    $this->verified = 1;
                    $this->save();
                }

                return [
                    'status' => 'success',
                    'message' => 'SMTP Setting saved successfully',
                    'verified' => 1
                ];
            } catch (\Swift_TransportException $e) {
                $this->verified = 0;
                $this->save();

                return [
                    'status' => 'fail',
                    'message' => $e->getMessage(),
                    'verified' => 0
                ];
            } catch (\Exception $e) {
                $this->verified = 0;
                $this->save();

                return [
                    'status' => 'fail',
                    'message' => $e->getMessage(),
                    'verified' => 0
                ];
            }
        } else {
            return [
                'status' => 'success',
                'message' => 'Mail Setting saved successfully',
                'verified' => 0
            ];
        }
    }
}
