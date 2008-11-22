<?php

// pluginname Snazzy Archives
// shortname SnazzyArchives
// dashname snazzy-archives

/*
Plugin Name: Snazzy Archives
Version: 1.0
Plugin URI: http://www.prelovac.com/vladimir/wordpress-plugins/snazzy-archives
Author: Vladimir Prelovac
Author URI: http://www.prelovac.com/vladimir
Description: Express your site through unique representation of archive page.


*/
/*  
Copyright 2008  Vladimir Prelovac  (email : vprelovac@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Avoid name collisions.
if ( !class_exists('SnazzyArchives') ) :

class SnazzyArchives {
	
	// Name for our options in the DB
	var $SnazzyArchives_DB_option = 'SnazzyArchives_options';
	var $SnazzyArchives_options; 
	var $plugin_url;

	
	// Initialize WordPress hooks
	function SnazzyArchives() {	
		
		$this->plugin_url=trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
		$this->cache_path= ABSPATH .'wp-content/';
		
		// add shortcode handler
		add_shortcode('snazzy-archive', array(&$this, 'display'));	
		
		// Add Options Page
		add_action('admin_menu',  array(&$this, 'admin_menu'));
		add_action('wp_print_scripts',  array(&$this, 'ScriptsAction'));
		
		add_action( 'edit_post',  array(&$this,'delete_cache'));
		add_action( 'save_post',  array(&$this,'delete_cache')); 
	}

	// Hook the options mage
	function admin_menu() {
	
		add_options_page('Snazzy Archives Options', 'Snazzy Archives', 8, basename(__FILE__), array(&$this, 'handle_options'));
	
	} 


function ScriptsAction() 
{	
		global $post;
		
			if (!is_admin())
			{
			$options = $this->get_options();
			
			$pageid=$options['pageid'];
			
			// do not load scripts on this page
			if ($pageid && !is_page($pageid))
				return;	
			
			$mini=$options['mini'] ? 1 : 0;
			$fx=$options['fx'];
			
			if (isset($_GET['fx']))
				$fx=$_GET['fx'];
	
			$corners=$options['corners'] ? 1 : 0;
			
			// type the option into JavaScript variable snazzy_mini
			echo <<<END
<script type='text/javascript'>
/* <![CDATA[ */
	var snazzy_mini=$mini; var snazzy_fx=$fx; var snazzy_corners=$corners;
/* ]]> */
</script>
END;
			
			wp_enqueue_script('jquery');
		
			if ($fx==1)
				wp_enqueue_script('carousel', $this->plugin_url.'/i/jcarousellite_1.0.1.js', array('jquery')); 
			
			//wp_enqueue_script('mwh', $this->plugin_url.'/i/jquery.mousewheel.js', array('jquery')); 
			//wp_enqueue_script('ease', $snazzy_plugin_url.'/i/jquery-easing.1.3.js', array('jquery')); 
			//wp_enqueue_script('easecp', $snazzy_plugin_url.'/i/jquery-easing-compatibility.1.3.js', array('jquery')); 
	  	
	  	if ($corners)
	 			wp_enqueue_script('curvy', $this->plugin_url.'/i/jquery.corner.js', array('jquery'));   
			
			if ($fx==2)
				wp_enqueue_script('rotator', $this->plugin_url.'/i/rotator.js', array('jquery')); 
			
			wp_enqueue_script('snazzy', $this->plugin_url.'/snazzy-archives.js', array('jquery')); 
			
				
			
			echo '<link rel="stylesheet" href="'.$this->plugin_url.'/snazzy-archives.css" type="text/css" />'; 
		}
	
}
	function delete_cache()
	{
		@unlink($this->cache_path."snazzy_cache.htm");
	}
	
	// Handle our options
	function get_options() {
	   $options = array(		
			'fx' => '0',
			'years' => '2008#So far so good!',
			'layout' => 1,
			'mini' => '',
			'corners' => '',
			'posts' => 'on',
			'pages' => '',
			'fold' => 'on',			
			'reverse_months' => '',
			'showimages' => 'on',		
			'cache' => '',	
			'pageid' => 0	
		);

    $saved = get_option($this->SnazzyArchives_DB_option);

    if (!empty($saved)) {
        foreach ($saved as $key => $option)
            $options[$key] = $option;
    }           
    
    if ($saved != $options)
    	update_option($this->SnazzyArchives_DB_option, $options); 
    	
    return $options;
	}

	// Set up everything
	function install() {
		$SnazzyArchives_options = $this->get_options();		
		
	}

	function handle_options()
	{
		$options = $this->get_options();
		
		if ( isset($_POST['submitted']) ) {
			$options = array();
		//	print_r($_POST);
			
			$options['fx']=(int) $_POST['fx'];					
			$options['years']=htmlspecialchars($_POST['years']);		
			$options['layout']=(int) $_POST['layout'];		
			$options['mini']= $_POST['mini'];		
			$options['corners']= $_POST['corners'];	
			$options['showimages']= $_POST['showimages'];		
			$options['posts']= $_POST['posts'];		
			$options['pages']= $_POST['pages'];		
			$options['fold']= $_POST['fold'];		
			$options['reverse_months']= $_POST['reverse_months'];		
			$options['cache']= $_POST['cache'];	
			$options['pageid']=(int) $_POST['pageid'];	
				
			update_option($this->SnazzyArchives_DB_option, $options);
			
			$this->delete_cache();
			
			echo '<div class="updated fade"><p>Plugin settings saved.</p></div>';
		}

		
		

		$action_url = $_SERVER['REQUEST_URI'];	

		$fx=$options['fx'];
		$pageid=$options['pageid'];
		
		$layout=$options['layout'];
		$years=$options['years'];
		$corners=$options['corners']=='on'?'checked':'';
		$showimages=$options['showimages']=='on'?'checked':'';
		$mini=$options['mini']=='on'?'checked':'';
		$posts=$options['posts']=='on'?'checked':'';
		$pages=$options['pages']=='on'?'checked':'';
		$fold=$options['fold']=='on'?'checked':'';
		$reverse_months=$options['reverse_months']=='on'?'checked':'';
		$cache=$options['cache']=='on'?'checked':'';

		$writeable=is_writeable($this->cache_path);
		
		$imgpath=$this->plugin_url.'/i';	
		
		include('snazzy-archives-options.php');
	}
	
	
