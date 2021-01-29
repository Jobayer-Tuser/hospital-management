<?php

class ComponentController extends MiscellaneousController
{
   /**
    * Dashboard Summary Card
    *
    * @param string|int
    * @return summaryCardComponent
    */
   public function dashboardSummary($color, $title, $value, $subTitle, $icon)
   {
      $template = '
      <div class="col-xl-3 col-md-6">
         <div class="card bg-'. $color .' mini-stat position-relative">
            <div class="card-body">
               <div class="mini-stat-desc">
                  <h6 class="text-uppercase verti-label text-white-50">' . ucwords($title) . '</h6>
                  <div class="text-white">
                     <h6 class="text-uppercase mt-0 text-white-50">' . ucwords($title) . '</h6>
                     <h3 class="mb-3 mt-0">' . $value . '</h3>
                     <span class="badge badge-white py-1">' . ucwords($subTitle) . '</span>
                  </div>
                  <div class="mini-stat-icon">
                     <i class="mdi ' . $icon . ' display-2"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
      ';
      return $template;
   }
   

   /**
    * Tabs and Accordians Navigation Based On Label Component
    * 
    * @param array
    * @return tabAndAccordianComponent
    */
   public function tabsNavigation($array)
   { 
      if(is_array($array)) {

         echo '
         <ul 
            class="nav flex-column nav-pills" 
            id="recent-activity-tab" 
            role="tablist"
            aria-orientation="vertical"
         >';
         foreach($array AS $index => $each) {
            if($index == 0) {
               $index = 'active';
            }

            if(strpos($each, '_')) {
               $title = str_replace('_', ' ', $each);
            } else {
               $title = $each;
            }

            echo '
               <li class="nav-item">
                  <a class="nav-link '.$index.' textContent" 
                     id="'.strtolower($each).'-tab" 
                     data-toggle="pill" 
                     href="#'.strtolower($each).'" 
                     role="tab"
                     data-name="'.$each.'"
                     aria-controls="'.strtolower($each).'" 
                     aria-selected="true">
                     '. ucwords($title) .'
                  </a>
               </li>
            ';
         }
         echo '</ul>';
      }
   }


   /**
    * Current Status Change Button
    * 
    * @param string
    * @return buttonComponent
    */
   public function changeStatus($value, $status)
	{
		$changeStatusInfo = '
			<form method="post" action="">
				<input type="hidden" name="change_id" value="' . $value . '" />
				<input type="hidden" name="current_status" value="' . $status . '" />
		';

		if ($status == "Active") {
         $changeStatusInfo .= '
				<button name="change_status" class="btn btn-info btn-sm waves-effect waves-light mw-80" type="submit">
					' . $status . '
				</button>
			';
		} else if ($status == "Inactive") {
			$changeStatusInfo .= '
				<button name="change_status" class="btn btn-secondary btn-sm waves-effect waves-light mw-80" type="submit">
					' . $status . '
				</button>
			';
		}

		$changeStatusInfo .= '</form>';
		return $changeStatusInfo;
	}
}
