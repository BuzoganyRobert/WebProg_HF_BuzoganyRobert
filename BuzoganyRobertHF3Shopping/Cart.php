<?php


class Cart
{
    /**
     * @var CartItem[]
     */
    private array $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    // TODO Generate getters and setters of properties

    /**
     * Add Product $product into cart. If product already exists inside cart
     * it must update quantity.
     * This must create CartItem and return CartItem from method
     * Bonus: $quantity must not become more than whatever
     * is $availableQuantity of the Product
     *
     * @param Product $product
     * @param int $quantity
     * @return CartItem
     */
    public function addProduct(Product $product, int $quantity): CartItem
    {
        $cartItem=null;

        foreach($this->items as $existsAlready)
        {
            if($existsAlready->getProduct()===$product)
            {
                $currentQuantity=$existsAlready->getQuantity();
                $availableQuantity=$product->getAvailableQuantity();
                $newQuantity=min($currentQuantity+$quantity,$availableQuantity);
                $existsAlready->setQuantity($newQuantity);
                $cartItem=$existsAlready;
                break;


            }

        }
        if(!$cartItem)
        {
            $availableQuantity=$product->getAvailableQuantity();
            $newQuantity=min($quantity,$availableQuantity);
            $cartItem=new CartItem($product,$newQuantity);
            $this->items[]=$cartItem;

        }
        return $cartItem;


    }

    /**
     * Remove product from cart
     *
     * @param Product $product
     */
    public function removeProduct(Product $product): void
    {
        //TODO Implement method
        foreach ($this->items as $key=>$cartItem)
        {
            if($cartItem->getProduct()===$product)
            {
                unset($this->items[$key]);
                return;
            }
        }

    }

    /**
     * This returns total number of products added in cart
     *
     * @return int
     */
    public function getTotalQuantity(): int
    {
        //TODO Implement method
        $count=0;
        foreach ($this->items as $cartItem)
        {
            $count+=$cartItem->getQuantity();
        }
        return $count;
    }

    /**
     * This returns total price of products added in cart
     *
     * @return float
     */
    public function getTotalSum(): float
    {
        //TODO Implement method
        $sum=0;
        foreach ($this->items as $cartItem)
        {
            $sum+=$cartItem->getProduct()->getPrice()*$cartItem->getQuantity();
        }
        return $sum;
    }

}