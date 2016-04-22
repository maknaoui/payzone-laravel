<?php
namespace Yassine\Payzonepayment;

use Yassine\Payzonepayment\C2PValidate;

class Connect2PayClient {
  /**
   * Payment types constants
   */
  const _PAYMENT_TYPE_CREDITCARD = "CreditCard";
  const _PAYMENT_TYPE_TODITOCASH = "ToditoCash";

  /**
   * Payment modes constants
   */
  const _PAYMENT_MODE_SINGLE = "Single";
  const _PAYMENT_MODE_ONSHIPPING = "OnShipping";
  const _PAYMENT_MODE_RECURRENT = "Recurrent";
  const _PAYMENT_MODE_INSTALMENTS = "InstalmentsPayments";

  /**
   * Shipping types constants
   */
  const _SHIPPING_TYPE_PHYSICAL = "Physical";
  const _SHIPPING_TYPE_ACCESS = "Access";
  const _SHIPPING_TYPE_VIRTUAL = "Virtual";

  /**
   * Subscription types constants
   */
  const _SUBSCRIPTION_TYPE_NORMAL = "normal";
  const _SUBSCRIPTION_TYPE_LIFETIME = "lifetime";
  const _SUBSCRIPTION_TYPE_ONETIME = "onetime";
  const _SUBSCRIPTION_TYPE_INFINITE = "infinite";

  /**
   * ~~~~
   * Subscription cancel reasons
   * ~~~~
   */
  /**
   * Bank denial
   */
  const _SUBSCRIPTION_CANCEL_BANK_DENIAL = 1000;
  /**
   * Canceled due to refund
   */
  const _SUBSCRIPTION_CANCEL_REFUNDED = 1001;
  /**
   * Canceled due to retrieval request
   */
  const _SUBSCRIPTION_CANCEL_RETRIEVAL = 1002;
  /**
   * Cancellation letter sent by bank
   */
  const _SUBSCRIPTION_CANCEL_BANK_LETTER = 1003;
  /**
   * Chargeback
   */
  const _SUBSCRIPTION_CANCEL_CHARGEBACK = 1004;
  /**
   * Company account closed
   */
  const _SUBSCRIPTION_CANCEL_COMPANY_ACCOUNT_CLOSED = 1005;
  /**
   * Site account closed
   */
  const _SUBSCRIPTION_CANCEL_WEBSITE_ACCOUNT_CLOSED = 1006;
  /**
   * Didn't like the site
   */
  const _SUBSCRIPTION_CANCEL_DID_NOT_LIKE = 1007;
  /**
   * Disagree ('Did not do it' or 'Do not recognize the transaction')
   */
  const _SUBSCRIPTION_CANCEL_DISAGREE = 1008;
  /**
   * Fraud from webmaster
   */
  const _SUBSCRIPTION_CANCEL_WEBMASTER_FRAUD = 1009;
  /**
   * I could not get in to the site
   */
  const _SUBSCRIPTION_CANCEL_COULD_NOT_GET_INTO = 1010;
  /**
   * No problem, just moving on
   */
  const _SUBSCRIPTION_CANCEL_NO_PROBLEM = 1011;
  /**
   * Not enough updates
   */
  const _SUBSCRIPTION_CANCEL_NOT_UPDATED = 1012;
  /**
   * Problems with the movies/videos
   */
  const _SUBSCRIPTION_CANCEL_TECH_PROBLEM = 1013;
  /**
   * Site was too slow
   */
  const _SUBSCRIPTION_CANCEL_TOO_SLOW = 1014;
  /**
   * The site did not work
   */
  const _SUBSCRIPTION_CANCEL_DID_NOT_WORK = 1015;
  /**
   * Too expensive
   */
  const _SUBSCRIPTION_CANCEL_TOO_EXPENSIVE = 1016;
  /**
   * Un-authorized signup by family member
   */
  const _SUBSCRIPTION_CANCEL_UNAUTH_FAMILLY = 1017;
  /**
   * Undetermined reasons
   */
  const _SUBSCRIPTION_CANCEL_UNDETERMINED = 1018;
  /**
   * Webmaster requested to cancel
   */
  const _SUBSCRIPTION_CANCEL_WEBMASTER_REQUESTED = 1019;
  /**
   * I haven't received my item
   */
  const _SUBSCRIPTION_CANCEL_NOTHING_RECEIVED = 1020;
  /**
   * The item was damaged or defective
   */
  const _SUBSCRIPTION_CANCEL_DAMAGED = 1021;
  /**
   * The box was empty
   */
  const _SUBSCRIPTION_CANCEL_EMPTY_BOX = 1022;
  /**
   * The order was incomplete
   */
  const _SUBSCRIPTION_CANCEL_INCOMPLETE_ORDER = 1023;

  /**
   * Field content constant
   */
  const _UNAVAILABLE = "NA";
  const _UNAVAILABLE_COUNTRY = "ZZ";

  private static $API_ROUTES = array(
    "TRANS_PREPARE" => "/transaction/prepare",
    "TRANS_STATUS" => "/transaction/:merchantToken/status",
    "TRANS_DOPAY" => "/transaction/:customerToken/dopay",
    "SUB_CANCEL" => "/subscription/:subscriptionID/cancel"
  );

  protected $fieldsRequired = array('orderID', 'currency', 'amount', 'customerIP',
      'shippingType', 'paymentMode', 'ctrlRedirectURL');

  protected $fieldsSize = array('afPassword' => 64,
      'currency' => 3, 'customerIP' => 15, 'ctrlRedirectURL' => 2048,
      'ctrlCallbackURL' => 2048, 'ctrlCustomData' => 2048);

