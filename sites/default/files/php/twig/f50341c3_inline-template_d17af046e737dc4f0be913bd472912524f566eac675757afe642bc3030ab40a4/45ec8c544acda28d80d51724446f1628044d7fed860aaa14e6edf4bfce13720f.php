<?php

/* {# inline_template_start #}<a href="{{ field_image_links }}" target="_blank" rel-item="{{ rid }}"><img src="{{ field_image_links }}" width="180" height="180" /></a> */
class __TwigTemplate_0da7d3f4b90edc484db38a5beb63b227dc1c498de99ce51e37d815a61f8ea775 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array();
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array(),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setTemplateFile($this->getTemplateName());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 1
        echo "<a href=\"";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_image_links"]) ? $context["field_image_links"] : null), "html", null, true));
        echo "\" target=\"_blank\" rel-item=\"";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["rid"]) ? $context["rid"] : null), "html", null, true));
        echo "\"><img src=\"";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["field_image_links"]) ? $context["field_image_links"] : null), "html", null, true));
        echo "\" width=\"180\" height=\"180\" /></a>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<a href=\"{{ field_image_links }}\" target=\"_blank\" rel-item=\"{{ rid }}\"><img src=\"{{ field_image_links }}\" width=\"180\" height=\"180\" /></a>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }
}
/* {# inline_template_start #}<a href="{{ field_image_links }}" target="_blank" rel-item="{{ rid }}"><img src="{{ field_image_links }}" width="180" height="180" /></a>*/
