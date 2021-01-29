<?php

class Controller
{
	public $connection;

	# =*|*=[ CONNECTION MANAGER ]=*|*=
	public function __construct()
	{
		$this->connection = new PDO('mysql:host=' . $GLOBALS['DBHOST'] . ';dbname=' . $GLOBALS['DBNAME'] . ';charset=utf8', $GLOBALS['DBUSER'], $GLOBALS['DBPASS']);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}


	# =*|*=[ VERIFY FILE FORMAT | IMAGE TYPES ]=*|*=
	public function checkImage($fileType, $fileSize, $fileError)
	{
		// 50 MB = 52428800 Bytes //
		if ((($fileType == "image/gif")
				|| ($fileType == "image/jpeg")
				|| ($fileType == "image/jpg")
				|| ($fileType == "image/pjpeg")
				|| ($fileType == "image/x-png")
				|| ($fileType == "image/png"))
			&& ($fileSize < 52428800)
			&& ($fileError <= 0)
		) {
			return 1;
		} else
			return 0;
	}


	# =*|*=[ CHECK USER AGENT TYPET | PC-USER OR MOBILE-USER OR BOT ]=*|*=
	public function agentCheck()
	{
		$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);

		if (preg_match("/abrowse\/|acoo browser\/|america online browser\/|amigavoyager\/|aol\/|arora\/|avant browser\/|beonex\/|bonecho\/|browzar\/|camino\/|charon\/|cheshire\/|chimera\/|cirefox\/|chrome\/|chromeplus\/|classilla\/|cometbird\/|comodo_dragon\/|conkeror\/|crazy browser\/|cyberdog\/|deepnet explorer\/|deskbrowse\/|dillo\/|dooble\/|element browser\/|elinks\/|enigma browser\/|enigmafox\/|epiphany\/|escape\/|firebird\/|firefox\/|fireweb navigator\/|flock\/|fluid\/|galaxy\/|galeon\/|granparadiso\/|greenbrowser\/|hana\/|hotjava\/|ibm webexplorer\/|ibrowse\/|icab\/|iceape\/|icecat\/|iceweasel\/|inet browser\/|internet explorer\/|irider\/|iron\/|k-meleon\/|k-ninja\/|kapiko\/|kazehakase\/|kindle browser\/|kkman\/|kmlite\/|konqueror\/|leechcraft\/|links\/|lobo\/|lolifox\/|lorentz\/|lunascape\/|lynx\/|madfox\/|maxthon\/|midori\/|minefield\/|mozilla\/|myibrow\/|myie2\/|namoroka\/|navscape\/|ncsa_mosaic\/|netnewswire\/|netpositive\/|netscape\/|netsurf\/|omniweb\/|opera\/|orca\/|oregano\/|osb-browser\/|palemoon\/|phoenix\/|pogo\/|prism\/|qtweb internet browser\/|rekonq\/|retawq\/|rockmelt\/|safari\/|seamonkey\/|shiira\/|shiretoko\/|sleipnir\/|slimbrowser\/|stainless\/|sundance\/|sunrise\/|surf\/|sylera\/|tencent traveler\/|tenfourfox\/|theworld browser\/|uzbl\/|vimprobable\/|vonkeror\/|w3m\/|weltweitimnetzbrowser\/|worldwideweb\/|wyzo\//", $user_agent))
			$user = "PC";

