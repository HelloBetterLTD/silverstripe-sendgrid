<?php

namespace HelloBetter\SendGridMailer\Mailer;

use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Factory;
use Symfony\Component\Mailer\Transport;

class SendGridTransportFactory implements Factory
{

    public function create($service, array $params = [])
    {
        $dispatcher = $params['dispatcher'];
        $sendGridAPI = Environment::getEnv('SENDGRID_API_KEY');
        if ($sendGridAPI) {
            return Transport::fromDsn('sendgrid+api://' . $sendGridAPI . '@default', $dispatcher);
        }

        $dsn = Environment::getEnv('MAILER_DSN') ?: $params['dsn'];
        return Transport::fromDsn($dsn, $dispatcher);
    }

}
