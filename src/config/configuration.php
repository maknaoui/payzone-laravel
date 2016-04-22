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

return array(
	'url'=>"https://paiement.payzone.ma",
	'merchnatID'=>"",
	'merchantPassword'=>"",
	'shopperID'=>rand(1000, 9999),
	'shopperEmail'=>"contact@payzone.ma",
	'shipToFirstName'=>"Pay",
	'shipToLastName'=>"Zone",
	'shipToCompany'=>"Vantage Payment Systems",
	'shipToPhone'=>"0522486995;0522480047",
	'shipToAddress'=>"17 bd Moulay Youssef, CASABLANCA",
	'shipToState'=>"Morocco",
	'shipToZipcode'=>"20000",
	'shipToCity'=>"Casablanca",
	'shipToCountryCode'=>"MA",
	'shopperFirstName'=>"Pay",
	'shopperLastName'=>"Zone",
	'shopperPhone'=>"0522486995;0522480047",
	'shopperAddress'=>"17 bd Moulay Youssef, CASABLANCA",
	'shopperState'=>"Morocco",
	'shopperZipcode'=>"20000",
	'shopperCity'=>"Casablanca",
	'shopperCountryCode'=>"MA",
	'shopperCompany'=>"Vantage Payment Systems",
	'orderID'=>"Order-".rand(1000,9999),
	'currency'=>"MAD",
	'amount'=>15094,
	'orderTotalWithoutShipping'=>15094,
	'orderShippingPrice'=>0,
	'orderDiscount'=>0,
	'customerIP'=>"127.0.0.1",
	'orderDescription'=>"Example product",
	'shippingType'=>"Physical",
	'shippingName'=>"Vantage Payment Systems",
	'paymentType'=>"CreditCard",
	'paymentMode'=>"Single",
	'secure3d'=>false,
	'ctrlRedirectURL'=>"http://www.example.org/redirect.php",
	'ctrlCallbackURL'=>"http://www.example.org/callback.php",
	'ctrlCustomData'=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit.",
);