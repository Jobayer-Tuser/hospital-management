<?php
class MiscellaneousController
{
	public $directory;

	# =*|*=[ Root Path of CSS or JavaScript or Images Directory ]=*|*=
	public function asset($fileName, $version = null)
	{
		//CSS or JS or Others Directory
		$getFileExtention = explode('/', $fileName);
		if (is_array($getFileExtention)) {
			if (count($getFileExtention) == 1) {
				if (strpos($fileName, 'css')) {
					$this->directory = 'public/assets/css/';
				}
				if (strpos($fileName, 'js')) {
					$this->directory = 'public/assets/js/';
				}
			}
			if (count($getFileExtention) > 1) {
				$this->directory = 'public/assets/';
			}
		}

		//Images Directory
		$imageType = ['jpg', 'jpeg', 'png', 'ico', 'svg'];
		$getImageExtention = explode('.', $fileName);
		if (in_array(end($getImageExtention), $imageType)) {
			$this->directory = 'public/assets/images/';
		}

		if (empty($version)) {
			$this->publicDirectory = $this->directory . $fileName;
		} else {
			$this->publicDirectory = $this->directory . $fileName . '?' . rand(0, 9) . '.' . rand(0, 9);
		}

		echo $this->publicDirectory;
	}

	
	
	# =*|*=[ Redirect URL ]=*|*=
	public function redirect($location)
	{
		return header("Location:$location");
	}
}
?>