function GetExcerpt($text, $length = 15)
{
		if (!$length)
			return $text;
			
		$text = strip_tags($text);		
		$words = explode(' ', $text, $length + 1);
		if (count($words) > $length) {
			array_pop($words);
			array_push($words, '...');
			$text = implode(' ', $words);
		}	
		return $text;
}
	
	
	
	// piece together the flash code
function createflashcode($tagcloud){

	// get some paths
	$movie =$this->plugin_url.'/i/tagcloud.swf';
	$path = $this->plugin_url.'/i/';
	$width=1000;
	$height=750;
	$bgcolor='F8F8EC';
	$fgcolor='444444';
	$speed=100;
	// get the options
	$soname='so';
	// write flash tag
	$flashtag = '<!-- SWFObject embed by Geoff Stearns geoff@deconcept.com http://blog.deconcept.com/swfobject/ -->';	
	$flashtag .= '<script type="text/javascript" src="'.$path.'swfobject.js"></script>';
	$flashtag .= '<div id="sz_swf" style="text-align:center"><p style="display:none">'.urldecode($tagcloud).'</p><p>WP Cumulus Flash tag cloud by <a href="http://www.roytanck.com">Roy Tanck</a> requires Flash Player 7 or better.</p></div>';
	$flashtag .= '<script type="text/javascript">';
	$flashtag .= 'var rnumber = Math.floor(Math.random()*9999999);'; // force loading of movie to fix IE weirdness
	$flashtag .= 'var '.$soname.' = new SWFObject("'.$movie.'?r="+rnumber, "tagcloudflash", "'.$width.'", "'.$height.'", "7", "#'.$bgcolor.'");';
	if( $trans  ){
		$flashtag .= $soname.'.addParam("wmode", "transparent");';
	}
	$flashtag .= $soname.'.addParam("allowScriptAccess", "always");';
	$flashtag .= $soname.'.addVariable("tcolor", "0x'.$fgcolor.'");';
	$flashtag .= $soname.'.addVariable("tspeed", "'.$speed.'");';
	$flashtag .= $soname.'.addVariable("tagcloud", "'.urlencode('<tags>') . urlencode($tagcloud) . urlencode('</tags>').'");';
	$flashtag .= $soname.'.write("sz_swf");';
	$flashtag .= '</script>';
	return $flashtag;
}

	function display()
	{
			global $wpdb;
			
			$options=$this->get_options();
			
			$types=array();
			if ($options['posts'])
				array_push($types, "'post'");
			if ($options['pages'])
				array_push($types, "'page'");
				
			$cache=$options['cache'];
			$showimages=$options['showimages'];
				
				
				if ($cache) {
					// cache part
					$data = @file_get_contents($this->cache_path."snazzy_cache.htm");
					
					// return the cache data if it exists
					if ($data)
						return $data;
					}
		
				
			if (is_category() || is_tag() || is_day() || is_month() || is_year()) {
				global $posts;
			} else {

				
			$types=implode(',', $types);
				
			if ($options['reverse_months'])
				$oby='YEAR(post_date) DESC, post_date ';
			else 
				$oby='post_date DESC ';
			$query="SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_password = '' AND post_type IN ($types) ORDER BY ".$oby;
			
			

			
			$posts = $wpdb->get_results($query);
			}			
			
			
			if ($options['layout'])
				$layout=$options['layout'];
			else $layout=1;
			
			if ($options['fx'])
				$fx=$options['fx'];
			else $fx=0;
			
			if (isset($_GET['layout']))
				$layout=$_GET['layout'];
			
			
				
			if (isset($_GET['fx']))
				$fx=$_GET['fx'];
			
			if ($fx > 1)
				$fx=1;
			
			if ($layout<1)
				$layout=1;
			
			$result='';
			
	
			$curyear='';
			$curmonth='';
			$curday='';
			
			$first_for_day=1;
			
			
			
			if (!empty($options['years']))
			{
	
				$yrs = array();
				foreach (explode("\n", $options['years']) as $line) {
					list($year, $desc) = array_map('trim', explode("#", $line, 2));
					if (!empty($year)) $yrs[$year] = $desc;
				}
			
			}
			
			
			if ($fx=='1')
			{	
					$result.='
					<p><button id="szleft">&lt;</button> <button id="szright">&gt;</button></p>
					<div style="clear:both;"></div>
					<div class="snazzy">
						<div class="sz_carousel">
							<ul>';
			}
			else if ($fx=='2')
			{	
					$result.='
					
					<style type="text/css">
			
#x_axis {width:100%;position:absolute;top:50%;}
#y_axis {height:100%;position:absolute;left:50%;}
#links a {padding:0px;margin:0px;z-index:100;position:absolute;left:0px;top:0px;width:150px;}
#links a:hover {opacity:1;}
.snazzy {
	position:absolute;
	width:100%;
	height:600px;
	overflow:hidden;
}
.snazzy a {
	color:#000;
}
#wrap {
height:850px;
}
					</style>
			
					<div class="snazzy">
						<div id="x_axis">
  						 <div id="y_axis">
  						  <div id="links">';
			}
			else if ($fx=='3') {
				

						
					
						
					}
			else {
					$result.='
					<div class="snazzy">		
						<table cellspacing="15" cellpadding="0" border="0">
							<tbody>
								<tr>';
			}
			
			$count=0;
			


			
			foreach ($posts as $post) 

				{
			
					$title = $post->post_title;
					$excerpt= $this->GetExcerpt($post->post_content);
					$url=get_permalink($post->ID);
					$date = strtotime($post->post_date);
					
					$day = date('d', $date);		
					$month = date('M', $date);
					$year = date('Y', $date);
					
					
					$imageurl="";
					
					if ($showimages)
					{
						preg_match('/<\s*img [^\>]*src\s*=\s*[\""\']?([^\""\'>]*)/i' ,  $post->post_content, $matches);
						$imageurl=$matches[1];
						
						if (!$imageurl)
						{
							
							preg_match("/([a-zA-Z0-9\-\_]+\.|)youtube\.com\/watch(\?v\=|\/v\/)([a-zA-Z0-9\-\_]{11})([^<\s]*)/", $post->post_content, $matches2); 
						
							$youtubeurl=$matches2[0];
							if ($youtubeurl)
								//$imageurl=$this->plugin_url.'/i/video.png';
								$imageurl="http://i.ytimg.com/vi/{$matches2[3]}/0.jpg";	
				
						}
					}
					// get comments from WordPress database	
					$comments = $wpdb->get_results("
											SELECT *
											FROM $wpdb->comments 
											WHERE comment_approved = '1' AND comment_post_ID=$post->ID AND NOT (comment_type = 'pingback' OR comment_type = 'trackback')												
										");		
	
	
					$comcount=count($comments);
					
					if ($fx=='2')
					{
						
						$top=mt_rand(-200, 200);
						$left=mt_rand(-500, 500);
						$zind=mt_rand(-400, 400);
						$opacity=mt_rand(1000,2000)/1000.0;
						$size=0.85+$comcount/80.0;
						$x=$left;//mt_rand(-500,500);
						$y=$top;//mt_rand(-300,300);
						$z=$zind;//mt_rand(-400,400);
						
						// fx 2  only if comcount > 1
						
						if ($comcount >= 1)
						{
							if (0)//($imageurl)
							{
								if ($count++>20)
										continue;
								$result.='<a style="font-size: '.$size.'em; opacity: '.$opacity.';top: '.$top.'px; left: '.$left.'px; z-index:'.$zind.';" href="'.$url.'" title="'.$title.'" rel="x='.$x.'&amp;y='.$y.'&amp;z='.$z.'" ><img src="'.$imageurl.'" width="60" height="60" /></a>'."\n";
						  }
						  else
								$result.='<a style="font-size: '.$size.'em; opacity: '.$opacity.';top: '.$top.'px; left: '.$left.'px; z-index:'.$zind.';" href="'.$url.'" title="'.$comcount.' comments"  rel="x='.$x.'&amp;y='.$y.'&amp;z='.$z.'" >'.$title.'</a>'."\n";
						}
						continue;
					}		
					else if ($fx=='3')
					{
						if ($comcount>=1) {
							$size=5+$comcount/10;
							$result.='<a style="font-size: '.$size.'pt; " href="'.$url.'" title="'.$comcount.' comments"  rel="tag" >'.$title.'</a>'."\n";
						}
						continue;
					}			
					
					if ($year!=$curyear)
					{
						if ($curday)
							$result.="</div>";	
						
						$curday='';	
						if ($curmonth)
							$result.='</div></'.($fx?'li':'td').'>';
						
						$curmonth='';
						if ($options['fold'])						
							$result.= ($fx?'':'</tr><tr>').'<'.($fx?'li':'td valign="top"').'><div class="sz_date_yr">'.$year.'</div><div class="sz_cont">';
						else
							$result.= '<'.($fx?'li':'td valign="top"').'><div class="sz_date_yr">'.$year.'</div><div class="sz_cont">';

						
						if ($yrs[$year])
							$result.='<div class="sz_year">&#8220;'.$yrs[$year].'&#8221;</div>';
						$result.= '</div></'.($fx?'li':'td').'>';
						$curyear=$year;
					}
					
					if ($month!=$curmonth)
					{
						if ($curday)
							$result.="</div>";
						
						$curday='';
						
						if ($curmonth)
							$result.='</div></'.($fx?'li':'td').'>';							
						
						$result.= '<'.($fx?'li':'td valign="top"').'><div class="sz_date_mon">'.$month.'</div><div class="sz_month">';
						$curmonth=$month;
					}
					
					
					if ($day!=$curday)
					{
						if ($curday)
							$result.="</div>";
							
						$result.= '<div class="sz_date_day">'.$day.'</div><div class="sz_day">';
						$curday=$day;
						$first_for_day=1;
					}
				
					
						ob_start();
					  include('snazzy-layout-'.$layout.'.php');
						$output = ob_get_contents();
						ob_end_clean();
	
						$result.=$output;		
					
					
					$first_for_day=0;
				}	
	
					
				
				if ($fx=='1')
				{
						if ($curday)
							$result.="</div>";	
						
						$curday='';	
						if ($curmonth)
							$result.='</div></'.($fx?'li':'td').'>';
						
					$result.="</ul></div></div>";
				}
				else if ($fx=='2')
					$result.="</div></div></div></div>";
				else if ($fx=='3'){
					$result=	'<div class="snazzy" >'.$this->createflashcode($result).'</div>';
										
				}
				else
				{
					if ($curday)
							$result.="</div>";	
						
						$curday='';	
						if ($curmonth)
							$result.='</div></'.($fx?'li':'td').'>';
							
					$result.="</tr></tbody></table></div>";
				}			
			  $result.='<div style="margin-left:12px">created by <a href="http://www.prelovac.com/vladimir/wordpress-plugins/snazzy-archives">Snazzy Archives</a></div>';
					
			if ($cache)
				// write cache			
				@file_put_contents($this->cache_path."snazzy_cache.htm", $result);



			return $result;
			
	}





}

endif; 

if ( class_exists('SnazzyArchives') ) :
	
	$SnazzyArchives = new SnazzyArchives();
	if (isset($SnazzyArchives)) {
		register_activation_hook( __FILE__, array(&$SnazzyArchives, 'install') );
	}
endif;



	
?>