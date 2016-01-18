<?php

/* modules/profit_statistics/templates/profit-statistics.html.twig */
class __TwigTemplate_95974f1a480291e032dadfe5607479b19a29a6a34b6093f74894171cd1b38256 extends Twig_Template
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
        $tags = array("trans" => 4);
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('trans'),
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
        echo "<div class=\"profit-statistics-container\">
    <div class=\"form\">
        <div class=\"date-from-container\">
            <label for=\"date-from-profit-statistics\">";
        // line 4
        echo t("Date from", array());
        echo "</label>
            <input type=\"text\" class=\"date-from\" id=\"date-from-profit-statistics\" />
        </div>
        <div class=\"date-to-container\">
            <label for=\"date-to-profit-statistics\">";
        // line 8
        echo t("Date to", array());
        echo "</label>
            <input type=\"text\" class=\"date-to\" id=\"date-to-profit-statistics\" />
        </div>
        <div class=\"btn-container\">
            <input type=\"button\" class=\"btn-get-statistics\" value=\"";
        // line 12
        echo t("Get statistics", array());
        echo "\" />
            <input type=\"button\" class=\"btn-get-full-statistics\" value=\"";
        // line 13
        echo t("Get full statistics", array());
        echo "\" />
        </div>
    </div>
    <div class=\"result\">
        <div class=\"user\">
            <span class=\"label\">";
        // line 18
        echo t("Total users", array());
        echo "</span>
            <span class=\"data\">0</span>
        </div>
        <div class=\"receipt\">
            <span class=\"label\">";
        // line 22
        echo t("Receipt", array());
        echo "</span>
            <span class=\"data\">0</span>
        </div>
        <div class=\"cost\">
            <span class=\"label\">";
        // line 26
        echo t("Cost", array());
        echo "</span>
            <span class=\"data\">0</span>
        </div>
        <div class=\"expenditure\">
            <span class=\"label\">";
        // line 30
        echo t("Expenditure", array());
        echo "</span>
            <span class=\"data\">0</span>
        </div>
        <div class=\"profit\">
            <span class=\"label\">";
        // line 34
        echo t("Profit", array());
        echo "</span>
            <span class=\"data\">0</span>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "modules/profit_statistics/templates/profit-statistics.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 34,  95 => 30,  88 => 26,  81 => 22,  74 => 18,  66 => 13,  62 => 12,  55 => 8,  48 => 4,  43 => 1,);
    }
}
/* <div class="profit-statistics-container">*/
/*     <div class="form">*/
/*         <div class="date-from-container">*/
/*             <label for="date-from-profit-statistics">{% trans %}Date from{% endtrans %}</label>*/
/*             <input type="text" class="date-from" id="date-from-profit-statistics" />*/
/*         </div>*/
/*         <div class="date-to-container">*/
/*             <label for="date-to-profit-statistics">{% trans %}Date to{% endtrans %}</label>*/
/*             <input type="text" class="date-to" id="date-to-profit-statistics" />*/
/*         </div>*/
/*         <div class="btn-container">*/
/*             <input type="button" class="btn-get-statistics" value="{% trans %}Get statistics{% endtrans %}" />*/
/*             <input type="button" class="btn-get-full-statistics" value="{% trans %}Get full statistics{% endtrans %}" />*/
/*         </div>*/
/*     </div>*/
/*     <div class="result">*/
/*         <div class="user">*/
/*             <span class="label">{% trans %}Total users{% endtrans %}</span>*/
/*             <span class="data">0</span>*/
/*         </div>*/
/*         <div class="receipt">*/
/*             <span class="label">{% trans %}Receipt{% endtrans %}</span>*/
/*             <span class="data">0</span>*/
/*         </div>*/
/*         <div class="cost">*/
/*             <span class="label">{% trans %}Cost{% endtrans %}</span>*/
/*             <span class="data">0</span>*/
/*         </div>*/
/*         <div class="expenditure">*/
/*             <span class="label">{% trans %}Expenditure{% endtrans %}</span>*/
/*             <span class="data">0</span>*/
/*         </div>*/
/*         <div class="profit">*/
/*             <span class="label">{% trans %}Profit{% endtrans %}</span>*/
/*             <span class="data">0</span>*/
/*         </div>*/
/*     </div>*/
/* </div>*/