  protected $fieldsValidate = array('afClientId' => 'isInt', 'afPassword' => 'isString', 'shopperID' => 'isInt',
      'shopperEmail' => 'isEmail', 'shipToCountryCode' => 'isCountryName', 'shopperCountryCode' => 'isCountryName',
      'orderID' => 'isString', 'orderDescription' => 'isString', 'currency' => 'isString',
      'amount' => 'isInt', 'orderTotalWithoutShipping' => 'isInt', 'orderShippingPrice' => 'isInt',
      'orderDiscount' => 'isInt', 'orderFOLanguage' => 'isString', 'shippingType' => 'isShippingType',
      'shippingName' => 'isString', 'paymentType' => 'isPayment', 'paymentMode' => 'isPaymentMode',
      'offerID' => 'isInt', 'subscriptionType' => 'isSubscriptionType', 'trialPeriod' => 'isString',
      'rebillAmount' => 'isInt', 'rebillPeriod' => 'isString', 'rebillMaxIteration' => 'isInt',
      'ctrlRedirectURL' => 'isAbsoluteUrl', 'ctrlCallbackURL' => 'isAbsoluteUrl',
      'themeID' => 'isInt');

  protected $fieldsJSON = array('afClientId','afPassword', 'apiVersion',
      'shopperID', 'shopperEmail', 'shipToFirstName', 'shipToLastName', 'shipToCompany',
      'shipToPhone', 'shipToAddress', 'shipToState',
      'shipToZipcode', 'shipToCity', 'shipToCountryCode',
      'shopperFirstName', 'shopperLastName', 'shopperPhone', 'shopperAddress',
      'shopperState', 'shopperZipcode', 'shopperCity', 'shopperCountryCode',
      'shopperCompany', 'shopperLoyaltyProgram', 'customerIP',
      'orderID', 'orderDescription', 'currency', 'amount', 'orderTotalWithoutShipping',
      'orderShippingPrice', 'orderDiscount', 'orderFOLanguage', 'orderCartContent',
      'shippingType', 'shippingName', 'paymentType', 'paymentMode', 'secure3d',
      'offerID', 'subscriptionType', 'trialPeriod', 'rebillAmount', 'rebillPeriod', 'rebillMaxIteration',
      'ctrlCustomData', 'ctrlRedirectURL', 'ctrlCallbackURL', 'themeID');

  private $apiVersion = "002";

  /**
   * URL of the connect2pay application
   * @var string
   */
  private $url;

  /**
   * Login for the connect2pay application
   * @var string
   */
  private $merchant;

  /**
   * Password for the connect2pay application
   * @var string
   */
  private $password;

  // ~~~~
  // Transaction related data
  // ~~~~
  // Authentication Fields
  /**
   * Client ID for the antifraud sytem
   * @var integer
   */
  private $afClientId;
  /**
   * Password for the antifraud system
   * @var string
   */
  private $afPassword;

  /**
   * Force the transaction to use Secure 3D
   * @var Boolean
   */
  private $secure3d;

  // Customer fields
  /**
   * Merchant unique customer numeric id
   * @var integer
   */
  private $shopperID;
  /**
   * Customer email address
   * @var string
   */
  private $shopperEmail;
  /**
   * Customer first name for shipping
   * @var string
   */
  private $shipToFirstName;
  /**
   * Customer last name for shipping
   * @var string
   */
  private $shipToLastName;
  /**
   * Customer company name for shipping
   * @var string
   */
  private $shipToCompany;
  /**
   * Customer phone for shipping ; if many, separate by ";"
   * @var string
   */
  private $shipToPhone;
  /**
   * Customer address for shipping
   * @var string
   */
  private $shipToAddress;
  /**
   * Customer state for shipping
   * @var string
   */
  private $shipToState;
  /**
   * Customer ZIP Code for shipping
   * @var string
   */
  private $shipToZipcode;
  /**
   * Customer city for shipping
   * @var string
   */
  private $shipToCity;
  /**
   * Customer country for shipping
   * @var string
   */
  private $shipToCountryCode;
  /**
   * Customer first name for invoicing
   * @var string
   */
  private $shopperFirstName;
  /**
   * Customer last name for invoicing
   * @var string
   */
  private $shopperLastName;
  /**
   * Customer phone for invoicing ; if many, separate by ";"
   * @var string
   */
  private $shopperPhone;
  /**
   * Customer address for invoicing
   * @var string
   */
  private $shopperAddress;
  /**
   * Customer state for invoicing
   * @var string
   */
  private $shopperState;
  /**
   * Customer ZIP Code for invoicing
   * @var string
   */
  private $shopperZipcode;
  /**
   * Customer city for invoicing
   * @var string
   */
  private $shopperCity;
  /**
   * Customer country for invoicing
   * @var string
   */
  private $shopperCountryCode;
  /**
   * Customer company name for invoicing
   * @var string
   */
  private $shopperCompany;
  /**
   * Customer Loyalty Program name
   * @var string
   */
  private $shopperLoyaltyProgram;

  // Order Fields
  /**
   * Merchant internal unique order ID
   * @var string
   */
  private $orderID;
  /**
   * Sum up of the order to display on the payment page
   * @var string
   */
  private $orderDescription;
  /**
   * Currency for the current order
   * @var string
   */
  private $currency;
  /**
   * The transaction amount in cents (for 1€ => 100)
   * @var integer
   */
  private $amount;
  /**
   * The transaction amount in cents, without shipping fee
   * @var integer
   */
  private $orderTotalWithoutShipping;
  /**
   * The shipping amount in cents (for 1€ => 100)
   * @var integer
   */
  private $orderShippingPrice;
  /**
   * The discount amount in cents (for 1€ => 100)
   * @var integer
   */
  private $orderDiscount;
  /**
   * The IP address of the customer
   * @var string
   */
  private $customerIP;
  /**
   * Language of the Front Office used to validate the order
   * @var string
   */
  private $orderFOLanguage;
  /**
   * Product or service bought - see details below
   * @var array[](integer CartProductId, string CartProductName, float CartProductUnitPrice,
   *            integer CartProductQuantity, string CartProductBrand, string CartProductMPN,
   *            string CartProductCategoryName, integer CartProductCategoryID)
   */
  private $orderCartContent;

