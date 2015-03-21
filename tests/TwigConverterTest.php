<?php

namespace Plum\PlumTwig;

use Mockery;
use Twig_Environment;
use Twig_Template;

/**
 * TwigConverterTest
 *
 * @package   Plum\PlumTwig
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2015 Florian Eckerstorfer
 * @group     unit
 */
class TwigConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers Plum\PlumTwig\TwigConverter::__construct()
     * @covers Plum\PlumTwig\TwigConverter::convert()
     */
    public function convertReturnsRenderedTemplateIfNoTargetPropertyIsProvided()
    {
        $twig = $this->getMockTwig('layout.html.twig', $this->getMockTemplate(['foo' => 'bar'], '<p>foo</p>'));
        $converter = new TwigConverter($twig, 'layout');

        $this->assertSame('<p>foo</p>', $converter->convert(['foo' => 'bar']));
    }

    /**
     * @test
     * @covers Plum\PlumTwig\TwigConverter::__construct()
     * @covers Plum\PlumTwig\TwigConverter::convert()
     */
    public function convertUsesTemplateFromTemplateProperty()
    {
        $item = ['foo' => 'bar', 'layout' => 'my'];

        $twig = $this->getMockTwig('my.html.twig', $this->getMockTemplate($item, '<p>foo</p>'));
        $converter = new TwigConverter($twig, 'layout.html.twig', 'layout');

        $this->assertSame('<p>foo</p>', $converter->convert($item));
    }

    /**
     * @test
     * @covers Plum\PlumTwig\TwigConverter::__construct()
     * @covers Plum\PlumTwig\TwigConverter::convert()
     */
    public function convertSetsRenderedUsingTargetProperty()
    {
        $twig = $this->getMockTwig('layout.html.twig', $this->getMockTemplate(['foo' => 'bar'], '<p>foo</p>'));
        $converter = new TwigConverter($twig, 'layout', 'layout', 'content');

        $this->assertSame('<p>foo</p>', $converter->convert(['foo' => 'bar'])['content']);
    }
    /**
     * @test
     * @covers Plum\PlumTwig\TwigConverter::setFileExtension()
     * @covers Plum\PlumTwig\TwigConverter::convert()
     */
    public function setFileExtensionChangesExtensionUsedInConvert()
    {
        $twig = $this->getMockTwig('layout.twig', $this->getMockTemplate(['foo' => 'bar'], '<p>foo</p>'));
        $converter = new TwigConverter($twig, 'layout');
        $converter->setFileExtension('.twig');

        $this->assertSame('<p>foo</p>', $converter->convert(['foo' => 'bar']));
    }

    /**
     * @param array  $context
     * @param string $rendered
     *
     * @return Mockery\MockInterface|Twig_Template
     */
    protected function getMockTemplate(array $context, $rendered)
    {
        $template = Mockery::mock('Twig_Template');
        $template->shouldReceive('render')->with($context)->once()->andReturn($rendered);

        return $template;
    }

    /**
     * @param string        $file
     * @param Twig_Template $template
     *
     * @return Mockery\MockInterface|Twig_Environment
     */
    protected function getMockTwig($file, $template)
    {
        $twig = Mockery::mock('Twig_Environment');
        $twig->shouldReceive('loadTemplate')->with($file)->once()->andReturn($template);

        return $twig;
    }
}
