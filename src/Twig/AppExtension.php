<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_active', [$this, 'isActive']),
        ];
    }

    public function isActive(string $routeName): string
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->attributes->get('_route');

        return str_starts_with($currentRoute, $routeName) ? 'active' : '';
    }
}