  // Shipping Fields
  /**
   * Type can be either : Physical (for physical goods), Virtual (for dematerialized goods), Access (for protected content)
   * @var string
   */
  private $shippingType;
  /**
   * In case of Physical shipping type, name of the shipping company
   * @var string
   */
  private $shippingName;

  // Payment Detail Fields
  /**
   * Can be CreditCard (default) or ToditoCash. This will change the type of the payment page displayed.
   * @var string
   */
  private $paymentType;
  /**
   * Can be either : Single, OnShipping, Recurrent, InstalmentsPayments
   * @var string
   */
  private $paymentMode;
  /**
   * Predefined price point with initial and rebill period (for Recurrent, InstalmentsPayments payment types)
   * @var integer
   */
  private $offerID;
  /**
   * Type of subscription.
   * @var string
   */
  private $subscriptionType;
  /**
   * Number of days in the initial period (for Recurrent, InstalmentsPayments payment types)
   * @var integer
   */
  private $trialPeriod;
  /**
   * Number in minor unit, amount to be rebilled after the initial period (for Recurrent, InstalmentsPayments payment types)
   * @var integer
   */
  private $rebillAmount;
  /**
   * Number of days next re-billing transaction will be settled in (for Recurrent, InstalmentsPayments payment types)
   * @var integer
   */
  private $rebillPeriod;
  /**
   * Number of re-billing transactions that will be settled (for Recurrent, InstalmentsPayments payment types)
   * @var integer
   */
  private $rebillMaxIteration;

  // Template and Control Fields
  /**
   * The URL where to redirect the customer after the transaction processing
   * @var string
   */
  private $ctrlRedirectURL;
  /**
   * A URL that will be notified of the status of the transaction
   * @var string
   */
  private $ctrlCallbackURL;
  /**
   * Custom data that will be returned back with the status of the transaction
   * @var string
   */
  private $ctrlCustomData;
  /**
   * Select a predefined payment page template
   * @var integer
   */
  private $themeID;

  // Data returned from prepare call
  private $returnCode;
  private $returnMessage;
  private $merchantToken;
  private $customerToken;

  // Data returned from status call
  private $status;

  // Internal data
  private $clientErrorMessage;

  // HTTP Proxy data
  private $proxy_host = null;
  private $proxy_port = null;
  private $proxy_username = null;
  private $proxy_password = null;

  // Internal Currency Helper
  private $currencyHelper = null;

  // Path to the certificates file for SSL verification
  private $sslCAFile = null;

  private $extraCurlOptions = array();

  /**
   * Instantiate a new connect2pay client
   *
   * @param string $url The URL of the connect2pay application
   * @param string $merchant The login of the merchant on connect2pay
   * @param string $password The password of the merchant on connect2pay
   * @param array $data Data for the transaction to create (optional)
   */
  public function __construct($url, $merchant, $password, $data = null) {
    $this->url = preg_replace('/\/*$/', '', $url);
    $this->merchant = $merchant;
    $this->password = $password;

    if ($data != null && is_array($data)) {
      foreach ($data as $var => $value) {
        if (property_exists($this, $var)) {
          $this->$var = $value;
        }
      }
    }
  }

  /**
   * Set the parameter in the case of the use of an outgoing proxy
   *
   * @param string $host The proxy host.
   * @param int $port The proxy port.
   * @param string $username The proxy username.
   * @param string $password The proxy password.
   */
  public function useProxy($host, $port, $username = null, $password = null) {
    $this->proxy_host = $host;
    $this->proxy_port = $port;
    $this->proxy_username = $username;
    $this->proxy_password = $password;
  }


  /**
   * Force the validation of the Connect2Pay SSL certificate.
   *
   * @param string $certFilePath The path to the PEM file containing the certification chain.
   * If not set, defaults to "_current-dir_/ssl/connect2pay-signing-ca-cert.pem"
   */
  public function forceSSLValidation($certFilePath = null) {
    $this->sslCAFile = ($certFilePath != null) ? $certFilePath : dirname(__FILE__) . "/ssl/connect2pay-signing-ca-cert.pem";
  }

  /**
   * Add extra curl options
   */
  public function setExtraCurlOption($name, $value) {
    $this->extraCurlOptions[$name] = $value;
  }

  /**
   * Prepare a new transaction on connect2pay application.
   * This method will validate the transaction date and call
   * the connect2pay application to create a new transaction.
   * The fields returnCode, returnMessage, merchantToken and
   * customerToken will be populated according to the call result.
   *
   * @return boolean true if creation is successful, false otherwise
   */
  public function prepareTransaction() {
    if ($this->validate()) {
      $trans = array();

      if (isset($this->afClientId) && (! is_array($this->orderCartContent) || sizeof($this->orderCartContent) <= 0)) {
        $this->setDefaultOrderCartContent();
      }

      foreach($this->fieldsJSON as $fieldName) {
        if (is_array($this->{$fieldName}) || ! C2PValidate::isEmpty($this->{$fieldName})) {
          $trans[$fieldName] = $this->{"get" . ucfirst($fieldName)}();
        }
      }

      // Only PHP >= 5.4 has JSON_UNESCAPED_SLASHES option
      $post_data = str_replace('\\/', '/', json_encode($trans));
      $url = $this->url . Connect2PayClient::$API_ROUTES['TRANS_PREPARE'];

      $result = $this->doPost($url, $post_data);

      if ($result != null && is_array($result)) {
        $this->returnCode = $result["code"];
        $this->returnMessage = $result["message"];

        if ($this->returnCode == "200") {
          $this->merchantToken = $result["merchantToken"];
          $this->customerToken = $result["customerToken"];
          return true;
        } else {
          $this->clientErrorMessage = $this->returnMessage;
        }
      }
    } else {
      $this->clientErrorMessage = "The transaction is not valid.";
    }

    return false;
  }

