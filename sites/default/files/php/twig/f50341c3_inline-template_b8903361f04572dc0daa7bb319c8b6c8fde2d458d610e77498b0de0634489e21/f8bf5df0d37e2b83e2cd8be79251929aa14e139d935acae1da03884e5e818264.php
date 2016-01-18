<?php

/* {# inline_template_start #}{% if status == 1 %}
{#<a href="#" rel-item={{ rid }} class="complete" rel-status="2">Hoàn thành</a>#}
<a href="#" rel-item={{ rid }} class="cancel" rel-status="3">Hủy</a>
{{ edit_node }}
{#
{% elseif status == 2 %}
<a href="#" rel-item={{ rid }} class="cancel" rel-status="3">Cancel</a>
{% else %}
<a href="#" rel-item={{ rid }} class="purchase" rel-status="1">Purchase</a>
<a href="#" rel-item={{ rid }} class="complete" rel-status="2">Complete</a>
#}
{% endif %} */
class __TwigTemplate_d072d9258e3a0f8becbc23d0d842a492318edf46394baf0105220836f07c57a5 extends Twig_Template
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
            // line 3
            echo "<a href=\"#\" rel-item=";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["rid"]) ? $context["rid"] : null), "html", null, true));
            echo " class=\"cancel\" rel-status=\"3\">Hủy</a>
";
            // line 4
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["edit_node"]) ? $context["edit_node"] : null), "html", null, true));
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}{% if status == 1 %}
{#<a href=\"#\" rel-item={{ rid }} class=\"complete\" rel-status=\"2\">Hoàn thành</a>#}
<a href=\"#\" rel-item={{ rid }} class=\"cancel\" rel-status=\"3\">Hủy</a>
{{ edit_node }}
{#
{% elseif status == 2 %}
<a href=\"#\" rel-item={{ rid }} class=\"cancel\" rel-status=\"3\">Cancel</a>
{% else %}
<a href=\"#\" rel-item={{ rid }} class=\"purchase\" rel-status=\"1\">Purchase</a>
<a href=\"#\" rel-item={{ rid }} class=\"complete\" rel-status=\"2\">Complete</a>
#}
{% endif %}";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 4,  56 => 3,  54 => 1,);
    }
}
/* {# inline_template_start #}{% if status == 1 %}*/
/* {#<a href="#" rel-item={{ rid }} class="complete" rel-status="2">Hoàn thành</a>#}*/
/* <a href="#" rel-item={{ rid }} class="cancel" rel-status="3">Hủy</a>*/
/* {{ edit_node }}*/
/* {#*/
/* {% elseif status == 2 %}*/
/* <a href="#" rel-item={{ rid }} class="cancel" rel-status="3">Cancel</a>*/
/* {% else %}*/
/* <a href="#" rel-item={{ rid }} class="purchase" rel-status="1">Purchase</a>*/
/* <a href="#" rel-item={{ rid }} class="complete" rel-status="2">Complete</a>*/
/* #}*/
/* {% endif %}*/
