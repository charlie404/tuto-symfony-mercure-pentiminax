<?php

namespace App\DTO;

readonly final class CreateMessage
{
  public function __construct(
    public readonly string $content,
    public readonly int $conversationId,
  ) {}
}