  /**
   * Do a transaction status request on the connect2pay application.
   *
   * @param string $merchantToken The merchant token related to this transaction
   * @return The TransactionStatus object of the transaction or null on error
   */
  public function getTransactionStatus($merchantToken) {
    if ($merchantToken != null && strlen(trim($merchantToken)) > 0) {
      $url = $this->url . str_replace(":merchantToken", $merchantToken, Connect2PayClient::$API_ROUTES['TRANS_STATUS']);

      $result = $this->doGet($url, array(), false);

      if ($result != null && is_object($result)) {
        $this->initStatus($result);
        if (isset($this->status)) {
          return $this->status;
        }
      }
    }

    return null;
  }

  /**
   * Do a subscription cancellation.
   *
   * @param int $subscriptionID Identifier of the subscription to cancel
   * @param int $cancelReason Identifier of the cancelReason (see _SUBSCRIPTION_CANCEL_* constants)
   * @return The result code of the operation (200 for success) or null on failure
   */
  public function cancelSubscription($subscriptionID, $cancelReason) {
    if ($subscriptionID != null && is_numeric($subscriptionID) && isset($cancelReason) && is_numeric($cancelReason)) {
      $url = $this->url . str_replace(":subscriptionID", $subscriptionID, Connect2PayClient::$API_ROUTES['SUB_CANCEL']);
      $trans = array();
      $trans["apiVersion"] = $this->apiVersion;
      $trans["cancelReason"] = intval($cancelReason);

      $result = $this->doPost($url, json_encode($trans));

      if ($result != null && is_array($result)) {
        $this->clientErrorMessage = $result["message"];
        return $result["code"];
      }
    } else {
      $this->clientErrorMessage = "subscriptionID and cancelReason must be not null and numeric";
    }

    return null;
  }


  /**
   * Handle the callback done by the connect2pay application after
   * a transaction processing.
   * This will populate the status field that can be retrieved by calling getStatus().
   *
   * @return true on succes or false on error
   */
  public function handleCallbackStatus() {
    // Read the body of the request
    $body = @file_get_contents('php://input');

    if ($body != null && strlen(trim($body)) > 0) {
      $status = json_decode(trim($body), false);

      if ($status != null && is_object($status)) {
        $this->initStatus($status);
        return true;
      }
    }

    return false;
  }

  /**
   * Handle the data received by the POST done when connect2pay redirects
   * the customer to the merchant website.
   * This will populate the status field that can be retrieved by calling getStatus().
   *
   * @param string $encryptedData The content of the 'data' field posted
   * @param string $merchantToken The merchant token related to this transaction
   * @return boolean True on success or false on error
   */
  public function handleRedirectStatus($encryptedData, $merchantToken) {
    $key = $this->urlsafe_base64_decode($merchantToken);
    $binData = $this->urlsafe_base64_decode($encryptedData);

    // Decrypting
    $json = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $binData, MCRYPT_MODE_ECB);

    if ($json) {
      // Remove PKCS#5 padding
      $json = $this->pkcs5_unpad($json);
      $status = json_decode($json, false);

      if ($status != null && is_object($status)) {
        $this->initStatus($status);
        return true;
      }
    }

