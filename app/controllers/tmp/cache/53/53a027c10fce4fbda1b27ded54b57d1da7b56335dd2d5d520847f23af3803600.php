<?php

/* users/users.html */
class __TwigTemplate_060c850a1f33e29ba252d663709a71ce4c79f0cbb37a88f4e71b45393df5d163 extends Twig_Template
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
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

    <link rel=\"stylesheet\" href=\"/css/reset.css\"> <!-- CSS reset -->
    <link rel=\"stylesheet\" href=\"/css/style.css\"> <!-- Resource style -->
    <script src=\"/js/modernizr.js\"></script> <!-- Modernizr -->
    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\">
    <title>Test</title>
</head>
<body>
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-lg-12\">
            <div>
                <h1 style=\"display: inline-block; width: 90%;\" >Добро пожаловать, ";
        // line 20
        echo twig_escape_filter($this->env, ($context["user"] ?? null), "html", null, true);
        echo ".</h1>
                <button type=\"button\" class=\"btn btn-dark btn-lg\"><a href=\"/logout.php\">Выйти</a></button>
            </div>

            <div class=\"row\" style=\"padding: 10px;\">
                <div class=\"col-lg-9\">
                    <form method=\"POST\" action=\"\" class=\"form-inline\">
                        <div class=\"form-row align-items-center\">
                            <input type=\"text\" name=\"login\" placeholder=\"Login\" value=\"\" class=\"form-control\">
                            <input type=\"text\" name=\"password\" placeholder=\"password\" value=\"\" class=\"form-control\">
                            <input type=\"text\" name=\"email\" placeholder=\"e-mail\" value=\"\" class=\"form-control\">
                            <input type=\"text\" size=\"50\" name=\"fio\" placeholder=\"First and last name\" value=\"\" class=\"form-control\">
                            <input type=\"hidden\" name=\"user_id\" value=\"<?= \$_SESSION['user_id']?>\">
                            <input type=\"hidden\" name=\"user_id_creater\" value=\"<?= \$_SESSION['user_id']?>\">
                            <button type=\"submit\" name=\"action\" value=\"add\" class=\"btn btn-success\">Добавить администратора</button><br>
                        </div>
                    </form>
                    ";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["errors"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
            // line 38
            echo "                    <div class=\"alert alert-danger\">";
            echo twig_escape_filter($this->env, $context["error"], "html", null, true);
            echo "</div>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "                </div>
                <div class=\"col-lg-8\">
                    <form method=\"POST\" class=\"form-inline\">
                        <div class=\"form-group\">
                            <label for=\"sort\">Сортировать по:</label>
                            <select name=\"sort_by\" id=\"sort\" class=\"form-control\">

                                <option selected disabled>Выберите тип сортировки</option>
                                <option value=\"fio\">ФИО</option>
                                <option value=\"login\">Login</option>
                                <option value=\"date_created\">Дате добавления</option>
                            </select>
                        </div>
                        <div class=\"form-group\">
                            <input type=\"submit\" name=\"sort\" value=\"Отсортировать\" class=\"btn btn-default\">
                        </div>
                    </form>
                </div>
            </div>

            <table class=\"table table-hover table-striped m-t-xl\">
                <thead>
                <tr>
                    <th>Login</th>
                    <th>Password</th>
                    <th>E-mail</th>
                    <th>First and Last name</th>
                    <th>Date creation</th>
                    <th>Who create</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    ";
        // line 74
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["users"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
            // line 75
            echo "                    <form method=\"POST\" action=\"\" class=\"form-inline\">
                        <td>";
            // line 76
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "login", array()), "html", null, true);
            echo "</td>
                        <td>
                            <?php
                                if (!empty(\$_GET) && \$_GET['action'] == 'change' && \$_GET['user_id'] == \$user['user_id']) {
                            ?>
                            <input type=\"hidden\" name=\"user_id\" value=\"<?= \$user['user_id'] ?>\">
                            <input type=\"text\" size=\"30\" name=\"action\" placeholder=\"new password\" value=\"\" class=\"form-control\">
                            <?php
                                }
                                else {
                            ?>
                            ";
            // line 87
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "password", array()), "html", null, true);
            echo "
                        </td>
                        <td>";
            // line 89
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "email", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 90
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "fio", array()), "html", null, true);
            echo "</td>
                        <td>";
            // line 91
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["user"], "date_added", array()), "html", null, true);
            echo "</td>
                        
                        ";
            // line 93
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["userMaker"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["maker"]) {
                // line 94
                echo "                        <td>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["maker"], "login", array()), "html", null, true);
                echo "</td>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['maker'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 96
            echo "                        <td>
                            <?php
                                    if (!empty(\$_GET) && \$_GET['action'] == 'change' && \$_GET['user_id'] == \$user['user_id'] ) {
                                ?>
                            <button type=\"submit\" name=\"action\" value=\"update\" class=\"btn btn-success\">Сохранить</button>
                            <?php
                                    }
                                    else {
                                ?>
                            <button type=\"submit\" class=\"btn btn-success\">
                                <a style=\"text-decoration: none; color: white;\" href=\"?user_id=<?= \$user['user_id'] ?>&action=change\">Изменить пароль</a>
                            </button>
                            <button type=\"submit\" class=\"btn btn-danger\">
                                <a style=\"text-decoration: none; color: white;\" href=\"?user_id=<?= \$user['user_id'] ?>&action=delete\">Удалить</a>
                            </button>
                        </td>
                    </form>
                </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 115
        echo "
                </tbody>
            </table>

            <button type=\"button\" class=\"btn btn-success btn-lg\"><a href=\"main_admin.php\">Назад</a></button>

        </div>
    </div>
</div>


</body>
</html>";
    }

    public function getTemplateName()
    {
        return "users/users.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  189 => 115,  165 => 96,  156 => 94,  152 => 93,  147 => 91,  143 => 90,  139 => 89,  134 => 87,  120 => 76,  117 => 75,  113 => 74,  77 => 40,  68 => 38,  64 => 37,  44 => 20,  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "users/users.html", "C:\\xampp\\htdocs\\NETOLOGY\\Diplom_twig\\app\\views\\users\\users.html");
    }
}
