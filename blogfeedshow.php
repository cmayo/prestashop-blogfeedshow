<?php
if (!defined('_PS_VERSION_'))
	exit ;

class Blogfeedshow extends Module {
	public function __construct() {
		$this -> name = 'blogfeedshow';
		$this -> tab = 'front_office_features';
		$this -> version = .1;
		$this -> author = 'Carlos Mayo';
		$this -> need_instance = 0;

		parent::__construct();

		$this -> displayName = $this -> l('Blog Feed Show');
		$this -> description = $this -> l('Show a list with the image and link for each post of a blog feed');
	}

	public function install() {
		if (parent::install() == false OR !$this -> registerHook('home'))
			return false;
		return true;
	}

	public function hookHome($params) {
		global $smarty, $cookie;
		
		Tools::enableCache();
		$smarty->cache_lifetime = 3600; // 1 hora
		
		$months = array();
		if($cookie->id_lang == 1)
			$months = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
		
		if (!$this->isCached('blogfeedshow.tpl'))
		{		
			require_once('resize.php');
			
			$feed = file_get_contents('http://www.cuartocolor.es/blog/feed');
			$xml = simplexml_load_string($feed);
			
			$entries = array();
			
			for ($i=0; $i<4; $i++) {
				$item=$xml->channel->item[$i];
				
				$images = array();
				$content = $item->children("content", true);
				preg_match('!http://[a-zA-Z0-9\-\_\.\/\%]+\.(?:jpe?g|png|gif)!Ui' , $content->encoded , $images);
				
				$image = '';
				if($i==0) {
					if (count($images)) {
						$mythumb = new resize($images[0]);
						$mythumb->resizeImage(439, 247, 'crop');
						$fileimage = $mythumb->getfilenameCache();				
						$image = _THEME_DIR_.'cache/'.$fileimage;
					}
				}
				
				$entries[$i] = array(
					'id'			=> $i+1,
					'title'			=> $item->title,
					'link'			=> $item->link,
					'image'			=> $image,
					'day'			=> date('d', strtotime($item->pubDate)),
					'month'			=> $cookie->id_lang == 1 ? $months[date('n', strtotime($item->pubDate))] : date('F', strtotime($item->pubDate)),
					'year'			=> date('Y', strtotime($item->pubDate)),
					'description'	=> $item->description,
					'full'			=> $item,
				);
			}		
			
			$smarty->assign(array('entries' => $entries));
		}
			
		$display = $this->display(__FILE__, 'blogfeedshow.tpl');
		$smarty->cache_lifetime = 31536000; // 1 Year

		Tools::restoreCacheSettings();		
		return $display;
	}
	
	public function getContent()
	{
		$output = 'X';
		return $output;
	}

}
