<?php
namespace Maknaoui\PayzoneLaravel\Facades;
 
use Illuminate\Support\Facades\Facade;
 
class PayzoneLaravel extends Facade
{

  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return 'payzonelaravel';
  }

}
