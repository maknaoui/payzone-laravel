<?php
namespace Maknaoui\PayzoneLaravel;

class CartProduct {
  // Fields are public otherwise json_encode can't see them...
  public $cartProductId;
  public $cartProductName;
  public $cartProductUnitPrice;
  public $cartProductQuantity;
  public $cartProductBrand;
  public $cartProductMPN;
  public $cartProductCategoryName;
  public $cartProductCategoryID;

  public function getCartProductId() {
    return $this->cartProductId;
  }

  public function setCartProductId($cartProductId) {
    $this->cartProductId = $cartProductId;
    return $this;
  }

  public function getCartProductName() {
    return $this->cartProductName;
  }

  public function setCartProductName($cartProductName) {
    $this->cartProductName = $cartProductName;
    return $this;
  }

  public function getCartProductUnitPrice() {
    return $this->cartProductUnitPrice;
  }

  public function setCartProductUnitPrice($cartProductUnitPrice) {
    $this->cartProductUnitPrice = $cartProductUnitPrice;
    return $this;
  }

  public function getCartProductQuantity() {
    return $this->cartProductQuantity;
  }

  public function setCartProductQuantity($cartProductQuantity) {
    $this->cartProductQuantity = $cartProductQuantity;
    return $this;
  }

  public function getCartProductBrand() {
    return $this->cartProductBrand;
  }

  public function setCartProductBrand($cartProductBrand) {
    $this->cartProductBrand = $cartProductBrand;
    return $this;
  }

  public function getCartProductMPN() {
    return $this->cartProductMPN;
  }

  public function setCartProductMPN($cartProductMPN) {
    $this->cartProductMPN = $cartProductMPN;
    return $this;
  }

  public function getCartProductCategoryName() {
    return $this->cartProductCategoryName;
  }

  public function setCartProductCategoryName($cartProductCategoryName) {
    $this->cartProductCategoryName = $cartProductCategoryName;
    return $this;
  }

  public function getCartProductCategoryID() {
    return $this->cartProductCategoryID;
  }

  public function setCartProductCategoryID($cartProductCategoryID) {
    $this->cartProductCategoryID = $cartProductCategoryID;
    return $this;
  }
}