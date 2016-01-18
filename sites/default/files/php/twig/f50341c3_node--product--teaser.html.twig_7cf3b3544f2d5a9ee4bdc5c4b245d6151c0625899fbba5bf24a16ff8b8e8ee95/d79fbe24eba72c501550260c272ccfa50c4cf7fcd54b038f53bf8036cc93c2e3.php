<?php

/* themes/ecommerce/templates/node--product--teaser.html.twig */
class __TwigTemplate_959243962620f0612af320635e31ae1c092eb6ba8b0b65aa28f961222716af38 extends Twig_Template
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
        $tags = array("set" => 63, "if" => 77, "trans" => 87);
        $filters = array("clean_class" => 65);
        $functions = array("attach_library" => 73);

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if', 'trans'),
                array('clean_class'),
                array('attach_library')
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

        // line 63
        $context["classes"] = array(0 => "node", 1 => ("node--type-" . \Drupal\Component\Utility\Html::getClass($this->getAttribute(        // line 65
(isset($context["node"]) ? $context["node"] : null), "bundle", array()))), 2 => (($this->getAttribute(        // line 66
(isset($context["node"]) ? $context["node"] : null), "isPromoted", array(), "method")) ? ("node--promoted") : ("")), 3 => (($this->getAttribute(        // line 67
(isset($context["node"]) ? $context["node"] : null), "isSticky", array(), "method")) ? ("node--sticky") : ("")), 4 => (( !$this->getAttribute(        // line 68
(isset($context["node"]) ? $context["node"] : null), "isPublished", array(), "method")) ? ("node--unpublished") : ("")), 5 => ((        // line 69
(isset($context["view_mode"]) ? $context["view_mode"] : null)) ? (("node--view-mode-" . \Drupal\Component\Utility\Html::getClass((isset($context["view_mode"]) ? $context["view_mode"] : null)))) : ("")), 6 => "clearfix");
        // line 73
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->env->getExtension('drupal_core')->attachLibrary("classy/node"), "html", null, true));
        echo "
<article";
        // line 74
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => (isset($context["classes"]) ? $context["classes"] : null)), "method"), "html", null, true));
        echo ">
  <header>
    ";
        // line 76
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_prefix"]) ? $context["title_prefix"] : null), "html", null, true));
        echo "
    ";
        // line 77
        if ( !(isset($context["page"]) ? $context["page"] : null)) {
            // line 78
            echo "      <h2";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["title_attributes"]) ? $context["title_attributes"] : null), "addClass", array(0 => "node__title"), "method"), "html", null, true));
            echo ">
        <a href=\"";
            // line 79
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true));
            echo "\" rel=\"bookmark\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true));
            echo "</a>
      </h2>
    ";
        }
        // line 82
        echo "    ";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_suffix"]) ? $context["title_suffix"] : null), "html", null, true));
        echo "
    ";
        // line 83
        if ((isset($context["display_submitted"]) ? $context["display_submitted"] : null)) {
            // line 84
            echo "      <div class=\"node__meta\">
        ";
            // line 85
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["author_picture"]) ? $context["author_picture"] : null), "html", null, true));
            echo "
        <span";
            // line 86
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["author_attributes"]) ? $context["author_attributes"] : null), "html", null, true));
            echo ">
          ";
            // line 87
            echo t("Submitted by @author_name on @date", array("@author_name" => (isset($context["author_name"]) ? $context["author_name"] : null), "@date" => (isset($context["date"]) ? $context["date"] : null), ));
            // line 88
            echo "        </span>
        ";
            // line 89
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["metadata"]) ? $context["metadata"] : null), "html", null, true));
            echo "
      </div>
    ";
        }
        // line 92
        echo "  </header>
  <div";
        // line 93
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content_attributes"]) ? $context["content_attributes"] : null), "addClass", array(0 => "node__content", 1 => "clearfix"), "method"), "html", null, true));
        echo ">
    ";
        // line 94
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["content"]) ? $context["content"] : null), "html", null, true));
        echo "
    <div class=\"buying-container\">
      <input type=\"hidden\" value=\"";
        // line 96
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["product_id"]) ? $context["product_id"] : null), "html", null, true));
        echo "\" class=\"product-id\" />
      <input type=\"hidden\" value=\"";
        // line 97
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["price"]) ? $context["price"] : null), "html", null, true));
        echo "\" class=\"price\" />
      <div class=\"quantity-outer-wrapper\">
        ";
        // line 99
        if (((isset($context["quantity"]) ? $context["quantity"] : null) > 1)) {
            // line 100
            echo "          <div class=\"quantity-wrapper\">
            <input type=\"hidden\" value=\"";
            // line 101
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["quantity"]) ? $context["quantity"] : null), "html", null, true));
            echo "\" class=\"max-quantity\" />
            <input type=\"text\" value=\"1\" class=\"quantity\" />
            <a href=\"#\" class=\"quantity-add\">Add</a>
            <a href=\"#\" class=\"quantity-sub\">Sub</a>
          </div>
        ";
        } else {
            // line 107
            echo "          <input type=\"hidden\" value=\"1\" class=\"quantity\" />
        ";
        }
        // line 109
        echo "        ";
        if (((isset($context["quantity"]) ? $context["quantity"] : null) > 0)) {
            // line 110
            echo "          <input type=\"button\" class=\"button-buy-now\" value=\"";
            echo t("Buy now", array());
            echo "\" />
        ";
        }
        // line 112
        echo "      </div>
      <div class=\"not-login-message hidden\">
        <a href=\"";
        // line 114
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["base_path"]) ? $context["base_path"] : null), "html", null, true));
        echo "customer/register?destination=";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["node_url"]) ? $context["node_url"] : null), "html", null, true));
        echo "\">
          <input type=\"button\" class=\"register\" value=\"";
        // line 115
        echo t("Register", array());
        echo "\" />
        </a>
        ";
        // line 117
        echo t("or", array());
        // line 118
        echo "        <a href=\"";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["base_path"]) ? $context["base_path"] : null), "html", null, true));
        echo "customer/login?destination=";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["node_url"]) ? $context["node_url"] : null), "html", null, true));
        echo "\">
          <input type=\"button\" class=\"login\" value=\"";
        // line 119
        echo t("Log in", array());
        echo "\" />
        </a>
        ";
        // line 121
        echo t("to buy now", array());
        // line 122
        echo "      </div>
    </div>
  </div>
