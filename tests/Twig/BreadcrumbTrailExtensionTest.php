<?php

namespace APY\BreadcrumbTrailBundle\Twig;

use APY\BreadcrumbTrailBundle\APYBreadcrumbTrailBundle;
use Nyholm\BundleTest\TestKernel;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @coversDefaultClass \APY\BreadcrumbTrailBundle\Twig\BreadcrumbTrailExtension
 */
class BreadcrumbTrailExtensionTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /** @var TestKernel $kernel */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(APYBreadcrumbTrailBundle::class);
        $kernel->addTestBundle(TwigBundle::class);
        $kernel->handleOptions($options);

        return $kernel;
    }

    /**
     * @requires PHP >= 8.0
     */
    public function testTwigFunctionGetsRegistered()
    {
        if (method_exists($this, 'getContainer')) {
            $container = self::getContainer();
        } else {
            self::bootKernel();
            $container = self::$container;
        }

        /** @var BreadcrumbTrailExtension $extension */
        $extension = $container->get(BreadcrumbTrailExtension::class);

        $function = current($extension->getFunctions());

        self::assertEquals('apy_breadcrumb_trail_render', $function->getName());
    }
}
