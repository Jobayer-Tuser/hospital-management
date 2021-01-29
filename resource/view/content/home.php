<?php
# =*|*=[ Object Defined ]=*|*=
$misc = new MiscellaneousController;
?>


<!-- Navigation Menu Bar Content [Start] -->
<nav class="navbar navbar-fixed-top transparent navbar-light bg-white">
	<div class="container">
		<a class="ui-variable-logo navbar-brand" href="index">
			<img class="logo-default" src="<?php $misc->asset('applify.png', true); ?>" alt="" data-uhd />
			<img class="logo-transparent" src="<?php $misc->asset('applify-white.png', true); ?>" alt="" data-uhd />
		</a>
		<div class="ui-navigation navbar-right">
			<ul class="nav navbar-nav">

				<?php
				# =*|*=[ Top Navigation Bar ]=*|*=
				$navigation = ['features', 'video', 'steps', 'integrations', 'faq', 'testimonials'];

				if (is_array($navigation)) {
					foreach ($navigation as $each) {
						echo '<li><a href="javascript:;" data-scrollto="' . $each . '">' . ucwords($each) . '</a></li>';
					}
				}
				?>

			</ul>
		</div>
		<a href="javascript:;" class="btn btn-sm ui-gradient-green pull-right">Download</a>
		<a href="javascript:;" class="ui-mobile-nav-toggle pull-right"></a>
	</div>
</nav>
<!-- Navigation Menu Bar Content [End] -->


