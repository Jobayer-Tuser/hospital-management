<?php

# =*|*=[ Required Configurations ]=*|*=
include "config/site.php";


# =*|*=[ Application View ]=*|*=
class View
{
	public function loadContent($directory, $page_name)
	{
		include "resource/view/" . $directory . "/" . $page_name . ".php";
	}
}

?>