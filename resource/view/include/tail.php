<?php

# =*|*=[ Object Defined ]=*|*=
$misc = new MiscellaneousController;

?>

	<script type="text/javascript" src="<?php $misc->asset('jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php $misc->asset('jquery.sliderPro.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php $misc->asset('owl.carousel.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php $misc->asset('bootstrap.js'); ?>"></script>
	<script type="text/javascript" src="<?php $misc->asset('app.js'); ?>"></script>

	<!-- || Disable Image Dragging and Right Click and Inspect Console || -->
	<script type="text/javascript">
		$("img").mousedown(function(){
			return false;
		});
		
		$(document).on('contextmenu', function (e) {
			return false;
		});

		$(document).keydown(function (event) {
			//Prevent F12 and Ctrl+Shift+I
			if (event.keyCode == 123) {
				return false;
			} else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
				return false;
			}
		});
	</script>

</body>
</html>