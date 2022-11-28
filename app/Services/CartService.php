<?php
namespace App\Services;

use Illuminate\Session\SessionManager as Session;

class CartService
{
    const CART_KEY = 'cart';
    
    public function __construct(private Session $session){}
  

    public function all()
    {
        // Pegando a chave da sessão
        $items = $this->session->get(Self::CART_KEY);

        return !$items ? [] : $items;
    }

    public function add($item)
    {
        
        // Se o carrinho estiver na sessão
        if($this->session->get(Self::CART_KEY)) {

            // Mandando mensagem se o produto já existe no carrinho
            if($this->itemExistsInCart($item)) throw new \Exception("Produto já existe no carrinho!");

            // Pega o item singular e adiciona
            $this->session->push(Self::CART_KEY, [$item]);

        } else {
            // Senão estiver na sessão, pegue 'put'
            $this->session->put(Self::CART_KEY, [$item]);
        }
    }

    public function remove($item)
    {
        $items = $this->session->get(Self::CART_KEY);

        $items = array_filter($items, function($line) use ($item){
            return $line['slug'] != $item;
        });

        // Sobreescrve a chave cart com o items
        $this->session->put(Self::CART_KEY, [$item]);
    }

    public function clear()
    {
        // Limpando todo carrinho da sessão
        $this->session->forget(Self::CART_KEY);
    }

    public function itemExistsInCart($item)
    {
        // Pegou os items da Sessão
        $items = $this->session->get(Self::CART_KEY);

        // Pegando somente os nomes da coluna slug de cada item
        $somethingSlugsInCart = array_column($items, 'slug');

        // Verifica se os slugs estão dentro do carrinho da sessão
        return in_array($item['slug'], $somethingSlugsInCart);

    }
}