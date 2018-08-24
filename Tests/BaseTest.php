<?php

namespace MJS\TwigApplyFilter\Tests;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTests
     */
    public function testBase($template, $output){

        $twig = new \Twig_Environment(new \Twig_Loader_String(), array('cache' => false, 'autoescape' => false));
        $twig->setCache(sys_get_temp_dir());
        $twig->addExtension(new \MJS\TwigApplyFilter\Twig\ApplyFilterExtension());

        $template = $twig->loadTemplate($template);
        $actual = $template->render(array('foo' => 'bar'));
        $this->assertEquals($output, $actual);
    }

    public function getTests()
    {
        return array(
            array("{{ 'a'|json_encode }}", '"a"'),
            array("{{ foo|json_encode }}", '"bar"'),
            array("{{ foo|upper|json_encode }}", '"BAR"'),

            array("{{ 'a'|apply_filter('json_encode')}}", '"a"'),
            array("{{ foo|apply_filter('json_encode') }}", '"bar"'),
            array("{{ foo|apply_filter('upper|json_encode') }}", '"BAR"'),

            array("{{ foo|apply_filter('upper|json_encode|lower') }}", '"bar"'),

            array("{{ ''|apply_filter('default(\'bar\')') }}", 'bar'),
            array("{{ ''|apply_filter('default(\'bar\')|json_encode') }}", '"bar"'),
            array("{{ foo|apply_filter('default(\'bar\')|json_encode') }}", '"bar"'),

        );
    }
}
