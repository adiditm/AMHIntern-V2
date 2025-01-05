<?php

/* display/export/format_dropdown.twig */
class __TwigTemplate_22f671d5fa443b525a20122f6021e85c1bfd2ab287f8947458576aef90786615 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<div class=\"exportoptions\" id=\"format\">
    <h3>";
        // line 2
        echo _gettext("Format:");
        echo "</h3>
    ";
        // line 3
        echo (isset($context["dropdown"]) ? $context["dropdown"] : null);
        echo "
</div>
";
    }

    public function getTemplateName()
    {
        return "display/export/format_dropdown.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 3,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "display/export/format_dropdown.twig", "/home/amhw8583/public_html/intern/pxx/templates/display/export/format_dropdown.twig");
    }
}
