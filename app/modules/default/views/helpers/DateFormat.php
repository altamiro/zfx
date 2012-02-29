<?php
namespace Module\Defaults\View\Helper;
  

class DateFormat extends \App\View\Helper\HelperAbstract {
		
    public function dateFormat ($date='')
    {
        $date = !empty ($date) ? $date : date('Y-m-d');
        $pieces = explode("-",$date,3);
        $newDate = $pieces[2] . "/" . $pieces[1] . "/" . $pieces[0];
        return $newDate;
    }

}