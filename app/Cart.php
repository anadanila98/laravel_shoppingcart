<?php

namespace App;

class Cart
{
    public $items = null;  //grup de produse
    public $totalQty = 0;
    public $totalPrice = 0;
    
    //acest Cart se va recrea de fiecare data cand il accesez, cand adaug items sau cand iau items/le afisez
    //practic trebuie sa ii dam cartul vechi pe baza caruia creem cartul nou
    //folosesc acest approach pentru a avea mereu starea potrivita si corecta a acestui cart
    
    public function __construct($oldCart)
    {
        //daca deja avem un cart vechi existent
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice; 
        }
        
        //else a new cart is created
    }
    
    public function add($item, $id) {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];  //creaza un nou item cu 3 campuri
        //un array asociat
        //pregatesc un array pentru itemul adaugat 
        //util pentru a-l adauga in grupul meu $items
        //suprascriem mereu item pt ca vrem sa fie adaugat doar o data
        //verificam daca itemul adaugat exista deja in cartul nostru, daca da vom incrementa cantitatea si pretul
        //daca nu, il adaugam
        
        if ($this->items) {
            if(array_key_exists($id, $this->items)) {
                //transmitem id-ul cautat si lista in care cautam
                //daca deja avem produsul adaugat in cos atunci $storedItem va avea acea valoare, altfel va fi adaugat un nou produs
                //ne asiguram astfel ca nu exista duplicate
                
                $storedItem = $this->items[$id];
            }
        }
        $storedItem['qty']++; //incrementez cantitatea
        $storedItem['price'] = $item->price * $storedItem['qty']; //multiplic pretul
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->price;
          
    }
    
    public function reduceByOne($id) {
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['price'];
        
        if ($this->items[$id]['qty'] <= 0) { 
            //daca cantitatea noastra e mai mica sau egala cu 0 vom scoate de tot produsul din cos folosind o functie Laravel numita unset()
            
            unset($this->items[$id]);      
        }
    }
    
    public function increaseByOne($id) {
        $this->items[$id]['qty']++;
        $this->items[$id]['price'] += $this->items[$id]['item']['price'];
        $this->totalQty++;
        $this->totalPrice += $this->items[$id]['item']['price'];
    }
    
    public function removeItem($id) {
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }
    
    public function removeAll() {
        $this->totalQty = 0;
        $this->totalPrice = 0;
        unset($this->items);
    }
    
}
