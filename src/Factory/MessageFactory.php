<?php

namespace App\Factory;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class MessageFactory
{
  public function __construct(
    private readonly EntityManagerInterface $em,
  ) {}

  public function create(
    Conversation $conversation,
    User $author,
    string $content,
  ): Message {
    $message = new Message();
    $message->setContent($content);
    $message->setConversation($conversation);
    $message->setAuthor($author);
    $message->setCreatedAt(new \DateTimeImmutable());

    $this->em->persist($message);
    $this->em->flush();

    return $message;
  }
}
