<?php

/* {# inline_template_start #}{{ edit_user }}
<a href="#" user-id="{{ uid }}" class="btn-create-invoice">Tạo đơn hàng</a> */
class __TwigTemplate_9fc90316a9e9bd91d650535349807a2d4d06676381dabd3bd761c2b4249ad40a extends Twig_Template
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
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["edit_user"]) ? $context["edit_user"] : null), "html", null, true));
        echo "
<a href=\"#\" user-id=\"";
        // line 2
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["uid"]) ? $context["uid"] : null), "html", null, true));
        echo "\" class=\"btn-create-invoice\">Tạo đơn hàng</a>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}{{ edit_user }}
<a href=\"#\" user-id=\"{{ uid }}\" class=\"btn-create-invoice\">Tạo đơn hàng</a>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 2,  44 => 1,);
    }
}
/* {# inline_template_start #}{{ edit_user }}*/
/* <a href="#" user-id="{{ uid }}" class="btn-create-invoice">Tạo đơn hàng</a>*/