<!-- Main Content [Start] -->
<div class="main" role="main">
	<div class="ui-hero hero-lg hero-center ui-gradient-blue ui-waves hero-svg-layer-3">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1 class="heading">Medi Raj - Your Health Partner</h1>
					<p class="paragraph">
						A Complete Medical Service Solution at Your City
					</p>
					<div class="actions">
						<a class="btn ui-gradient-blue shadow-xl" data-scrollto="<?php echo $navigation[0]; ?>">Learn More</a>
						<a class="btn ui-gradient-green shadow-xl" href="javascript:;">Download</a>
					</div>
				</div>
				<div class="col-sm-12">
					<img src="<?php $misc->asset('applify-mockup-1-lg.png', true); ?>" alt="" data-uhd data-max_width="740" class="responsive-on-md" />
				</div>
			</div>
		</div>
	</div>


	<!-- [] Feature Section Content Start [] -->
	<div id="<?php echo $navigation[0]; ?>" class="section">
		<div class="container">

			<div class="section-heading center">
				<h2 class="heading text-indigo">Tabbed Showcase</h2>
				<p class="paragraph">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			</div>

			<div class="row ui-tabbed-showcase">
				<div class="col-md-6 col-sm-5 animate" data-show="fade-in-right">
					<div class="ui-device-slider">
						<div class="device">
							<img src="<?php $misc->asset('device.png', true); ?>" data-uhd alt="" />
						</div>

						<!-- Slider Image Start -->
						<div id="device-slider-2" class="screens owl-carousel owl-theme">
							<div class="item">
								<img src="<?php $misc->asset('app-screen-1.jpg', true); ?>" data-uhd alt="" />
							</div>
							<div class="item">
								<img src="<?php $misc->asset('app-screen-8.jpg', true); ?>" data-uhd alt="" />
							</div>
							<div class="item">
								<img src="<?php $misc->asset('app-screen-2.jpg', true); ?>" data-uhd alt="" />
							</div>
							<div class="item">
								<img src="<?php $misc->asset('app-screen-3.jpg', true); ?>" data-uhd alt="" />
							</div>
						</div>
						<!-- Slider Image End -->

					</div>
				</div>

				<!-- Tabs and Accordians Content Start -->
				<div class="col-md-6 col-sm-7" data-vertical_center="true">
					<div class="ui-tabs ui-green">

						<?php
						$tabContent = array(
							'home'		=> '<span class="icon icon-home"></span>',
							'profile'	=> '<span class="icon icon-user"></span>',
							'messages'	=> '<span class="icon icon-envelope-letter"></span>',
							'settings'	=> '<span class="icon icon-settings"></span>'
						);
						?>

						<ul class="nav nav-tabs" role="tablist">
							<?php
							if (is_array($tabContent)) {
								$n = 1;
								foreach ($tabContent as $index => $each) {
									$isActive = ($index == 'home') ? ' active' : '';

									echo '
										<li role="presentation" class="nav-item">
											<a class="nav-link' . $isActive . '" href="#' . $index . '" role="tab" data-toggle="tab" data-toggle_screen="' . $n . '" data-toggle_slider="device-slider-2">
												' . $each . ' ' . ucwords($index) . '
											</a>
										</li>
									';
									$n++;
								}
							}
							?>
						</ul>
						<div class="tab-content">

							<?php
							if (is_array($tabContent)) {
								foreach ($tabContent as $index => $each) {
									$activeContent = ($index == 'home') ? ' show active' : '';

							?>
									<div role="tabpanel" class="tab-pane fade<?php echo $activeContent; ?>" id="<?php echo $index; ?>">
										<p class="sub-heading">
											Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
											dolore magna aliqua.
										</p>
										<ul class="ui-checklist">
											<li>
												<h6 class="heading">Consectetur adipisicing</h6>
											</li>
											<li>
												<h6 class="heading">Eiusmod tempor incididunt</h6>
											</li>
											<li>
												<h6 class="heading">Ut enim ad minim</h6>
											</li>
											<li>
												<h6 class="heading">Lorem ipsum dolor</h6>
											</li>
										</ul>
									</div>

							<?php
								}
							}
							?>

						</div>
					</div>
				</div>
				<!-- Tabs and Accordians Content End -->

			</div>
		</div>
	</div>
	<!-- [] Feature Section Content End [] -->


	<!-- [] Video Section Content Start [] -->
	<div id="<?php echo $navigation[1]; ?>" class="section bg-green ui-action-section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-7 text-block" data-vertical_center="true">
					<div class="section-heading">
						<h2 class="heading">Devoted to UI/UX quality</h2>
						<p class="paragraph">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
						</p>
						<div class="actions">
							<a class="ui-video-toggle" data-video="1C75bKax4Eg">
								<span class="icon fa fa-play bg-indigo"></span> <span>How Raz Medicare Works</span>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-5 img-block animate" data-show="fade-in-left">
					<img src="<?php $misc->asset('applify-mockup-3.png', true); ?>" alt="" data-uhd class="responsive-on-sm" data-max_width="577" />
				</div>
			</div>
		</div>
	</div>
	<!-- [] Video Section Content End [] -->


	<!-- [] Process Section Content Start [] -->
	<div id="<?php echo $navigation[2]; ?>" class="section">
		<div class="container">
			<div class="section-heading center">
				<h2 class="heading text-indigo">All in 3 Easy Steps</h2>
				<p class="paragraph">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				</p>
			</div>

			<div class="ui-showcase-blocks ui-steps">

				<?php
				$images = ['applify-mockup-7.png', 'applify-mockup-8.png', 'applify-mockup-10.png'];

				for ($i = 0; $i < count($images); $i++) {
				?>

					<div class="step-wrapper">
						<span class="step-number ui-gradient-green"><?php echo ($i + 1); ?></span>
						<div class="row">
							<div class="col-md-6" data-vertical_center="true">
								<h4 class="heading text-dark-gray">
									Multi and single page support
								</h4>
								<p class="paragraph">
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
									dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
									ea commodo consequat.
								</p>
								<a href="#" class="btn-link btn-arrow">Explore</a>
							</div>
							<div class="col-md-6">
								<img class="responsive-on-xs" src="<?php echo $misc->asset($images[$i], true); ?>" data-uhd alt="" data-max_width="451" />
							</div>
						</div>
					</div>

				<?php
				}
				?>

			</div>
		</div>
	</div>
	<!-- [] Process Section Content End [] -->


	<!-- [] Call To Action Section Content Start [] -->
	<div class="section bg-indigo ui-section-tilt ui-action-section">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-7 text-block">
					<div class="section-heading">
						<h2 class="heading">Available on iOS and Android</h2>
						<p class="paragraph">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
						</p>
						<div class="actions">
							<a class="btn ui-gradient-blue btn-app-store btn-download shadow-lg">
								<span>Available on the</span> <span>App Store</span>
							</a>
							<a class="btn ui-gradient-green btn-google-play btn-download shadow-lg">
								<span>Available on </span> <span>Google Play</span>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-5 img-block animate" data-show="fade-in-left">
					<img src="<?php $misc->asset('applify-mockup-2-lg.png', true); ?>" alt="" data-uhd class="responsive-on-sm" data-max_width="547" />
				</div>
			</div>
		</div>
	</div>
	<!-- [] Call To Action Section Content End [] -->


	<!-- [] App Screens Section Content Start [] -->
	<div class="section">
		<div class="container">
			<div class="section-heading center">
				<h2 class="heading text-indigo">App Screens</h2>
				<p class="paragraph">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
				</p>
			</div>

			<div class="ui-app-screens owl-carousel owl-theme animate" data-show="fade-in">

				<?php
				$owlCarousel = [
					'app-screen-5.jpg',
					'app-screen-1.jpg',
					'app-screen-6.jpg',
					'app-screen-3.jpg',
					'app-screen-7.jpg',
					'app-screen-2.jpg',
					'app-screen-4.jpg'
				];

				if (is_array($owlCarousel)) {
					foreach ($owlCarousel as $each) {
				?>

						<div class="ui-card shadow-lg">
							<img src="<?php echo $misc->asset($each, true); ?>" alt="" data-uhd />
						</div>

				<?php
					}
				}
				?>

			</div>
		</div>
	</div>
	<!-- [] App Screens Section Content End [] -->


	<!-- [] Integration Section Content Start [] -->
	<div id="<?php echo $navigation[3]; ?>" class="section bg-green">
		<div class="container">
			<div class="row">

				<!-- Left Side Content Start -->
				<div class="col-lg-5 col-xl-6" data-vertical_center="true">
					<div class="section-heading mb-2">
						<h2 class="heading">Raz Medicare Integrations</h2>
						<p class="paragraph">
							Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit Sed Do Eiusmod Tempor Incididunt Ut Labore Et Dolore Magna Ali
						</p>
					</div>
					<ul class="ui-icon-blocks ui-blocks-v icons-sm">

						<?php
						$integrations = array(
							'icon icon-diamond'		=> 'Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit Sed',
							'icon icon-pie-chart'	=> 'Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit Sed',
							'icon icon-layers'		=> 'Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit Sed'
						);

						if (is_array($integrations)) {
							foreach ($integrations as $index => $each) {
								echo '
									<li class="ui-icon-block">
										<span class="' . $index . '"></span>
										<p class="">' . $each . '</p>
										<a class="btn-link btn-arrow">Learn More</a>
									</li>
								';
							}
						}
						?>

					</ul>
				</div>
				<!-- Left Side Content End -->

				<!-- Right Side Content Start -->
				<div class="col-lg-7 col-xl-6">
					<div class="ui-logos-cloud">

						<?php
						$logos = [
							'svg/quickbooks.svg',
							'svg/salesforce.svg',
							'svg/git.svg',
							'svg/webflow.svg',
							'svg/shopify.svg',
							'svg/mailchimp.svg',
							'svg/xero.svg',
							'svg/bigcommerce.svg',
							'svg/squarespace.svg',
							'svg/sharepoint.svg',
							'svg/slack.svg',
							'svg/paypal.svg',
							'svg/fresh-desk.svg',
							'svg/stripe.svg',
							'svg/woocommerce.svg'
						];

						if (is_array($logos)) {
							for ($i = 0; $i < count($logos); $i++) {
								if ($i % 4 == 0) {
									echo '<span class="flex-break"></span>';
								}
						?>
								<div data-size="<?php echo rand(5, 10); ?>" class="mt-0 animate" data-show="fade-in">
									<img src="<?php $misc->asset($logos[$i]); ?>" alt="" />
								</div>
						<?php
							}
						}

						?>

					</div>
				</div>
				<!-- Right Side Content End -->

			</div>
		</div>
	</div>
	<!-- [] Integration Section Content End [] -->


	<!-- [] FAQ Section Content Start [] -->
	<div id="<?php echo $navigation[4]; ?>" class="section bg-light">
		<div class="container">
			<div class="section-heading center">
				<h2 class="heading text-indigo">Frequently Asked</h2>
				<p class="paragraph">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
				</p>
			</div>
			<div class="row">
				<div class="col-md-6" data-vertical_center="true">
					<div class="ui-accordion-panel">

						<?php
						$faq = array(
							array(
								'title'		=> 'Lorem Ipsum Dolor Sit?',
								'details'	=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
							),
							array(
								'title'		=> 'Amet Consectetur Adipisicing?',
								'details'	=> 'Donec elementum ligula eu sapien consequat eleifend. Donec nec dolor erat, condimentum sagittis sem. Praesent porttitor porttitor risus, dapibus rutrum ipsum gravida et. Integer lectus nisi, facilisis sit amet eleifend nec.'
							),
							array(
								'title'		=> 'Elit Sed Do Eiusmo?',
								'details'	=> 'Aliquam erat volutpat. Maecenas scelerisque, orci sit amet cursus tincidunt, libero nisl eleifend tortor, vitae cursus risus mauris vitae nisi. Cras laoreet ultrices ligula eget tempus.'
							),
							array(
								'title'		=> 'Ea Commodo Consequat?',
								'details'	=> 'In hac habitasse platea dictumst. Pellentesque ornare blandit orci, eget tristique risus convallis ut. Vivamus a sapien neque. Morbi malesuada massa ac sapien luctus vulputate.'
							),
						);

						if (is_array($faq)) {
							$n = 1;
							foreach ($faq as $each) {
								echo '
									<div class="ui-card shadow-sm ui-accordion">
										<h6 class="toggle" data-toggle="accordion-' . $n . '">
											' . $n . '. ' . $each['title'] . '
										</h6>
										<div class="body in" data-accord="accordion-' . $n . '">
											<p>' . $each['details'] . '<a href="javascript:;" target="_blank">Learn more.</a></p>
										</div>
									</div>
								';
								$n++;
							}
						}
						?>

					</div>
				</div>
				<div class="col-md-6">
					<img src="<?php $misc->asset('applify-mockup-4.png', true); ?>" alt="" class="responsive-on-sm" data-max_width="500" data-uhd />
				</div>
			</div>
		</div>
	</div>
	<!-- [] FAQ Section Content End [] -->


	<!-- []  Testimonial Section Content End [] -->
	<div id="<?php echo $navigation[5]; ?>" class="section">
		<div class="container">
			<div class="section-heading center">
				<h2 class="heading text-indigo">What People Say</h2>
				<p class="paragraph">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				</p>
			</div>
			<div class="ui-testimonials slider owl-carousel owl-theme">

				<?php
				$testimonials = array(
					array(
						'comment'		=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.',
						'avatar'			=> 'avatar1-sm.png',
						'user'			=> 'Vicky Stout',
						'designation'	=> 'Founder at Smith &amp; Co'
					),
					array(
						'comment'		=> 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.',
						'avatar'			=> 'avatar2-sm.png',
						'user'			=> 'Jack Smith',
						'designation'	=> 'Founder at Smith &amp; Co'
					),
					array(
						'comment'		=> 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur ac nisi.',
						'avatar'			=> 'avatar3-sm.png',
						'user'			=> 'Chérel Doe',
						'designation'	=> 'Founder at Smith &amp; Co'
					),
					array(
						'comment'		=> 'Donec elementum ligula eu sapien consequat eleifend. Donec nec dolor erat, condimentum sagittis.',
						'avatar'			=> 'avatar4-sm.png',
						'user'			=> 'Derick Watts',
						'designation'	=> 'Founder at Smith &amp; Co'
					),
					array(
						'comment'		=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.',
						'avatar'			=> 'avatar5-sm.png',
						'user'			=> 'Jane Austin',
						'designation'	=> 'Founder at Smith &amp; Co'
					)
				);

				if (is_array($testimonials)) {
					foreach ($testimonials as $each) {
				?>

						<div class="item">
							<div class="ui-card shadow-md">
								<p><?php echo $each['comment']; ?></p>
							</div>
							<div class="user">
								<div class="avatar">
									<img alt="" src="<?php $misc->asset($each['avatar']); ?>">
								</div>
								<div class="info">
									<h6 class="heading text-dark-gray"><?php echo $each['user']; ?></h6>
									<p class="sub-heading"><?php echo $each['designation']; ?></p>
								</div>
							</div>
						</div>

				<?php
					}
				}
				?>

			</div>
		</div>
	</div>
	<!-- [] Testimonial Section Content End [] -->


	<!-- [] Call To Action Section Content Start [] -->
	<div class="section ui-gradient-blue py-5 hero-svg-layer-3">
		<div class="container">
			<div class="section-heading center">
				<div class="ui-app-icon shadow-lg">
					<img src="<?php $misc->asset('applify-app-icon.png'); ?>" alt="">
				</div>
				<h2 class="heading">Download Raz Medicare Now</h2>
				<p class="paragraph">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit.
				</p>
			</div>
			<div class="actions text-center">
				<a class="btn ui-gradient-green btn-app-store btn-download shadow-lg">
					<span>Available on the</span> <span>App Store</span>
				</a>
				<a class="btn ui-gradient-blue btn-google-play btn-download shadow-lg">
					<span>Available on </span> <span>Google Play</span>
				</a>
			</div>
		</div>
	</div>
	<!-- [] Call To Action Section Content End [] -->


	<!-- [] Footer Section Content Start [] -->
	<footer class="ui-footer">
		<div class="footer-copyright bg-dark-gray py-2">
			<div class="container">
				<div class="row">
					<div class="col-8">
						<p>
							Copyright &copy; <?php echo date('Y'); ?> <a href="index">Medi Raj</a> 
							All Rights Reserved &reg; IT Partner <i class="fas fa-code text-warning"></i> App Dev Zone&trade;
						</p>
					</div>
					<div class="col-4 text-right">
						<a class="btn ui-gradient-blue btn-circle shadow-md">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a class="btn ui-gradient-peach btn-circle shadow-md">
							<i class="fab fa-instagram"></i>
						</a>
						<a class="btn ui-gradient-green btn-circle shadow-md">
							<i class="fab fa-twitter"></i>
						</a>
						<a class="btn ui-gradient-purple btn-circle shadow-md">
							<i class="fab fa-linkedin-in"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- [] Footer Section Content End [] -->

</div>
<!-- Main Content [End] -->