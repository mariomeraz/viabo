<?php


namespace Viabo\shared\infrastructure\email;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Viabo\shared\domain\email\Email;
use Viabo\shared\domain\email\EmailRepository;
use Viabo\shared\domain\email\exceptions\EmailNotSend;

final readonly class EmailSymfonyMailerRepository implements EmailRepository
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send(Email $email): void
    {
        list($to, $from, $subject, $template, $context) = $email->content();

        $email = (new TemplatedEmail())
            ->from(new Address($from['email'], $from['name']))
            ->to(...$to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            throw new EmailNotSend($exception->getMessage());
        }
    }
}