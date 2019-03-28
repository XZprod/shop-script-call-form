<?php

class shopOrdercalllocPluginFrontendProcessController extends waJsonController
{
    public function execute()
    {
        $isValidCaptcha = wa()->getCaptcha()->isValid();

        if (!$isValidCaptcha) {
            return $this->response['captchaError'] = true;
        }

        $data = waRequest::post();

        $validator = new shopOrdercalllocFormValidator($data);
        $validator->validate();

        if (!$validator->hasErrors()) {
            $this->response['successSend'] = true;
            $this->sendMail($validator->getData());

        } else {
            $this->response['qq'] = 'ne ok';
            $this->response['validateErrors'] = $validator->getErrors();
        }
    }

    private function sendMail($data)
    {

        $sender = wa('shop')->getPlugin('ordercallloc')->getSettings('sendFrom');
        $to = wa('shop')->getPlugin('ordercallloc')->getSettings('noticeMail');

        $subject = 'Новый заказ звонка на сайте';
        $body = <<<EOT
Имя отправителя: {$data['name']}
Номер отправителя: {$data['phone']}
Удобное время для звонка: с {$data['time-from']} до {$data['time-to']}
Комментарий: {$data['comment']}
EOT;
        $mail_message = new waMailMessage($subject, $body, 'text/plain');
        $mail_message->setFrom($sender, 'XZProd');
        $mail_message->setTo($to, 'admin');
        $mail_message->send();
    }
}