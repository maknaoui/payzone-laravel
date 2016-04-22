<?php

/**
 * 
 * NB : You are not obliged tu use a configuration file, this is just an example.
 * 
 * PHP dependencies:
 * PHP >= 5.2.0
 * PHP CURL module
 * PHP Mcrypt module
 * 
 * @package Connect2PayClient
 * @version 2.0.3
 * @author Mehdi ATRAIMCHE <mehdi.atraimche@vpscorp.ma>
 **/

/**
 * /////////////////////////////
 * /// Authentication Fields ///
 * /////////////////////////////
 **/

/**
 * Payzone payment page URL
 * @var String
 * */
$url = "https://paiement.payzone.ma";
/**
 * Payzone merchant ID
 * @var String
 * */
$merchnatID = "";
/**
 * Payzone merchant password
 * @var String
 * */
$merchantPassword = "";


/**
 * ///////////////////////
 * /// Customer Fields ///
 * ///////////////////////
 **/

/**
 * merchant unique customer numeric id
 * @var Integer(32bits)
 **/
$shopperID = rand(1000, 9999);

/**
 * customer email address
 * @var String(100)
 **/
$shopperEmail = "contact@payzone.ma";

/**
 * Customer first name for shipping
 * @var String(35)	
 * */
$shipToFirstName = "Pay";

/**
 * Customer last name for shipping
 * @var String(35)	 
 * */
$shipToLastName = "Zone";

/**
 * Customer company name for shipping
 * @var String(128)
 * */
$shipToCompany = "Vantage Payment Systems";

/**
 * Customer phone for shipping ; if many, separate by ";"
 * @var String(20)	
 * */
$shipToPhone = "0522486995;0522480047";

/**
 * Customer address for shipping
 * @var String(255)
 * */
$shipToAddress = "17 bd Moulay Youssef, CASABLANCA";

/**
 * Customer state for shipping
 * @var String(30)	
 * */
$shipToState = "Morocco";

/**
 * Customer ZIP Code for shipping
 * @var String(10)
 * */
$shipToZipcode = "20000";

/**
 * Customer city for shipping
 * @var String(50)
 * */
$shipToCity = "Casablanca";

/**
 * Customer country for shipping
 * @var String(2)
 * */
$shipToCountryCode = "MA";

/**
 * Customer first name for invoicing
 * @var String(35)
 * */
$shopperFirstName = "Pay";

/**
 * Customer last name for invoicing
 * @var String(35)
 * */
$shopperLastName = "Zone";

/**
 * Customer phone for invoicing ; if many, separate by ";"
 * @var String(20)
 * */
$shopperPhone = "0522486995;0522480047";

/**
 * Customer address for invoicing
 * @var String(255)
 * */
$shopperAddress = "17 bd Moulay Youssef, CASABLANCA";

/**
 * Customer state for invoicing
 * @var String(30)
 * */
$shopperState = "Morocco";

/**
 * Customer ZIP Code for shipping
 * @var String(10)
 * */
$shopperZipcode = "20000";

/**
 * Customer city for shipping
 * @var String(50)
 * */
$shopperCity = "Casablanca";

/**
 * Customer country for shipping
 * @var String(2)
 * */
$shopperCountryCode = "MA";

/**
 * Customer company name for invoicing
 * @var String(128)
 * */
$shopperCompany = "Vantage Payment Systems";


/**
 * ////////////////////
 * /// Order Fields ///
 * ////////////////////
 **/

/**
 * Merchant internal unique order ID
 * @var String(100)
 * */
$orderID = "Order-".rand(1000,9999);

/**
 * Currency for the current order
 * @var String(3)
 * */
$currency = "MAD";

/**
 * The transaction amount in cents (for 1€ => 100)
 * @var Integer(32bits)
 * */
$amount = 15094;

/**
 * The transaction amount in cents, without shipping fee
 * @var Integer(32bits)
 * */
$orderTotalWithoutShipping = 15094;

/**
 * The shipping amount in cents (for 1€ => 100)
 * @var Integer(32bits)
 * */
$orderShippingPrice = 0;

/**
 * The discount amount in cents (for 1€ => 100)
 * @var Integer(32bits)	
 * */
$orderDiscount	 = 0;

/**
 * The IP address of the customer
 * @var String(15)	 
 * */
$customerIP = "127.0.0.1";

/**
 * Short description of the product purchased by the customer
 * @var String(255)
 * */
$orderDescription = "Example product";


/**
 * ///////////////////////
 * /// Shipping Fields ///
 * ///////////////////////
 * */

/**
 * Can be either : Physical (for physical goods), Virtual (for dematerialized goods), Access (for protected content)
 * @var String(50)
 * */
$shippingType = "Physical";

/**
 * In case of Physical shipping type, name of the shipping company
 * @var String(50)
 * */
$shippingName = "Vantage Payment Systems";


/**
 * 
 * Payment Detail Fields
 * 
 * */

/**
 * Can be CreditCard (default) or ToditoCash. This will change the type of the payment page displayed.
 * @var String(32)
 * */
$paymentType = "CreditCard";

/**
 * Can be either : Single, OnShipping, Recurrent, InstalmentsPayments
 * @var String(30)
 **/
$paymentMode = "Single";

/**
 * "true" or "false" (default false). In the case of CreditCard payment type, instruct to enable Secure 3D on the transaction. The merchant account must support this.
 * @var Boolean
 * */
$secure3d = false;


/**
 * //////////////////////
 * /// Control Fields ///
 * //////////////////////
 * */

/**
 * The URL where to redirect the customer after the transaction processing
 * @var String(2048)	
 * */
$ctrlRedirectURL = "http://www.example.org/redirect.php";

/**
 * A URL that will be notified of the status of the transaction
 * @var String(2048)
 * */
$ctrlCallbackURL = "http://www.example.org/callback.php";

/**
 * Custom data that will be returned back with the status of the transaction
 * @var String(2048)
 * */
$ctrlCustomData = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";

 ?>