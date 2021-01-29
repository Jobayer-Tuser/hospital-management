<?php

/**
 * Object Defined
 * 
 * Accessible to the Class Methods Such as:
 * [1] MiscellaneousController
 */
$misc = new MiscellaneousController;

?>

<!-- =+|+= BLANK PAGE CONTENT [START] =+|+= -->
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div style="min-height: 300px;">
                  <div class="display-4 text-secondary text-center pt-5">
                     Blank Page for Testing Purpose...
                  </div>
                  <div class="h4 text-primary text-center pt-3 font-weight-normal" id="userDefined">
                     <!-- Propmt Message Will Be Appear Here.. -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- =+|+= BLANK PAGE CONTENT [END] =+|+= -->


<!-- =+|+= JAVASCRIPT CONTENT [START] =+|+= -->
<script type="text/javascript">
   $(document).ready(function () {
      if (confirm('Do you want to perform any test?')) {
         let userName = prompt('Let us know your name');
         let isActivities = prompt('Plesase define your test purpose..');

         if (userName !== null && isActivities !== null) {
            $('#userDefined').html('Hello Mr. ' + userName + ' have a good day, please perform ' + isActivities + ' here..');
         } else {
            $('#userDefined').html('You also able to perform any kind of test in this page as well as you want');
         }
      } else {
         location.reload();
      }
   });
</script>
<!-- =+|+= JAVASCRIPT CONTENT [END] =+|+= -->