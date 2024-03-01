<?php
namespace Mohdradzee\Waident\Controllers;

use Illuminate\Http\Request;
use Mohdradzee\Waident\Inspire;

class WaidentController
{
    public function __invoke(Inspire $inspire){
        $quote = $inspire->justDoIt();

        return $quote;
    }

}