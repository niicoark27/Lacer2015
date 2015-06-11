<?php
/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 3/17/15
 * Time: 7:14 AM
 */

namespace App\Vasoft\Mailers;


use App\Models\Notification;
use App\Vasoft\Contracts\CanEmailTokenContract;
use App\Vasoft\Contracts\CanSendEmailContract;
use Illuminate\Support\Facades\Config;

class UserMailer extends VasoftMailer {
    /**
     *
     */
    const SIGNUP_EMAIL_SUBJECT = 'user_emails.signup_email_subject';
    /**
     *
     */
    const PASSWORD_RESET_SUBJECT = 'user_emails.password_reset_subject';
    /**
     *
     */
    const NEW_CORRESPONDENCE_RECEIVED = 'user_emails.new_correspondence_received';
    /**
     *
     */
    const CORRESPONDENCE_UPDATED = 'user_emails.correspondence_updated';

    /**
     * Send account signup email
     * @param CanSendEmailContract $tokenRecord
     */
    public function sendSignupEmail(CanSendEmailContract $tokenRecord) {
        $view = Config::get('app.locale') . '.emails.signup_email';
        $data = ['token' => urlencode($tokenRecord->getToken())];
        $subject = $this->translator->get(self::SIGNUP_EMAIL_SUBJECT);

        $this->sendTo($tokenRecord, $subject, $view, $data);
    }

    /**
     * Email link to reset password
     * @param CanSendEmailContract $record
     */
    public function sendPasswordResetEmail(CanSendEmailContract $record) {
        $view = Config::get('app.locale') . '.emails.password_reset';
        $data = ['token' => urlencode($record->getToken())];
        $subject = $this->translator->get(self::PASSWORD_RESET_SUBJECT);

        $this->sendTo($record, $subject, $view, $data);
    }

    /**
     * @param Notification $record
     */
    public function sendNotificationEmail(Notification $record) {
        $view = Config::get('app.locale') . '.emails.notification_email';
        $data = [
            'fullname' => $record->recipient->getFullname(),
            'message' => $record->getAttribute('message')
        ];
        $subject = $this->translator->get($this->getNotificationSubjectHelper($record));

        $this->sendTo($record->recipient, $subject, $view, $data);
    }

    /**
     * @param Notification $record
     * @return string
     */
    protected function getNotificationSubjectHelper(Notification $record) {
        if ($record->notificationType->isCorrespondenceReceived())
            return self::NEW_CORRESPONDENCE_RECEIVED;
        else if ($record->notificationType->isCorrespondenceUpdated())
            return self::CORRESPONDENCE_UPDATED;
    }
}