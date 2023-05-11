<?php

namespace config;

use controllers\ProductsController;
use Exception;

class Routing
{
    public function get()
    {
        // On essaie le bloc de code qui suit
        try {
            // Si il y a une valeur pour controller dans l'url alors ..
            if (isset($_GET['controller'])) {
                // On se protège des injections de code
                $url = htmlspecialchars($_GET['controller']); // Ex pour : https://pj/users/post
                // On répartit l'url dans un tableau à l'aide de la méthode explode
                $newUrl = explode("/", $url); // [user, post]
                $controllerName = "controllers\\" . ucfirst($newUrl[0] . "Controller"); // UsersController
                // Si il y a une deuxième valeur dans l'url alors ..
                if (isset($newUrl[1])) {
                    $methodName = strtolower($newUrl[1]); // post
                    $controller = new $controllerName(); // new UsersController.php
                    // Autoload
                    $controller->$methodName(); // $controller->post();
                } else {
                    // S'il manque un paramètre, la page n'existe pas, on renvois une erreur qui sera récupérée dans le bloc catch
                    throw new Exception("Erreur 404");
                }
            } // S'il n'y a pas de valeur pour controller, alors on affiche la page d'accueil
            else {
                $admin = new ProductsController();
                $admin->index();
            }
        } // Si il y une erreur quelque part, on la récupère dans le bloc catch
        catch (Exception $e) {
            // On récupére le message d'erreur pour le stocker dans $errorMessage
            $errorMessage = $e->getMessage();
            // On affiche l'erreur sur la page d'erreur
            // A FAIRE!!!!
            require('views/error.phtml');
        }
    }
}