<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    public function __construct(private RequestStack $requestStack)
    {
        
    }

    /*
    * add()
    * Fonction permettant l'ajout d'un produit au panier
    */

    public function add($product)
    {
        
        //appeler la session de symfony
       // $session = $this->requestStack->getSession();
        $cart = $this->requestStack->getSession()->get('cart');

        //ajouter une quantity +1 à mon produit
        if(isset($cart[$product->getId()])) {
            $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        } else {
           $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => 1
            ];

        }
        //créer ma session Cart
        $this->requestStack->getSession()->set('cart', $cart);
        
    }


    /*
    * decrease()
    * Fonction permettant la suppression d'une quantite d'un produit au panier
    */
    public function decrease($id)
    {
        $cart = $this->requestStack->getSession()->get('cart');
        
        if($cart[$id]['qty'] > 1){
            $cart[$id]['qty'] = $cart[$id]['qty'] -1;
        }else{
            unset($cart[$id]);
        }

        $this->requestStack->getSession()->set('cart', $cart);
    }

    /*
    * fullQuantity()
    * Fonction retournant le nombre total des produits au panier
    */
    public function fullQuantity()
    {

        $cart = $this->requestStack->getSession()->get('cart');
        $quantity = 0;

        if(!isset($cart)) {
            return $quantity;
        }

        foreach ( $cart as $product) {
            
            $quantity = $quantity + $product['qty'];
        }
        
        return $quantity;
    }

    /*
    * getTotalWt()
    * Fonction retournant le prix total des produits au panier
    */
    public function getTotalWt()
    {
        $cart = $this->requestStack->getSession()->get('cart');
        $price = 0;

        if(!isset($cart)) {
            return $price;
        }

        foreach ( $cart as $product) {
            
            $price = $price + ($product['objet']->getPriceWt() * $product['qty']);
        }
        return $price;
    }

    /*
    * getCart()
    * Fonction retournant le panier
    */
    public function getCart()
    {
        return $this->requestStack->getSession()->get('cart');
    }
}



