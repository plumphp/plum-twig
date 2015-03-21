<?php

namespace Plum\PlumTwig;

use Twig_Environment;
use Plum\Plum\Converter\ConverterInterface;
use Cocur\Vale\Vale;

/**
 * TwigConverter
 *
 * @package   Plum\PlumTwig
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2015 Florian Eckerstorfer
 */
class TwigConverter implements ConverterInterface
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $defaultTemplate;

    /**
     * @var array|string|int|null
     */
    protected $templateProperty;

    /**
     * @var array|string|int|null
     */
    protected $targetProperty;

    /**
     * @var string
     */
    protected $fileExtension = '.html.twig';

    /**
     * @param Twig_Environment      $twig
     * @param string                $defaultTemplate
     * @param array|string|int|null $templateProperty
     * @param array|string|int|null $targetProperty
     */
    public function __construct(
        Twig_Environment $twig,
        $defaultTemplate,
        $templateProperty = null,
        $targetProperty = null
    ) {
        $this->twig             = $twig;
        $this->defaultTemplate  = $defaultTemplate;
        $this->templateProperty = $templateProperty;
        $this->targetProperty   = $targetProperty;
    }

    /**
     * @param string $fileExtension
     *
     * @return TwigConverter
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * @param mixed $item
     *
     * @return mixed
     */
    public function convert($item)
    {
        if (!$this->templateProperty || !$file = Vale::get($item, $this->templateProperty)) {
            $file = $this->defaultTemplate;
        }
        $template = $this->twig->loadTemplate($file.$this->fileExtension);
        $rendered = $template->render($item);

        if (!$this->targetProperty) {
            return $rendered;
        }
        return Vale::set($item, $this->targetProperty, $rendered);
    }
}