    return false;
  }

  /**
   * Returns the URL to redirect the customer to after a transaction
   * creation.
   *
   * @return string The URL to redirect the customer to.
   */
  public function getCustomerRedirectURL() {
    return $this->url . str_replace(":customerToken", $this->customerToken, Connect2PayClient::$API_ROUTES['TRANS_DOPAY']);
  }

  /**
   * Validate the current transaction data.
   *
   * @return boolean True if transaction data are valid, false otherwise
   */
  public function validate() {
    $arrErrors = array();

    $arrErrors = $this->validateFields();

    if (sizeof($arrErrors) > 0) {
      foreach ($arrErrors as $error) {
        $this->clientErrorMessage .= $error . " * ";
      }
      return false;
    }

    return true;
  }

  private function doGet($url, $params, $assoc = true) {
    return $this->doHTTPRequest("GET", $url, $params, $assoc);
  }

  private function doPost($url, $data, $assoc = true) {
    return $this->doHTTPRequest("POST", $url, $data, $assoc);
  }

  private function doHTTPRequest($type, $url, $data, $assoc = true) {
    $curl = curl_init();

    if ($type === "GET") {
      // In that case, $data is the array of params to add in the URL
      if (is_array($data) && count($data) > 0) {
        $urlParams = array();
        foreach ($data as $param => $value) {
          $urlParams[] = urlencode($param) . "=" . urlencode($value);
        }
        if (count($urlParams) > 0) {
          $url .= "?" . implode("&", $urlParams);
        }
      }
    } elseif ($type === "POST") {
      // In that case, $data is the body of the request
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    } else {
      $this->clientErrorMessage = "Bad HTTP method specified.";
      return null;
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, $this->merchant . ":" . $this->password);

    if ($this->sslCAFile != null) {
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($curl, CURLOPT_CAINFO, $this->sslCAFile);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    } else {
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    }

    if ($this->proxy_host != null && $this->proxy_port != null) {
      curl_setopt($curl, CURLOPT_PROXY, $this->proxy_host);
      curl_setopt($curl, CURLOPT_PROXYPORT, $this->proxy_port);

      if ($this->proxy_username != null && $this->proxy_password != null) {
        curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $this->proxy_username . ":" . $this->proxy_password);
      }
    }

    // Extra Curl Options
    foreach ($this->extraCurlOptions as $name => $value) {
      curl_setopt($curl, $name, $value);
    }

    $json = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpCode != 200) {
      $this->clientErrorMessage = "Received HTTP code " . $httpCode . " from connect2pay.";
    } else {
      if ($json !== false) {
        $result = json_decode($json, $assoc);

        if ($result != null) {
          return $result;
        } else {
          $this->clientErrorMessage = "JSON decoding error.";
        }
      } else {
        $this->clientErrorMessage = "Error requesting " . $connect2pay;
      }
    }

    return null;
  }

  private function initStatus($status) {
    if ($status != null && is_object($status)) {
      $this->status = new TransactionStatus();
      $reflector = new ReflectionClass('TransactionStatus');
      $properties = $reflector->getProperties();

      foreach ($properties as $property) {
        if (isset($status->{$property->getName()})) {
          $this->status->{"set" . ucfirst($property->getName())}($status->{$property->getName()});
        }
      }
    }
  }

  private function urlsafe_base64_decode($string) {
    return base64_decode(strtr($string, '-_', '+/'));
  }

  private function pkcs5_unpad($text) {
    $pad = ord($text{strlen($text)-1});
    if ($pad > strlen($text)) {
      // The initial text was empty
      return "";
    }

    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
      // The length of the padding sequence is incorrect
      return false;
    }

    return substr($text, 0, -1 * $pad);
  }

  public function getApiVersion() {
    return $this->apiVersion;
  }

  public function getURL() {
    return $this->url;
  }

  public function setURL($url) {
    $this->url = $url;
    return($this);
  }

  public function getMerchant() {
    return $this->merchant;
  }

  public function setMerchant($merchant) {
    $this->merchant = $merchant;
    return($this);
  }

  public function getPassword() {
    return $this->password;
  }

  public function setPassword($password) {
    $this->password = $password;
    return($this);
  }

  public function getAfClientId() {
      return $this->afClientId;
  }

  public function setAfClientId($afClientId) {
      $this->afClientId = (int)$afClientId;
      return($this);
  }

  public function getAfPassword() {
      return $this->afPassword;
  }

  public function setAfPassword($afPassword) {
      $this->afPassword = (string)$afPassword;
      return($this);
  }

  public function getSecure3d() {
      return $this->secure3d;
  }

  public function setSecure3d($secure3d) {
      $this->secure3d = $secure3d;
      return($this);
  }

  public function getShopperID() {
      return $this->shopperID;
  }

  public function setShopperID($shopperID) {
      $this->shopperID = (int)$shopperID;
      return($this);
  }

  public function getShopperEmail() {
      return $this->shopperEmail;
  }

  public function setShopperEmail($shopperEmail) {
      $this->shopperEmail = (strlen($shopperEmail) > 100) ? substr((string)$shopperEmail, 0, 100) : (string)$shopperEmail;
      return($this);
  }

  public function getShipToFirstName() {
      return $this->shipToFirstName;
  }

  public function setShipToFirstName($shipToFirstName) {
      $this->shipToFirstName = (strlen($shipToFirstName) > 35) ? substr((string)$shipToFirstName, 0, 35) : (string)$shipToFirstName;
      return($this);
  }

  public function getShipToLastName() {
      return $this->shipToLastName;
  }

  public function setShipToLastName($shipToLastName) {
      $this->shipToLastName = (strlen($shipToLastName) > 35) ? substr((string)$shipToLastName, 0, 35) : (string)$shipToLastName;
      return($this);
  }

  public function getShipToCompany() {
      return $this->shipToCompany;
  }

  public function setShipToCompany($shipToCompany) {
      $this->shipToCompany = (strlen($shipToCompany) > 128) ? substr((string)$shipToCompany, 0, 128) : (string)$shipToCompany;
      return($this);
  }

  public function getShipToPhone() {
      return $this->shipToPhone;
  }

  public function setShipToPhone($shipToPhone) {
      $this->shipToPhone = (strlen($shipToPhone) > 20) ? substr((string)$shipToPhone, 0, 20) : (string)$shipToPhone;
      return($this);
  }

  public function getShipToAddress() {
      return $this->shipToAddress;
  }

  public function setShipToAddress($shipToAddress) {
      $this->shipToAddress = (strlen($shipToAddress) > 255) ? substr((string)$shipToAddress, 0, 255) : (string)$shipToAddress;
      return($this);
  }

  public function getShipToState() {
      return $this->shipToState;
  }

  public function setShipToState($shipToState) {
      $this->shipToState = (strlen($shipToState) > 30) ? substr((string)$shipToState, 0, 30) : (string)$shipToState;
      return($this);
  }

  public function getShipToZipcode() {
      return $this->shipToZipcode;
  }

  public function setShipToZipcode($shipToZipcode) {
      $this->shipToZipcode = (strlen($shipToZipcode) > 10) ? substr((string)$shipToZipcode, 0, 10) : (string)$shipToZipcode;
      return($this);
  }

  public function getShipToCity() {
      return $this->shipToCity;
  }

  public function setShipToCity($shipToCity) {
      $this->shipToCity = (strlen($shipToCity) > 50) ? substr((string)$shipToCity, 0, 50) : (string)$shipToCity;
      return($this);
  }

  public function getShipToCountryCode() {
      return $this->shipToCountryCode;
  }

  public function setShipToCountryCode($shipToCountryCode) {
      $this->shipToCountryCode = (strlen($shipToCountryCode) > 2) ? substr((string)$shipToCountryCode, 0, 2) : (string)$shipToCountryCode;
      return($this);
  }

  public function getShopperFirstName() {
      return $this->shopperFirstName;
  }

  public function setShopperFirstName($shopperFirstName) {
      $this->shopperFirstName = (strlen($shopperFirstName) > 35) ? substr((string)$shopperFirstName, 0, 35) : (string)$shopperFirstName;
      return($this);
  }

  public function getShopperLastName() {
    return (!C2PValidate::isEmpty($this->shopperLastName)) ? $this->shopperLastName : Connect2PayClient::_UNAVAILABLE;
  }

  public function setShopperLastName($shopperLastName) {
      $this->shopperLastName = (strlen($shopperLastName) > 35) ? substr((string)$shopperLastName, 0, 35) : (string)$shopperLastName;
      return($this);
  }

  public function getShopperPhone() {
    return (!C2PValidate::isEmpty($this->shopperPhone)) ? $this->shopperPhone : Connect2PayClient::_UNAVAILABLE;
  }

  public function setShopperPhone($shopperPhone) {
      $this->shopperPhone = (strlen($shopperPhone) > 20) ? substr((string)$shopperPhone, 0, 20) : (string)$shopperPhone;
      return($this);
  }

  public function getShopperAddress() {
    return (!C2PValidate::isEmpty($this->shopperAddress)) ? $this->shopperAddress : Connect2PayClient::_UNAVAILABLE;
  }

  public function setShopperAddress($shopperAddress) {
      $this->shopperAddress = (strlen($shopperAddress) > 255) ? substr((string)$shopperAddress, 0, 255) : (string)$shopperAddress;
      return($this);
  }

  public function getShopperState() {
    return (!C2PValidate::isEmpty($this->shopperState)) ? $this->shopperState : Connect2PayClient::_UNAVAILABLE;
  }

  public function setShopperState($shopperState) {
      $this->shopperState = (strlen($shopperState) > 30) ? substr((string)$shopperState, 0, 30) : (string)$shopperState;
      return($this);
  }

  public function getShopperZipcode() {
    return (!C2PValidate::isEmpty($this->shopperZipcode)) ? $this->shopperZipcode : Connect2PayClient::_UNAVAILABLE;
  }

  public function setShopperZipcode($shopperZipcode) {
      $this->shopperZipcode = (strlen($shopperZipcode) > 10) ? substr((string)$shopperZipcode, 0, 10) : (string)$shopperZipcode;
      return($this);
  }

  public function getShopperCity() {
    return (!C2PValidate::isEmpty($this->shopperCity)) ? $this->shopperCity : Connect2PayClient::_UNAVAILABLE;
  }

  public function setShopperCity($shopperCity) {
      $this->shopperCity = (strlen($shopperCity) > 50) ? substr((string)$shopperCity, 0, 50) : (string)$shopperCity;
      return($this);
  }

  public function getShopperCountryCode() {
    return (!C2PValidate::isEmpty($this->shopperCountryCode)) ? $this->shopperCountryCode : Connect2PayClient::_UNAVAILABLE_COUNTRY;
  }

  public function setShopperCountryCode($shopperCountryCode) {
      $this->shopperCountryCode = (strlen($shopperCountryCode) > 2) ? substr((string)$shopperCountryCode, 0, 2) : (string)$shopperCountryCode;
      return($this);
  }

  public function getShopperCompany() {
      return $this->shopperCompany;
  }

  public function setShopperCompany($shopperCompany) {
      $this->shopperCompany = (strlen($shopperCompany) > 128) ? substr((string)$shopperCompany, 0, 128) : (string)$shopperCompany;
      return($this);
  }

  public function getShopperLoyaltyProgram() {
      return $this->shopperLoyaltyProgram;
  }

  public function setShopperLoyaltyProgram($shopperLoyaltyProgram) {
      $this->shopperLoyaltyProgram = (string)$shopperLoyaltyProgram;
      return($this);
  }

  public function getOrderID() {
      return $this->orderID;
  }

  public function setOrderID($orderID) {
      $this->orderID = (string)$orderID;
      return($this);
  }

  public function getOrderDescription() {
      return $this->orderDescription;
  }

  public function setOrderDescription($orderDescription) {
      $this->orderDescription = (string)$orderDescription;
      return($this);
  }

  public function getCurrency() {
      return $this->currency;
  }

  public function setCurrency($currency) {
      $this->currency = (string)$currency;
      return($this);
  }

  public function getAmount() {
      return $this->amount;
  }

  public function setAmount($amount) {
      $this->amount = (int)$amount;
      return($this);
  }

  public function getOrderTotalWithoutShipping() {
      return $this->orderTotalWithoutShipping;
  }

  public function setOrderTotalWithoutShipping($orderTotalWithoutShipping) {
      $this->orderTotalWithoutShipping = (int)$orderTotalWithoutShipping;
      return($this);
  }

  public function getOrderShippingPrice() {
      return $this->orderShippingPrice;
  }

  public function setOrderShippingPrice($orderShippingPrice) {
      $this->orderShippingPrice = (int)$orderShippingPrice;
      return($this);
  }

  public function getOrderDiscount() {
      return $this->orderDiscount;
  }

  public function setOrderDiscount($orderDiscount) {
      $this->orderDiscount = (int)$orderDiscount;
      return($this);
  }

  public function getCustomerIP() {
      return $this->customerIP;
  }

  public function setCustomerIP($customerIP) {
      $this->customerIP = (string)$customerIP;
      return($this);
  }

  public function getOrderFOLanguage() {
      return $this->orderFOLanguage;
  }

  public function setOrderFOLanguage($orderFOLanguage) {
      $this->orderFOLanguage = (string)$orderFOLanguage;
      return($this);
  }

  public function getOrderCartContent() {
      return $this->orderCartContent;
  }

  public function setOrderCartContent($orderCartContent) {
      $this->orderCartContent = $orderCartContent;
      return($this);
  }

  /**
   * Add a CartProduct in the orderCartContent.
   *
   * @param CartProduct $cartProduct The product to add to the cart
   * @return Connect2PayClient
   */
  public function addCartProduct($cartProduct) {
    if ($this->orderCartContent == null || !is_array($this->orderCartContent)) {
      $this->orderCartContent = array();
    }

    if ($cartProduct instanceof CartProduct) {
      $this->orderCartContent[] = $cartProduct;
    }

    return $this;
  }

  public function getShippingType() {
      return $this->shippingType;
  }

  public function setShippingType($shippingType) {
      $this->shippingType = (string)$shippingType;
      return($this);
  }

  public function getShippingName() {
      return $this->shippingName;
  }

  public function setShippingName($shippingName) {
      $this->shippingName = (string)$shippingName;
      return($this);
  }

  public function getPaymentType() {
    return (!C2PValidate::isEmpty($this->paymentType)) ? $this->paymentType : Connect2PayClient::_PAYMENT_TYPE_CREDITCARD;
  }

  public function setPaymentType($paymentType) {
      $this->paymentType = (string)$paymentType;
      return($this);
  }

  public function getPaymentMode() {
      return $this->paymentMode;
  }

  public function setPaymentMode($paymentMode) {
      $this->paymentMode = (string)$paymentMode;
      return($this);
  }

  public function getOfferID() {
      return $this->offerID;
  }

  public function setOfferID($offerID) {
      $this->offerID = (int)$offerID;
      return($this);
  }

  public function getSubscriptionType() {
      return $this->subscriptionType;
  }

  public function setSubscriptionType($subscriptionType) {
      $this->subscriptionType = $subscriptionType;
      return($this);
  }

  public function getTrialPeriod() {
      return $this->trialPeriod;
  }

  public function setTrialPeriod($trialPeriod) {
      $this->trialPeriod = $trialPeriod;
      return($this);
  }

  public function getRebillAmount() {
      return $this->rebillAmount;
  }

  public function setRebillAmount($rebillAmount) {
      $this->rebillAmount = (int)$rebillAmount;
      return($this);
  }

  public function getRebillPeriod() {
      return $this->rebillPeriod;
  }

  public function setRebillPeriod($rebillPeriod) {
      $this->rebillPeriod = $rebillPeriod;
      return($this);
  }

  public function getRebillMaxIteration() {
      return $this->rebillMaxIteration;
  }

  public function setRebillMaxIteration($rebillMaxIteration) {
      $this->rebillMaxIteration = (int)$rebillMaxIteration;
      return($this);
  }

  public function getCtrlRedirectURL() {
      return $this->ctrlRedirectURL;
  }

  public function setCtrlRedirectURL($ctrlRedirectURL) {
      $this->ctrlRedirectURL = (string)$ctrlRedirectURL;
      return($this);
  }

  public function getCtrlCallbackURL() {
      return $this->ctrlCallbackURL;
  }

  public function setCtrlCallbackURL($ctrlCallbackURL) {
      $this->ctrlCallbackURL = (string)$ctrlCallbackURL;
      return($this);
  }

  public function getCtrlCustomData() {
      return $this->ctrlCustomData;
  }

  public function setCtrlCustomData($ctrlCustomData) {
      $this->ctrlCustomData = (string)$ctrlCustomData;
      return($this);
  }

  public function getThemeID() {
      return $this->themeID;
  }

  public function setThemeID($themeID) {
      $this->themeID = (int)$themeID;
      return($this);
  }

  public function getReturnCode() {
    return $this->returnCode;
  }

  public function getReturnMessage() {
    return $this->returnMessage;
  }

  public function getMerchantToken() {
    return $this->merchantToken;
  }

  public function getCustomerToken() {
    return $this->customerToken;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getClientErrorMessage() {
    return $this->clientErrorMessage;
  }

  public function getCurrencyHelper() {
    if ($this->currencyHelper == null) {
      $this->currencyHelper = new Connect2PayCurrencyHelper();

      $this->currencyHelper->useProxy($this->proxy_host, $this->proxy_port, $this->proxy_password, $this->proxy_username);
    }

    return $this->currencyHelper;
  }

  private function setDefaultOrderCartContent() {
    $this->orderCartContent = array();
    $product = new CartProduct();
    $product->setCartProductId(0)->setCartProductName("NA");
    $product->setCartProductUnitPrice(0)->setCartProductQuantity(1);
    $product->setCartProductBrand("NA")->setCartProductMPN("NA");
    $product->setCartProductCategoryName("NA")->setCartProductCategoryID(0);

    $this->orderCartContent[] = $product;
  }

  /**
  * Check for fields validity
  * @return array empty if everything is OK or as many elements as errors matched
  */
  private function validateFields() {
    $fieldsRequired = $this->fieldsRequired;
    $returnError = array();

    foreach ($fieldsRequired as $field) {
      if (C2PValidate::isEmpty($this->{$field}) AND (!is_numeric($this->{$field})))
        $returnError[] = $field . ' is empty';
    }

    foreach ($this->fieldsSize as $field => $size) {
      if (isset($this->{$field}) AND C2PValidate::strlen($this->{$field}) > $size)
        $returnError[] = $field . ' Length ' . $size;
    }

    foreach ($this->fieldsValidate as $field => $method) {
      if (!C2PValidate::isEmpty($this->{$field}) AND !call_user_func(array('C2PValidate', $method), $this->{$field}))
        $returnError[] = $field . ' = ' . $this->{$field};
    }

    return $returnError;
  }
}

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

