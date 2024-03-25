<?php

declare(strict_types=1);

/*
 * UnBlocker service for routers.
 *
 * (c) Mykhailo Shtanko <fractalzombie@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FRZB\Component\MetricsPower\OptionResolver\Resolver;

use FRZB\Component\DependencyInjection\Attribute\AsIgnored;
use FRZB\Component\DependencyInjection\Attribute\AsService;
use FRZB\Component\MetricsPower\Attribute\OptionsInterface;
use FRZB\Component\MetricsPower\Logger\MetricsPowerLoggerInterface;
use Symfony\Component\Messenger\Event\AbstractWorkerMessageEvent;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;

#[AsService]
class DefaultOptionResolver implements OptionResolverInterface
{
    public function __construct(
        private readonly MetricsPowerLoggerInterface $logger,
    ) {}

    public function __invoke(AbstractWorkerMessageEvent|SendMessageToTransportsEvent $event, OptionsInterface $options): void
    {
        $this->logger->logInfo($event, $options);
    }

    public static function getType(): string
    {
        return OptionsInterface::class;
    }
}
