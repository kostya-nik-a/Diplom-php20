<?php

/* auth.html */
class __TwigTemplate_ba36efdfc45dfbf9606474eb0f7842b325556ee83638ce230e8f22c7e8fc7558 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"ru\">
<head>
    <meta charset=\"UTF-8\">
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
    <title>Авторизация</title>
</head>
<body>
<section id=\"login\">
    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-xs-12\">
                <div class=\"form-wrap\">
                    <h1>Авторизация</h1>
                    ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 16
            echo "                        <div class=\"alert alert-danger\">";
            echo twig_escape_filter($this->env, $context["error"], "html", null, true);
            echo "</div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "                    <form method=\"POST\">
                        <div class=\"form-group\">
                            <label for=\"lg\" class=\"sr-only\">Логин</label>
                            <input type=\"text\" placeholder=\"Логин\" name=\"user[login]\" id=\"lg\" class=\"form-control\">
                        </div>
                        <div class=\"form-group\">
                            <label for=\"key\" class=\"sr-only\">Пароль</label>
                            <input type=\"password\"  placeholder=\"Пароль\" name=\"user[password]\" id=\"key\" class=\"form-control\">
                        </div>
                        <button type=\"submit\" name= \"action\" id=\"btn-login\" class=\"btn btn-custom btn-lg btn-block\" value=\"auth\">Войти</button>
                        <button type=\"submit\" name= \"action\" id=\"btn-registration\" class=\"btn btn-custom btn-lg btn-block\" value=\"register\">Регистрация</button>
                    </form>
                    <hr>
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
</body>
</html>";
    }

    public function getTemplateName()
    {
        return "auth.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 18,  43 => 16,  39 => 15,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "auth.html", "C:\\xampp\\htdocs\\NETOLOGY\\Diplom_twig\\views\\auth.html");
    }
}