/**
 * Helper to manipulate amount in different currencies.
 * Permits to convert amount between different currencies
 * and get rates in real time from Yahoo Web service.
 *
 * @author Jérôme Schell <jsh@payxpert.com>
 * @copyright 2011 Payxpert
 *
 */
class Connect2PayCurrencyHelper {
  // The base address to fetch currency rates
  private static $YAHOO_SERVICE_URL = "http://download.finance.yahoo.com/d/quotes.csv";

  // Optional proxy to use for outgoing request
  private static $proxy_host = null;
  private static $proxy_port = null;
  private static $proxy_username = null;
  private static $proxy_password = null;

  private static $currencies = array(
  "AUD" => array("currency" => "Australian Dollar", "code" => "036", "symbol" => "$"),
  "CAD" => array("currency" => "Canadian Dollar", "code" => "124", "symbol" => "$"),
  "CHF" => array("currency" => "Swiss Franc", "code" => "756", "symbol" => "CHF"),
  "DKK" => array("currency" => "Danish Krone", "code" => "208", "symbol" => "kr"),
  "EUR" => array("currency" => "Euro", "code" => "978", "symbol" => "€"),
  "GBP" => array("currency" => "Pound Sterling", "code" => "826", "symbol" => "£"),
  "HKD" => array("currency" => "Hong Kong Dollar", "code" => "344", "symbol" => "$"),
  "JPY" => array("currency" => "Yen", "code" => "392", "symbol" => "¥"),
  "MXN" => array("currency" => "Mexican Peso", "code" => "484", "symbol" => "$"),
  "NOK" => array("currency" => "Norwegian Krone", "code" => "578", "symbol" => "kr"),
  "SEK" => array("currency" => "Swedish Krona", "code" => "752", "symbol" => "kr"),
  "USD" => array("currency" => "US Dollar", "code" => "840", "symbol" => "$"),
  );

