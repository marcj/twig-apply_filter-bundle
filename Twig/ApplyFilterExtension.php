<?php

namespace MJS\TwigApplyFilter\Twig;

use Symfony\Component\Filesystem\Filesystem;

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
        $fs = new Filesystem();

        //set the needed path
        if (!$env->getCache()) {
            throw new \UnexpectedValueException('twig cache is not configured');
        }
        $template_dir_path = $env->getCache().'/apply_filter';
        $template_file_name = $filters.'.html.twig';
        $template_path = $template_dir_path.'/'.$template_file_name;

        //create dir for templates in twig cache
        if(!$fs->exists($template_dir_path))
            $fs->mkdir($template_dir_path);

        if(!$fs->exists($template_path))
        {
            //write the new template if first call
            $template = sprintf('{{ value|%s }}', $filters);
            file_put_contents($template_path,$template);
        }

        //store the old loader (not sure that is necessary)
        $old_loader = $env->getLoader();

        //use file loader
        $loader = new \Twig_Loader_Filesystem($template_dir_path);
        $env->setLoader($loader);

        $rendered = $env->render($template_file_name,array("value" => $value));

        //reload the previous loader
        $env->setLoader($old_loader);

        return $rendered;
    }
}
