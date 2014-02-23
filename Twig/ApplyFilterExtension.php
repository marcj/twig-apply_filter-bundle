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
        $twigStringLoader = new \Twig_Environment(new \Twig_Loader_String());
        $response = $twigStringLoader->render(
          sprintf('{{ %s|%s }}', key(compact('value')), $filters)
        );

        return $response;
    }
}
