<?php

/* modules/purchase/templates/create-multiple-products.html.twig */
class __TwigTemplate_eda1f64523cb8b209790cd9814029b7ed1f2aa65d57e4a5a870cf48d004876de extends Twig_Template
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
        echo "<div class=\"products-container create-multiple-products\">
    <div class=\"error-message\"></div>
    <div class=\"header\">
        <input type=\"button\" class=\"btn-add-row\" value=\"";
        // line 4
        echo t("Add row", array());
        echo "\" />
        <input type=\"button\" class=\"btn-save\" value=\"";
        // line 5
        echo t("Save", array());
        echo "\" />
    </div>
    <table>
        <thead>
            <tr>
                <th>";
        // line 10
        echo t("Image Link", array());
        echo "</th>
                <th>";
        // line 11
        echo t("Customer", array());
        echo "</th>
                <th>";
        // line 12
        echo t("Quantity", array());
        echo "</th>
                <th>";
        // line 13
        echo t("Price", array());
        echo "</th>
                <th>";
        // line 14
        echo t("Note", array());
        echo "</th>
                <th>";
        // line 15
        echo t("Action", array());
        echo "</th>
            </tr>
        </thead>
        <tbody>
            <tr style=\"display: none;\" class=\"origin-row\">
                <td>
                    <input type=\"text\" class=\"image-link\" placeholder=\"";
        // line 21
        echo t("Image Link", array());
        echo "\" />
                </td>
                <td>
                    <input type=\"text\" class=\"customer-autocomplete\" placeholder=\"";
        // line 24
        echo t("Customer", array());
        echo "\" />
                    <input type=\"hidden\" class=\"customer\" />
                </td>
                <td>
                    <input type=\"text\" type=\"number\" min=\"1\" class=\"quantity\" value=\"1\" placeholder=\"";
        // line 28
        echo t("Quantity", array());
        echo "\" />
                </td>
                <td>
                    <input type=\"text\" type=\"number\" min=\"0\" class=\"price\" placeholder=\"";
        // line 31
        echo t("Price", array());
        echo "\" />
                </td>
                <td>
                    <input type=\"text\" class=\"note\" placeholder=\"";
        // line 34
        echo t("Note", array());
        echo "\" />
                </td>
                <td>
                    <input type=\"button\" class=\"btn-remove-row\" value=\"";
        // line 37
        echo t("Remove", array());
        echo "\" />
                </td>
            </tr>
        </tbody>
    </table>
    <div class=\"footer\">
        <input type=\"button\" class=\"btn-add-row\" value=\"";
        // line 43
        echo t("Add row", array());
        echo "\" />
        <input type=\"button\" class=\"btn-save\" value=\"";
        // line 44
        echo t("Save", array());
        echo "\" />
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "modules/purchase/templates/create-multiple-products.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 44,  129 => 43,  120 => 37,  114 => 34,  108 => 31,  102 => 28,  95 => 24,  89 => 21,  80 => 15,  76 => 14,  72 => 13,  68 => 12,  64 => 11,  60 => 10,  52 => 5,  48 => 4,  43 => 1,);
    }
}
/* <div class="products-container create-multiple-products">*/
/*     <div class="error-message"></div>*/
/*     <div class="header">*/
/*         <input type="button" class="btn-add-row" value="{% trans %}Add row{% endtrans %}" />*/
/*         <input type="button" class="btn-save" value="{% trans %}Save{% endtrans %}" />*/
/*     </div>*/
/*     <table>*/
/*         <thead>*/
/*             <tr>*/
/*                 <th>{% trans %}Image Link{% endtrans %}</th>*/
/*                 <th>{% trans %}Customer{% endtrans %}</th>*/
/*                 <th>{% trans %}Quantity{% endtrans %}</th>*/
/*                 <th>{% trans %}Price{% endtrans %}</th>*/
/*                 <th>{% trans %}Note{% endtrans %}</th>*/
/*                 <th>{% trans %}Action{% endtrans %}</th>*/
/*             </tr>*/
/*         </thead>*/
/*         <tbody>*/
/*             <tr style="display: none;" class="origin-row">*/
/*                 <td>*/
/*                     <input type="text" class="image-link" placeholder="{% trans %}Image Link{% endtrans %}" />*/
/*                 </td>*/
/*                 <td>*/
/*                     <input type="text" class="customer-autocomplete" placeholder="{% trans %}Customer{% endtrans %}" />*/
/*                     <input type="hidden" class="customer" />*/
/*                 </td>*/
/*                 <td>*/
/*                     <input type="text" type="number" min="1" class="quantity" value="1" placeholder="{% trans %}Quantity{% endtrans %}" />*/
/*                 </td>*/
/*                 <td>*/
/*                     <input type="text" type="number" min="0" class="price" placeholder="{% trans %}Price{% endtrans %}" />*/
/*                 </td>*/
/*                 <td>*/
/*                     <input type="text" class="note" placeholder="{% trans %}Note{% endtrans %}" />*/
/*                 </td>*/
/*                 <td>*/
/*                     <input type="button" class="btn-remove-row" value="{% trans %}Remove{% endtrans %}" />*/
/*                 </td>*/
/*             </tr>*/
/*         </tbody>*/
/*     </table>*/
/*     <div class="footer">*/
/*         <input type="button" class="btn-add-row" value="{% trans %}Add row{% endtrans %}" />*/
/*         <input type="button" class="btn-save" value="{% trans %}Save{% endtrans %}" />*/
/*     </div>*/
/* </div>*/
