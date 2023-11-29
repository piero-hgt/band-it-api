<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Middleware;

use Shared\Domain\Bus\Command\CommandBusInterface;
use Shared\Domain\Bus\Command\CommandCallbackOnFailureInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\RedeliveryStamp;

class FailureCatchMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly int $maxRetries,
    ) {
    }

    /**
     * @throws \Exception|\Throwable
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            return $stack->next()->handle($envelope, $stack);
        } catch (HandlerFailedException $e) {
            if ($envelope->getMessage() instanceof CommandCallbackOnFailureInterface && $this->isLastRetry($envelope)) {
                /** @var CommandCallbackOnFailureInterface $message */
                $message = $envelope->getMessage();

                $this->commandBus->publish($message->getFailureCommand());
            }

            throw current($e->getWrappedExceptions());
        }
    }

    private function isLastRetry(Envelope $envelope): bool
    {
        return $envelope->last(RedeliveryStamp::class)?->getRetryCount() >= $this->maxRetries;
    }
}
