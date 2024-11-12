<?php

class add_to_cart
{
    function addProduct($pid, $qty)
    {
        
        session_start();
        $_SESSION['cart'][$pid]['qty'] = $qty;
    }

    function updateProduct($pid, $qty)
    {
        session_start();
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['qty'] = $qty;
        }
    }

    function removeProduct($pid)
    {
        session_start();
        if (isset($_SESSION['cart'][$pid])) {
            unset($_SESSION['cart'][$pid]);
        }
    }

    function emptyProduct()
    {
        unset($_SESSION['cart']);
    }

    function totalProduct()
    {
        
        if (isset($_SESSION['cart'])) {
            return count($_SESSION['cart']);
        } else {
            return 0;
        }

    }

}