</article>
";
    }

    public function getTemplateName()
    {
        return "themes/ecommerce/templates/node--product--teaser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  186 => 122,  184 => 121,  179 => 119,  172 => 118,  170 => 117,  165 => 115,  159 => 114,  155 => 112,  149 => 110,  146 => 109,  142 => 107,  133 => 101,  130 => 100,  128 => 99,  123 => 97,  119 => 96,  114 => 94,  110 => 93,  107 => 92,  101 => 89,  98 => 88,  96 => 87,  92 => 86,  88 => 85,  85 => 84,  83 => 83,  78 => 82,  70 => 79,  65 => 78,  63 => 77,  59 => 76,  54 => 74,  50 => 73,  48 => 69,  47 => 68,  46 => 67,  45 => 66,  44 => 65,  43 => 63,);
    }
}
/* {#*/
/* /***/
/*  * @file*/
/*  * Bartik's theme implementation to display a node.*/
/*  **/
/*  * Available variables:*/
/*  * - node: The node entity with limited access to object properties and methods.*/
/*      Only "getter" methods (method names starting with "get", "has", or "is")*/
/*      and a few common methods such as "id" and "label" are available. Calling*/
/*      other methods (such as node.delete) will result in an exception.*/
/*  * - label: The title of the node.*/
/*  * - content: All node items. Use {{ content }} to print them all,*/
/*  *   or print a subset such as {{ content.field_example }}. Use*/
/*  *   {{ content|without('field_example') }} to temporarily suppress the printing*/
/*  *   of a given child element.*/
/*  * - author_picture: The node author user entity, rendered using the "compact"*/
/*  *   view mode.*/
/*  * - metadata: Metadata for this node.*/
/*  * - date: Themed creation date field.*/
/*  * - author_name: Themed author name field.*/
/*  * - url: Direct URL of the current node.*/
/*  * - display_submitted: Whether submission information should be displayed.*/
/*  * - attributes: HTML attributes for the containing element.*/
/*  *   The attributes.class element may contain one or more of the following*/
/*  *   classes:*/
/*  *   - node: The current template type (also known as a "theming hook").*/
/*  *   - node--type-[type]: The current node type. For example, if the node is an*/
/*  *     "Article" it would result in "node--type-article". Note that the machine*/
/*  *     name will often be in a short form of the human readable label.*/
/*  *   - node--view-mode-[view_mode]: The View Mode of the node; for example, a*/
/*  *     teaser would result in: "node--view-mode-teaser", and*/
/*  *     full: "node--view-mode-full".*/
/*  *   The following are controlled through the node publishing options.*/
/*  *   - node--promoted: Appears on nodes promoted to the front page.*/
/*  *   - node--sticky: Appears on nodes ordered above other non-sticky nodes in*/
/*  *     teaser listings.*/
/*  *   - node--unpublished: Appears on unpublished nodes visible only to site*/
/*  *     admins.*/
/*  * - title_attributes: Same as attributes, except applied to the main title*/
/*  *   tag that appears in the template.*/
/*  * - content_attributes: Same as attributes, except applied to the main*/
/*  *   content tag that appears in the template.*/
/*  * - author_attributes: Same as attributes, except applied to the author of*/
/*  *   the node tag that appears in the template.*/
/*  * - title_prefix: Additional output populated by modules, intended to be*/
/*  *   displayed in front of the main title tag that appears in the template.*/
/*  * - title_suffix: Additional output populated by modules, intended to be*/
/*  *   displayed after the main title tag that appears in the template.*/
/*  * - view_mode: View mode; for example, "teaser" or "full".*/
/*  * - teaser: Flag for the teaser state. Will be true if view_mode is 'teaser'.*/
/*  * - page: Flag for the full page state. Will be true if view_mode is 'full'.*/
/*  * - readmore: Flag for more state. Will be true if the teaser content of the*/
/*  *   node cannot hold the main body content.*/
/*  * - logged_in: Flag for authenticated user status. Will be true when the*/
/*  *   current user is a logged-in member.*/
/*  * - is_admin: Flag for admin user status. Will be true when the current user*/
/*  *   is an administrator.*/
/*  **/
/*  * @see template_preprocess_node()*/
/*  *//* */
/* #}*/
/* {%*/
/*   set classes = [*/
/*     'node',*/
/*     'node--type-' ~ node.bundle|clean_class,*/
/*     node.isPromoted() ? 'node--promoted',*/
/*     node.isSticky() ? 'node--sticky',*/
/*     not node.isPublished() ? 'node--unpublished',*/
/*     view_mode ? 'node--view-mode-' ~ view_mode|clean_class,*/
/*     'clearfix',*/
/*   ]*/
/* %}*/
/* {{ attach_library('classy/node') }}*/
/* <article{{ attributes.addClass(classes) }}>*/
/*   <header>*/
/*     {{ title_prefix }}*/
/*     {% if not page %}*/
/*       <h2{{ title_attributes.addClass('node__title') }}>*/
/*         <a href="{{ url }}" rel="bookmark">{{ label }}</a>*/
/*       </h2>*/
/*     {% endif %}*/
/*     {{ title_suffix }}*/
/*     {% if display_submitted %}*/
/*       <div class="node__meta">*/
/*         {{ author_picture }}*/
/*         <span{{ author_attributes }}>*/
/*           {% trans %}Submitted by {{ author_name }} on {{ date }}{% endtrans %}*/
/*         </span>*/
/*         {{ metadata }}*/
/*       </div>*/
/*     {% endif %}*/
/*   </header>*/
/*   <div{{ content_attributes.addClass('node__content', 'clearfix') }}>*/
/*     {{ content }}*/
/*     <div class="buying-container">*/
/*       <input type="hidden" value="{{ product_id }}" class="product-id" />*/
/*       <input type="hidden" value="{{ price }}" class="price" />*/
/*       <div class="quantity-outer-wrapper">*/
/*         {% if quantity > 1 %}*/
/*           <div class="quantity-wrapper">*/
/*             <input type="hidden" value="{{ quantity }}" class="max-quantity" />*/
/*             <input type="text" value="1" class="quantity" />*/
/*             <a href="#" class="quantity-add">Add</a>*/
/*             <a href="#" class="quantity-sub">Sub</a>*/
/*           </div>*/
/*         {% else %}*/
/*           <input type="hidden" value="1" class="quantity" />*/
/*         {% endif %}*/
/*         {% if quantity > 0 %}*/
/*           <input type="button" class="button-buy-now" value="{% trans %}Buy now{% endtrans %}" />*/
/*         {% endif %}*/
/*       </div>*/
/*       <div class="not-login-message hidden">*/
/*         <a href="{{ base_path }}customer/register?destination={{ node_url }}">*/
/*           <input type="button" class="register" value="{% trans %}Register{% endtrans %}" />*/
/*         </a>*/
/*         {% trans %} or {% endtrans %}*/
/*         <a href="{{ base_path }}customer/login?destination={{ node_url }}">*/
/*           <input type="button" class="login" value="{% trans %}Log in{% endtrans %}" />*/
/*         </a>*/
/*         {% trans %} to buy now{% endtrans %}*/
/*       </div>*/
/*     </div>*/
/*   </div>*/
/* </article>*/
/* */
