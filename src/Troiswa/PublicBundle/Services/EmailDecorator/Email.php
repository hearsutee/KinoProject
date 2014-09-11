<?php
namespace Troiswa\PublicBundle\Services\EmailDecorator;

class Email
{
    private $tpl;
    private $mailer;

    public function __construct($templater, $mailuuu) // premiere argument = service templating 1 deuxieme = ... le nom n'est pas utile
    {
        $this->tpl = $templater;
        $this->mailer = $mailuuu;
    }

    public function send($template, $to, $data = [ ], $sujet = "un message de manu")
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($sujet)
            ->setFrom("manuoval@gmail.com")
            ->setTo($to)
            ->setBody($this->tpl->render($template, array( 'data' => $data )));

        $this->mailer->send($message);
    }
}
