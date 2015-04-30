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
     * @var array
     */
    protected $properties = [];

    /**
     * @var string
     */
    protected $fileExtension = '.html.twig';

    /**
     * @param Twig_Environment      $twig
     * @param string                $defaultTemplate
     * @param array                 $properties
     */
    public function __construct(Twig_Environment $twig, $defaultTemplate, array $properties = []) {
        $this->twig             = $twig;
        $this->defaultTemplate  = $defaultTemplate;
        $this->properties       = $properties;
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
        $file     = $this->getFile($item);
        $template = $this->twig->loadTemplate($file.$this->fileExtension);
        $rendered = $template->render($this->getContext($item));

        if (empty($this->properties['target'])) {
            return $rendered;
        }
        return Vale::set($item, $this->properties['target'], $rendered);
    }

    /**
     * @param mixed $item
     *
     * @return array
     */
    protected function getContext($item)
    {
        if (empty($this->properties['context']) || !$context = Vale::get($item, $this->properties['context'])) {
            $context = $item;
        }
        if (is_object($context) && method_exists($context, 'toArray')) {
            $context = call_user_func([$context, 'toArray']);
        }

        return $context;
    }

    /**
     * @param mixed $item
     *
     * @return string
     */
    protected function getFile($item)
    {
        if (empty($this->properties['template']) || !$file = Vale::get($item, $this->properties['template'])) {
            $file = $this->defaultTemplate;
        }

        return $file;
    }
}
