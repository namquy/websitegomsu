<?php

/* {# inline_template_start #}{% if status == 1 %}
<a href="#" rel-item={{ rid }} rel-status="3">Hủy</a>
{% endif %} */
class __TwigTemplate_93b93d1ff8f9f768baaa5d74c783c0857c262c07c63b076859f172fbfb7415b9 extends Twig_Template
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
        $tags = array("if" => 1);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('if'),
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
        if (((isset($context["status"]) ? $context["status"] : null) == 1)) {
            // line 2
            echo "<a href=\"#\" rel-item=";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["rid"]) ? $context["rid"] : null), "html", null, true));
            echo " rel-status=\"3\">Hủy</a>
";
        }
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}{% if status == 1 %}
<a href=\"#\" rel-item={{ rid }} rel-status=\"3\">Hủy</a>
{% endif %}";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 2,  45 => 1,);
    }
}
/* {# inline_template_start #}{% if status == 1 %}*/
/* <a href="#" rel-item={{ rid }} rel-status="3">Hủy</a>*/
/* {% endif %}*/