  /**
   * Set the parameter in the case of the use of an outgoing proxy
   *
   * @param string $host The proxy host.
   * @param int $port The proxy port.
   * @param string $username The proxy username.
   * @param string $password The proxy password.
   */
  public static function useProxy($host, $port, $username = null, $password = null) {
    Connect2PayCurrencyHelper::$proxy_host = $host;
    Connect2PayCurrencyHelper::$proxy_port = $port;
    Connect2PayCurrencyHelper::$proxy_username = $username;
    Connect2PayCurrencyHelper::$proxy_password = $password;
  }

  /**
   * Return the supported currencies array.
   *
   * @return Array of all the currencies supported.
   */
  public static function getCurrencies() {
    return array_keys(Connect2PayCurrencyHelper::$currencies);
  }

  /**
   * Get a currency alphabetic code according to its numeric code in ISO4217
   *
   * @param string $code The numeric code to look for
   * @return The alphabetic code (like EUR or USD) or null if not found.
   */
  public static function getISO4217CurrencyFromCode($code) {
    foreach (Connect2PayCurrencyHelper::$currencies as $currency => $data) {
      if ($data["code"] == $code) {
        return $currency;
      }
    }

    return null;
  }

  /**
   * Return the ISO4217 currency code.
   *
   * @param string $currency The currency to look for
   * @return The ISO4217 code or null if not found
   */
  public static function getISO4217CurrencyCode($currency) {
    return (array_key_exists($currency, Connect2PayCurrencyHelper::$currencies)) ? Connect2PayCurrencyHelper::$currencies[$currency]["code"] : null;
  }

