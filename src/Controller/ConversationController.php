<?php

namespace App\Controller;

use App\Entity\User;
use App\Factory\ConversationFactory;
use App\Repository\ConversationRepository;
use App\Service\TopicService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConversationController extends AbstractController
{
  public function __construct(
    private readonly ConversationRepository $conversationRepository,
    private readonly ConversationFactory $conversationFactory,
    private readonly TopicService $topicService,
  ) {}

  #[Route('/conversation/users/{recipient}', name: 'conversation.show')]
  public function show(
    ?User $recipient,
  ): Response {
    $sender = $this->getUser();
    $conversation = $this->conversationRepository->findByUsers($sender, $recipient);

    if (!$conversation) {
      $conversation = $this->conversationFactory->create($sender, $recipient);
    }

    return $this->render('conversation/show.html.twig', [
      'conversation' => $conversation,
      'topic' => $this->topicService->getTopicUrl($conversation),
    ]);
  }
}
