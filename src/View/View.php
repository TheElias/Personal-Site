<?php 
namespace Site\View;


class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data);

        include TEMPLATE_PATH . '/partials/header.php';
        include TEMPLATE_PATH . '/' . $template . '.php';
        include TEMPLATE_PATH . '/partials/footer.php';
    }
}

?>