  /**
   * Return the currency symbol.
   *
   * @param string $currency The currency to look for
   * @return The currency symbol or null if not found
   */
  public static function getCurrencySymbol($currency) {
    return (array_key_exists($currency, Connect2PayCurrencyHelper::$currencies)) ? Connect2PayCurrencyHelper::$currencies[$currency]["symbol"] : null;
  }

  /**
   * Return the currency name.
   *
   * @param string $currency The currency to look for
   * @return The currency name or null if not found
   */
  public static function getCurrencyName($currency) {
    return (array_key_exists($currency, Connect2PayCurrencyHelper::$currencies)) ? Connect2PayCurrencyHelper::$currencies[$currency]["currency"] : null;
  }

  /**
   * Get a currency conversion rate from Yahoo webservice.
   *
   * @param string $from The source currency
   * @param string $to The destination currency
   */
  public static function getRate($from, $to) {
    // Check if currencies exists
    if (! Connect2PayCurrencyHelper::currencyIsAvailable($from) || ! Connect2PayCurrencyHelper::currencyIsAvailable($to)) {
      return null;
    }

    // Build the request URL
    $url = Connect2PayCurrencyHelper::$YAHOO_SERVICE_URL . "?s=" . $from . $to . "=X&f=l1&e=.csv";

    // Do the request
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if (Connect2PayCurrencyHelper::$proxy_host != null && Connect2PayCurrencyHelper::$proxy_port != null) {
      curl_setopt($curl, CURLOPT_PROXY, Connect2PayCurrencyHelper::$proxy_host);
      curl_setopt($curl, CURLOPT_PROXYPORT, Connect2PayCurrencyHelper::$proxy_port);

      if (Connect2PayCurrencyHelper::$proxy_username != null && Connect2PayCurrencyHelper::$proxy_password != null) {
        curl_setopt($curl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, Connect2PayCurrencyHelper::$proxy_username . ":" . Connect2PayCurrencyHelper::$proxy_password);
      }
    }

    $csv = trim(curl_exec($curl));
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    // Parse the CSV, we should only have a number, check this
    if ($httpCode == 200 && preg_match('/^[0-9.]+$/', $csv)) {
      return $csv;
    }

    return null;
  }

  /**
   * Convert an amount from one currency to another
   *
   * @param int $amount The amount to convert
   * @param string $from The source currency
   * @param string $to The destination currency
   * @param boolean $cent Specifies if the amount is in cent (default true)
   * @return The converted amount or null in case of error
   */
  public static function convert($amount, $from, $to, $cent = true) {
    // Get the conversion rate
    $rate = Connect2PayCurrencyHelper::getRate($from, $to);

    if ($rate != null) {
      $convert = $amount * $rate;

      // If the amount was in cent, truncate the digit after the comma
      // else round the result to 2 digits only
      return ($cent) ? round($convert, 0) : round($convert, 2);
    }

    return null;
  }

  private static function currencyIsAvailable($currency) {
    return array_key_exists($currency, Connect2PayCurrencyHelper::$currencies);
  }
}