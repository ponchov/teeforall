<?php

namespace User\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

use User\Table\MailTemplate as MailTemplateStorage;
use User\Entity\User as UserEntity;

class Mail implements ServiceManagerAwareInterface
{
    /**
     * Storage of mail templates
     *
     * @var MailTemplateStorage
     */
    protected $storage = null;

    /**
     *
     * @var ServiceManager
     */
    protected $serviceManager = null;

    /**
     * email address of sender
     *
     * @var string
     */
    protected $fromMail = null;

    /**
     *
     * @param MailTemplateStorage $storage
     * @param string $fromMail
     */
    public function __construct(MailTemplateStorage $storage, $fromMail)
    {
        $this->storage = $storage;
        $this->fromMail = $fromMail;
    }

    /**
     *
     * @param \Zend\ServiceManager\ServiceManager $serviceManager
     * @return \User\Service\User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;

        return $this;
    }

    /**
     * Builds the headers of the mail
     *
     * @param string $to
     * @return string
     */
    public function buildHeaders($to)
    {
        $headers = array(
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=iso-8859-1',
        );

        $headers[] = sprintf("To: %s", $to);
        $headers[] = sprintf("From: TeeForAll <%s>", $this->fromMail);

        return implode("\r\n", $headers);
    }

    /**
     * Sends the mail to $to with subject $subject and body $body
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return boolean
     */
    public function send($to, $subject, $body)
    {
        $message =
            '<div style="font-family:Verdana, Geneva, sans-serif; font-size: 11px; color: #1F1F1F;">'
            . $body
            . '</div>';

        mail($to, $subject, $message, $this->buildHeaders($to));

        return true;
    }

    /**
     * Sends the mail to user with info about successfull registration
     *
     * @param \User\Entity\User $user
     * @param string $password
     * @param string $siteName
     */
    public function noticeOfCreation(UserEntity $user, $password, $siteName, $actUrl = null)
    {
        $template = $this->storage->getByKey(2);

        $serverUrl = $this->serviceManager->get('ViewHelperManager')->get('serverUrl');
        $body = str_replace(
            array(
                "[NAME]",
                "[SITENAME]",
                "[LOGINNAME]",
                "[PASSWORD]",
                "[SITEURL]",
                "[ACTIVATIONLINK]",
            ),
            array(
                $user->username,
                $siteName,
                $user->username,
                $password,
                $serverUrl(),
                sprintf('<a href="%s">%s</a>', $actUrl, $actUrl)
            ),
            $template->emailBody
        );

        return $this->send($user->username, $template->emailSubject, $body);
    }

    /**
     * Sends the email to user with info how to reset his password
     *
     * @param UserEntity $user
     * @param string $siteName
     * @param string $actUrl
     * @return boolean
     */
    public function noticeOfForgotPassword(UserEntity $user, $siteName, $actUrl = null)
    {
        $template = $this->storage->getByKey(3);

        $body = str_replace(
            array(
                "[NAME]",
                "[SITENAME]",
                "[PASSWORDRESETURL]",
            ),
            array(
                $user->username,
                $siteName,
                sprintf('<a href="%s">%s</a>', $actUrl, $actUrl)
            ),
            $template->emailBody
        );

        return $this->send($user->username, $template->emailSubject, $body);
    }

    /**
     * 
     *
     * @param \Application\Entity\User $user
     * @param string $siteName
     */
    public function noticeOfValidation(UserEntity $user, $siteName)
    {
    }
}