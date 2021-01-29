<?php

/**
 * Object Defined
 * Accessible to the Class Methods Such as:
 * ----------------------------------------
 * 1. Resource Controller
 */
$resc = new ResourceController;

?>

      <!-- =+|+= Application Tail Page Content [Start] =+|+= -->
               </div>
            </div>
            <footer class="footer" style="padding-top: 12px; padding-bottom: 12px;">
               Copyright &copy; <?php echo date('Y'); ?> 
               <a href="//mediraj.com">Medi Raj</a> All Rights Reserved &reg;
               IT Partner <i class="fas fa-code text-primary"></i> 
               <a href="//aDecoder.com" target="_blank"><strong>aDecoder</strong>&trade;</a>
            </footer>
         </div>
      </div>

      <script src="<?php echo $resc->asset('bootstrap.bundle.min.js'); ?>"></script>
      <script src="<?php echo $resc->asset('metisMenu.min.js'); ?>"></script>
      <script src="<?php echo $resc->asset('jquery.slimscroll.js'); ?>"></script>
      <script src="<?php echo $resc->asset('waves.min.js'); ?>"></script>

      <!-- || Air DateTime Picker Initialization || -->
      <script src="<?php echo $resc->asset('datepicker.js'); ?>"></script>
      <script src="<?php echo $resc->asset('datepicker.en.js'); ?>"></script>
      <script type="text/javascript">
         $('.datepicker-here').datepicker({
            language: 'en'
         });

         $('.only-time').datepicker({
            dateFormat: ' ',
            timepicker: true,
            classes: 'only-timepicker'
         });
      </script>


      <!-- || Required Datatable Source Path and Initialize || -->
      <script src="<?php echo $resc->asset('jquery.dataTables.min.js', 'plugins/datatables'); ?>"></script>
      <script src="<?php echo $resc->asset('dataTables.bootstrap4.min.js', 'plugins/datatables'); ?>"></script>
      <script src="<?php echo $resc->asset('dataTables.responsive.min.js', 'plugins/datatables'); ?>"></script>
      <script src="<?php echo $resc->asset('responsive.bootstrap4.min.js', 'plugins/datatables'); ?>"></script>
      <script type="text/javascript">
         $('.datatable').DataTable();
      </script>


      <!-- || Select2 Plugin Source Path and Initialize || -->
      <script src="<?php echo $resc->asset('select2.min.js', 'plugins/select2'); ?>"></script>
      <script type="text/javascript">
         $(".select2").select2();

         $(".select2-limiting").select2({
            maximumSelectionLength: 2
         });
      </script>


      <!-- || Initialize Digital Clock || -->
      <script type="text/javascript">
         $(document).ready(function() {
            const currentDate = function startTime() {
               let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
               let months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                  'October', 'November', 'December'];

               let today = new Date();
               let h = today.getHours();
               let m = today.getMinutes();
               let s = today.getSeconds();
               let year = today.getFullYear();
               let month = months[today.getMonth()];
               let day = days[today.getDay()];
               let date = today.getDate();
               let ampm = h >= 12 ? 'pm' : 'am';

               h = (h % 12) || 12;
               m = checkTime(m);
               s = checkTime(s);

               document.getElementById('time').innerHTML = month + ", " + date + " " + year + " " + h + ":" + m +
                  ":" + s + " " + ampm;

               t = setTimeout(function() {
                  startTime()
               }, 500);
            }

            function checkTime(i) {
               if (i < 10) {
                  i = "0" + i;
               }
               return i;
            }
            currentDate();
         });
      </script>

      <script src="<?php echo $resc->asset('main.js'); ?>"></script>
      <script src="<?php echo $resc->asset('app.js'); ?>"></script>
      

      <!-- || Todo Application Crud Operation || -->
      <script type="text/javascript">
         $(document).ready(function() {

            //Read All Todos Data
            function loadTodos() {
               $.ajax({
                  url: 'sync.php',
                  type: 'POST',
                  data: {
                     action: "GET_TODOS_DATA",
                     id: <?php echo $_SESSION['auth_log_id']; ?>
                  },
                  success: function(data) {
                     $('#todoList').html(data);
                  }
               });
            }
            loadTodos();

            //Create A New Todo Data  
            $(document).on('click', '#addTodos', function() {
               let todoData = $('#todoTitle').val();
               if (todoData == '') {
                  confirm('Oops! make sure that the field is not empty..!');
               } else {
                  $.ajax({
                     url: 'sync.php',
                     type: 'POST',
                     data: {
                        action: "ADD_TODO_DATA",
                        user: <?php echo $_SESSION['auth_log_id']; ?>,
                        todo: todoData
                     },
                     success: function(data) {
                        if (data == 1) {
                           loadTodos();
                           $('#todoTitle').val('');
                        } else {
                           $('#todoTitle').val('');
                        }
                     }
                  });
               }
            });

            //Delete A Todos Data
            $(document).on('click', '.deleteTodos', function() {
               let deleteTodo = $(this).data('todo');
               let element = this;

               if (confirm('Do you really want to delete this record?')) {
                  console.log(deleteTodo);
                  $.ajax({
                     url: 'sync.php',
                     type: 'POST',
                     data: {
                        action: "DELETE_TODO_DATA",
                        id: deleteTodo
                     },
                     success: function(data) {
                        if (data == 1) {
                           loadTodos();
                           $(element).closest('li').fadeOut('slow');
                        }
                     }
                  });
               }
            });
         });
      </script>


      <!-- || Disable Image Dragging and Right Click and Inspect Console || -->
      <script type="text/javascript">
         $("img").mousedown(function(){
            return false;
         });
         
         // $(document).on('contextmenu', function (e) {
         //    return false;
         // });

         // $(document).keydown(function (event) {
         //    //Prevent F12 and Ctrl+Shift+I
         //    if (event.keyCode == 123) {
         //       return false;
         //    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
         //       return false;
         //    }
         // });
      </script>

      <!-- =+|+= Application Tail Page Content [End] =+|+= -->

   </body>
</html>