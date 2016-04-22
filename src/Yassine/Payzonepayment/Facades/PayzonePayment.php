<?php
namespace Yassine\Payzonepayment\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class PayzonePayment extends Facade {
 
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor() { return 'payzonepayment'; }
 
