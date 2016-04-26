<?php
namespace Maknaoui\PayzoneLaravel;

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