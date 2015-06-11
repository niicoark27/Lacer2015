<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 3/17/15
 * Time: 7:08 AM
 */

namespace App\Vasoft\Mailers;


use App\Vasoft\Contracts\CanSendEmailContract;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Translation\Translator;


class VasoftMailer {
    /**
     * @var IlluminateMailer
     */
    protected $mailer;
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param MailerContract $mailer
     * @param Translator $translator
     */
    public function __construct(MailerContract $mailer, Translator $translator) {
        $this->mailer = $mailer;
        $this->translator = $translator;
    }

    public function sendTo(CanSendEmailContract $user, $subject, $view, $data = []) {
        $this->mailer->queue($view, $data, function($message) use ($user, $subject) {
            // Handle the rare case when a user's email address was not found
            $email = $user->getEmailAddress();
            if ($email) {
                $message->to($email)->subject($subject);
            }
        });
    }
}