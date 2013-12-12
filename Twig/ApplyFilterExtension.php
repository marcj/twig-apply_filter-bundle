<?php

namespace MJS\TwigApplyFilter\Twig;

class ApplyFilterExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'apply_filter';
    }

    public function getFilters()
    {
        return array(
            'apply_filter' =>
                new \Twig_SimpleFilter(
                    'apply_filter',
                    array($this, 'applyFilter'),
                    array(
                        'needs_environment' => true,
                        'needs_context' => true,
                    )
                )
        );
    }

    public function applyFilter(\Twig_Environment $env, $context = array(), $value, $filters)
    {
        $name = 'apply_filter_' . md5($filters);

        $template = sprintf('{{ %s|%s }}', $name, $filters);
        $template = $env->loadTemplate($template);

        $context[$name] = $value;

        return $template->render($context);
    }

}