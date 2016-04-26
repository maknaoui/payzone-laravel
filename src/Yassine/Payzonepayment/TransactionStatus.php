<?php
namespace Maknaoui\PayzoneLaravel;

/**
 *
 * Represent the status of a transaction returned by the payment page
 *
 * @author jsh <jsh@payxpert.com>
 *
 */
class TransactionStatus {
  /**
   * Status of the transaction: "Authorized", "Not authorized", "Expired", "Call failed" or "Not processed"
   * @var String
   */
  private $status;

  /**
   * The merchant token of this transaction
   * @var String
   */
  private $merchantToken;

  /**
   * Transaction ID of this transaction.
   * @var Int
   */
  private $transactionID;

  /**
   * ID of the subscription this transaction is part of (if any).
   * @var Int
   */
  private $subscriptionID;

  /**
   * Type of payment for that transaction: CreditCard or ToditoCash
   * @var String
   */
  private $paymentType;

  /**
   * Result code of the transaction returned by the Payment Gateway
   * @var Int
   */
  private $errorCode;

  /**
   * Error message corresponding to the error code
   * @var String
   */
  private $errorMessage;

  /**
   * Statement descriptor returned by the Payment Gateway
   * @var unknown_type
   */
  private $statementDescriptor;

  /**
   * The order ID of the transaction.
   * @var String
   */
  private $orderID;

  /**
   * Currency for the transaction.
   * @var String
   */
  private $currency;

  /**
   * Amount of the transaction in cents (1.00€ => 100)
   * @var Int
   */
  private $amount;

  /**
   * Name provided by the shopper
   * @var String
   */
  private $shopperName;

  /**
   * Address provided by the shopper
   * @var String
   */
  private $shopperAddress;

  /**
   * Zipcode provided by the shopper.
   * @var String
   */
  private $shopperZipcode;

  /**
   * City provided by the shopper.
   * @var String
   */
  private $shopperCity;

  /**
   * State provided by the shopper
   * @var String
   */
  private $shopperState;

  /**
   * Country provided by the shopper.
   * @var String
   */
  private $shopperCountryCode;

  /**
   * Phone provided by the shopper
   * @var String
   */
  private $shopperPhone;

  /**
   * Email address provided by the shopper.
   * @var String
   */
  private $shopperEmail;

  /**
   * IP address of the shopper
   * @var String
   */
  private $shopperIPAddress;

  /**
   * In the case of a CreditCard transaction, the card holder name provided by the shopper.
   * @var String
   */
  private $cardHolderName;

  /**
   * Custom data provided by merchant at transaction creation.
   * @var String
   */
  private $ctrlCustomData;

  public function getStatus() {
    return $this->status;
  }

  public function setStatus($status) {
    $this->status = $status;
    return $this;
  }

  public function getMerchantToken() {
    return $this->merchantToken;
  }

  public function setMerchantToken($merchantToken) {
    $this->merchantToken = $merchantToken;
    return $this;
  }

  public function getTransactionID() {
    return $this->transactionID;
  }

  public function setTransactionID($transactionID) {
    $this->transactionID = $transactionID;
    return $this;
  }

  public function getSubscriptionID() {
    return $this->subscriptionID;
  }

  public function setSubscriptionID($subscriptionID) {
    $this->subscriptionID = $subscriptionID;
    return $this;
  }

  public function getPaymentType() {
    return $this->paymentType;
  }

  public function setPaymentType($paymentType) {
    $this->paymentType = $paymentType;
    return $this;
  }

  public function getErrorCode() {
    return $this->errorCode;
  }

  public function setErrorCode($errorCode) {
    $this->errorCode = $errorCode;
    return $this;
  }

  public function getErrorMessage() {
    return $this->errorMessage;
  }

  public function setErrorMessage($errorMessage) {
    $this->errorMessage = $errorMessage;
    return $this;
  }

  public function getStatementDescriptor() {
    return $this->statementDescriptor;
  }

  public function setStatementDescriptor($statementDescriptor) {
    $this->statementDescriptor = $statementDescriptor;
    return $this;
  }

  public function getOrderID() {
    return $this->orderID;
  }

  public function setOrderID($orderID) {
    $this->orderID = $orderID;
    return $this;
  }

  public function getCurrency() {
    return $this->currency;
  }

  public function setCurrency($currency) {
    $this->currency = $currency;
    return $this;
  }

  public function getAmount() {
    return $this->amount;
  }

  public function setAmount($amount) {
    $this->amount = $amount;
    return $this;
  }

  public function getShopperName() {
    return $this->shopperName;
  }

  public function setShopperName($shopperName) {
    $this->shopperName = $shopperName;
    return $this;
  }

  public function getShopperAddress() {
    return $this->shopperAddress;
  }

  public function setShopperAddress($shopperAddress) {
    $this->shopperAddress = $shopperAddress;
    return $this;
  }

  public function getShopperZipcode() {
    return $this->shopperZipcode;
  }

  public function setShopperZipcode($shopperZipcode) {
    $this->shopperZipcode = $shopperZipcode;
    return $this;
  }

  public function getShopperCity() {
    return $this->shopperCity;
  }

  public function setShopperCity($shopperCity) {
    $this->shopperCity = $shopperCity;
    return $this;
  }

  public function getShopperState() {
    return $this->shopperState;
  }

  public function setShopperState($shopperState) {
    $this->shopperState = $shopperState;
    return $this;
  }

  public function getShopperCountryCode() {
    return $this->shopperCountryCode;
  }

  public function setShopperCountryCode($shopperCountryCode) {
    $this->shopperCountryCode = $shopperCountryCode;
    return $this;
  }

  public function getShopperPhone() {
    return $this->shopperPhone;
  }

  public function setShopperPhone($shopperPhone) {
    $this->shopperPhone = $shopperPhone;
    return $this;
  }

  public function getShopperEmail() {
    return $this->shopperEmail;
  }

  public function setShopperEmail($shopperEmail) {
    $this->shopperEmail = $shopperEmail;
    return $this;
  }

  public function getShopperIPAddress() {
    return $this->shopperIPAddress;
  }

  public function setShopperIPAddress($shopperIPAddress) {
    $this->shopperIPAddress = $shopperIPAddress;
    return $this;
  }

  public function getCardHolderName() {
    return $this->cardHolderName;
  }

  public function setCardHolderName($cardHolderName) {
    $this->cardHolderName = $cardHolderName;
    return $this;
  }

  public function getCtrlCustomData() {
    return $this->ctrlCustomData;
  }

  public function setCtrlCustomData($ctrlCustomData) {
    $this->ctrlCustomData = $ctrlCustomData;
    return $this;
  }
}

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