		if (preg_match("/phone|iphone|itouch|ipod|symbian|kyocera|handspring|android|android webkit browser|blackberry|blazer|bolt|browser for s60|doris|dorothy|fennec|go browser|ie mobile|iris|maemo browser|mib|minimo|netfront|opera mini|opera mobile|semc-browser|skyfire|teashark|teleca-obigo|uzard web|epoc|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|mobile|pda;|avantgo|eudoraweb|minimo|smartphone|netfront|motorola|mmp|opwv|playstation portable|brew|teleca|lg;|lge |wap;| wap|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent))
			$user = "MOBILE";

		if (preg_match("/rambler|008|abachobot|accoona-ai-agent|addsugarspiderbot|anyapexbot|arachmo|b-l-i-t-z-b-o-t|baiduspider|becomebot|beslistbot|billybobbot|bimbot|bingbot|blitzbot|boitho.com-dc|boitho.com-robot|btbot|catchbot|cerberian drtrs|charlotte|converacrawler|cosmos|covario ids|dataparksearch|diamondbot|discobot|dotbot|earthcom.info|emeraldshield.com webbot|envolk[its]spider|esperanzabot|exabot|fast enterprise crawler|fast-webcrawler|fdse robot|findlinks|furlbot|fyberspider|g2crawler|gaisbot|galaxybot|geniebot|gigabot|girafabot|googlebot|googlebot-image|gurujibot|happyfunbot|hl_ftien_spider|holmes|htdig|iaskspider|ia_archiver|iccrawler|ichiro|igdespyder|irlbot|issuecrawler|jaxified bot|jyxobot|koepabot|l.webis|lapozzbot|larbin|ldspider|lexxebot|linguee bot|linkwalker|lmspider|lwp-trivial|mabontland|magpie-crawler|mediapartners-google|mj12bot|mlbot|mnogosearch|mogimogi|mojeekbot|moreoverbot|morning paper|msnbot|msrbot|mvaclient|mxbot|netresearchserver|netseer crawler|newsgator|ng-search|nicebot|noxtrumbot|nusearch spider|nutchcvs|nymesis|obot|oegp|omgilibot|omniexplorer_bot|oozbot|orbiter|pagebiteshyperbot|peew|polybot|pompos|postpost|psbot|pycurl|qseero|radian6|rampybot|rufusbot|sandcrawler|sbider|scoutjet|scrubby|searchsight|seekbot|semanticdiscovery|sensis web crawler|seochat::bot|seznambot|shim-crawler|shopwiki|shoula robot|silk|sitebot|snappy|sogou spider|sosospider|speedy spider|sqworm|stackrambler|suggybot|surveybot|synoobot|teoma|terrawizbot|thesubot|thumbnail.cz robot|tineye|truwogps|turnitinbot|tweetedtimes bot|twengabot|updated|urlfilebot|vagabondo|voilabot|vortex|voyager|vyu2|webcollage|websquash.com|wf84|wofindeich robot|womlpefactory|xaldon_webspider|yacy|yahoo! slurp|yahoo! slurp china|yahooseeker|yahooseeker-testing|yandexbot|yandeximages|yandexmetrika|yasaklibot|yeti|yodaobot|yooglifetchagent|youdaobot|zao|zealbot|zspider|zyborg|yahoo|abachobot|accoona|aciorobot|aspseek|cococrawler|dumbot|geonabot|lycos|scooter|altavista|idbot|estyle|adsbot|yahoobot|watchmouse|pingdom\.com/", $user_agent))
			$user = "WEBBOT";

		if (preg_match("/abilogicbot|link valet|link validity check|linkexaminer|linksmanager.com_bot|mojoo robot|notifixious|online link validator|ploetz + zeller|reciprocal link system pro|rel link checker lite|sitebar|vivante link checker|w3c-checklink|xenu link sleuth/", $user_agent))
			$user = "LINKBOT";

		if (preg_match("/awasu|bloglines|everyfeed-spider|feedfetcher-google|greatnews|gregarius|magpierss|nfreader|universalfeedparser/", $user_agent))
			$user = "FEEDBOT";

		return $user;
	}


	# =*|*=[ IP CHECK ]=*|*=
	public function ipCheck()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		if ($ip = "::1")
			$ip = "127.0.0.1";

		return $ip;
	}


	# =*|*=[ HOST CHECK ]=*|*=
	public function hostCheck()
	{
		$ip = $this->ipCheck();
		$host = gethostbyaddr($ip);

		return $host;
	}


	# =*|*=[ PASSWORD ENCRYPT ]=*|*=
	public function encrypt($value)
	{
		$cipher = sha1($value . $GLOBALS['CYPHER_KEY']);

		return $cipher;
	}


	# =*|*=[ REDIRECT URL ]=*|*=
	public function redirect($location)
	{
		return header("Location:{$location}");
	}


	# =*|*=[ TOKEN GENERATE ]=*|*=
	public function token()
	{
		$token = md5(uniqid(mt_rand(), true)) . '_' . rand(10000, 99999);

		return $token;
	}


	# =*|*=[ UNIQUE ID GENERATE ]=*|*=
	public function unique()
	{
		$unique = md5(uniqid(mt_rand()));

		return $unique;
	}


	# =*|*=[ PRODUCT ID GENERATE ]=*|*=
	public function productID()
	{
		$productID = substr('#' . strtoupper(md5(uniqid())), 0, 10);

		return $productID;
	}


	# =*|*=[ HTML Entities Encode ]=*|*=
	public function encode($string)
	{
		return trim(htmlentities($string));
	}


	# =*|*=[ HTML Entities Decode ]=*|*=
	public function decode($string)
	{
		return trim(htmlspecialchars_decode($string));
	}


	# =*|*=[ Access Control ]=*|*=
	public function __destruct()
	{
		$pageName = basename($_SERVER['PHP_SELF']);
		$allPages = ['dashboard.php', 'add-admin.php', 'admin-list.php'];
		$restricted = ['reset-password.php'];

		if (in_array($pageName, $allPages) && empty($_SESSION['auth_log_id'])) {
			$this->redirect('index');
		}

		if (empty($_SESSION['forgot_password_id'])) {
			if (in_array($pageName, $restricted)) {
				session_destroy();
				$this->redirect('index');
			}
		}
	}
}
