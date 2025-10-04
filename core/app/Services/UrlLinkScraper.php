<?php

// app/Services/UrlLinkScraper.php
namespace App\Services;
use Image;

use Illuminate\Http\Request;

class UrlLinkScraper
{
    public function fetch($urlLink)
    {
		if(isset($_POST['image']))
		{
			//die($_POST['image']);
			
			$image = $_POST['image'];
			
			$opts = array('http' => array(
			  'method' => "GET",
			  'timeout' => 10,
			  'header' => array(
				"user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36",
			  )
			));
			$context = stream_context_create($opts);
			
			//die($image);

            if($imgcnt = @file_get_contents($image,FALSE, $context))
			{
				$ext = pathinfo(
				parse_url($image, PHP_URL_PATH), 
				PATHINFO_EXTENSION
				); 
				
				if($ext=='') $ext = 'jpg';
				
				//die($ext);
				
				
				//if($ext == 'gif' || $ext == 'png' || $ext == 'jpg'|| $ext == 'jpeg' )
				//{
            		$path = 'assets/front/content/' . time() . 'image.' . $ext;//substr($image, -3);
					
					@file_put_contents($path, $imgcnt);
					
					$tw_image = explode('/content/',$path);
			
					// open file a image resource
					$img = Image::make($path);
					
				
					$img->resize(600, null, function ($constraint) {
						$constraint->aspectRatio();
					});

					//die($tw_image[1]);

					$ext = pathinfo(
						parse_url(@$tw_image[1], PHP_URL_PATH), 
						PATHINFO_EXTENSION
						); 

					//if($ext == 'gif' || $ext == 'png' || $ext == 'jpg'|| $ext == 'jpeg' )
								$img->save('assets/front/content/twitter_'.@$tw_image[1] );
					
				
				//}
				
				
				die('https://'.$_SERVER['SERVER_NAME'].'/'.$path);
				
			}
			
			
			die('fail');
			
			
		}
		
		if (in_array("Content-Type: application/pdf", get_headers($urlLink))) {
			exit;
		}

        $tags = @get_meta_tags($urlLink);
		//die(print_r($tags));

        if (isset($tags['twitter:image']) && $tags['twitter:image'] != '') {
            $image = $tags['twitter:image'];
        } else if (isset($tags['og:image']) && $tags['og:image'] != '') {
            $image = $tags['og:image'];
        } else if (isset($tags['image']) && $tags['image'] != '') {
            $image = $tags['image'];
        } else {
            $image = "";
        }

        if (isset($tags['twitter:title']) && $tags['twitter:title'] != '') {
            $title = $tags['twitter:title'];
        } else if (isset($tags['og:title']) && $tags['og:title'] != '') {
            $title = $tags['og:title'];
        } else if (isset($tags['title']) && $tags['title'] != '') {
            $title = $tags['title'];
        } else {
            $title = "";
        }

        if (isset($tags['twitter:description']) && $tags['twitter:description'] != '') {
            $description = $tags['twitter:description'];
        } else if (isset($tags['og:description']) && $tags['og:description'] != '') {
            $description = $tags['og:description'];
        } else if (isset($tags['description']) && $tags['description'] != '') {
            $description = $tags['description'];
        } else {
            $description = "";
        }




		 $html = new \DOMDocument();

			$ch = curl_init();
			//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
			curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com');
			curl_setopt($ch, CURLOPT_AUTOREFERER, true); 
		
			curl_setopt($ch, CURLOPT_NOBODY, false); 
		
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		
		
		
			curl_setopt($ch, CURLOPT_COOKIE, '__cfduid=d8af70c3b49361a5a1b818e91171e598d1431355518; cf_clearance=5857af9797c612cde4ac590fe900e0e9f3d7098f-1431355526-57600; PHPSESSID=eefc5d29f6cea1ddb70ca5a0baaf60e1');
			//$cookie_jar = tempnam('/tmp','cookie'); 
			//curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar); 
		
			$headervar = array(
						'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
						'Accept-Language: en-US,en;q=0.5',
						'Connection: keep-alive',
						'Upgrade-Insecure-Requests: 1',
				);
		
			//curl_setopt($ch, CURLOPT_HEADER, false); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headervar); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY); 
		
			curl_setopt($ch,CURLOPT_URL,$urlLink);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36");
			$data = curl_exec($ch);
			curl_close($ch);
			@$html->loadHTML($data);

			/*$opts = array('http' => array(
			  'method' => "GET",
			  'timeout' => 10,
			  'header' => array(
				"user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36",
			  )
			));
			$context = stream_context_create($opts);
			@$html->loadHTML(file_get_contents($urlLink,FALSE, $context));
			*/

			//@$html->loadHTML(file_get_contents($urlLink));

			//Get all meta tags and loop through them.
			//print_r($html->getElementsByTagName('meta'));
		//die("image 2".$image);

		//die(print_r($html));
		
		//die(print_r($html->getElementsByTagName('meta')));

			foreach($html->getElementsByTagName('meta') as $meta) {
				if ($meta->hasAttribute('property') && 	strpos($meta->getAttribute('property'), 'og:') === 0) {
					if($meta->getAttribute('property')=='og:image' && $image==''){
						$image = $meta->getAttribute('content');
					}
					if($meta->getAttribute('property')=='og:title'){
						$title = $meta->getAttribute('content');
					}
					elseif($meta->getAttribute('property')=='title')
						$title = $meta->getAttribute('content');


					if($meta->getAttribute('property')=='og:description'){
						$description = $meta->getAttribute('content');

					}
					elseif($meta->getAttribute('property')=='content')
						$description = $meta->getAttribute('content');


				}

				if ($meta->hasAttribute('property') && 	strpos($meta->getAttribute('property'), 'twitter:') === 0) {
					if($meta->getAttribute('property')=='twitter:image' && $image==''){
						$image = $meta->getAttribute('content');
					}
					if($meta->getAttribute('property')=='twitter:title'){
						$title = $meta->getAttribute('content');
					}
					elseif($meta->getAttribute('property')=='title')
						$title = $meta->getAttribute('content');


					if($meta->getAttribute('property')=='twitter:description'){
						$description = $meta->getAttribute('content');

					}
					elseif($meta->getAttribute('property')=='content')
						$description = $meta->getAttribute('content');


				}
			}

			//die('desc ' .$description);
		//die("image 3".$image);
		if($title=='')
		{
			$list = $html->getElementsByTagName("title");
			if ($list->length > 0) {
				$title = $list->item(0)->textContent;
			}
		}
		
		$replace = array(
				"'" => "'",
				"'" => "'",
				'"' => '"',
				'"' => '"',
				"–" => "-",
				"—" => "-",
				"…" => "&#8230;"
			);
		
		foreach($replace as $k => $v)
		{
			$title = str_replace($k, $v, $title);
		}

		 $title = preg_replace('/[^\x20-\x7E]*/','', $title);

     
		
		//$title = str_replace($search, $replace, $title);
		
		//die('image'.$image);

		if($image=='')//at this point, let's look for the logo
		{
			$list = $html->getElementsByTagName("img");
			if ($list->length > 0) {
				foreach ($list as $images) {
				  $checkImage = $images->getAttribute('src');
					if(strstr(strtolower($checkImage),'logo'))
					{
						$image = $images->getAttribute('src');
						//exit();
					}
				}

				//$image = $list->item(0)->getAttribute('src');
			}
		}

		$image = urldecode($image);
		
		//die(urldecode($image));
        $html = '<div >';




		if(strstr($image,'https://') || strstr($image,'https://'))
		{

		}
		else
		{
			$urlresult = parse_url($urlLink);
			$image = $urlresult['scheme']."://".$urlresult['host'].'/'.$image;
			//die($image);
			

		}

		$headers = get_headers($image, 1);

		//die(print_r($headers));
		//die($image);
        if (@is_array(getimagesize($image)) && $image != '' && $image !='https://' && $image !='https://' && (strstr($headers[0],'OK') || strstr($headers[0],'301'))  ) { //$headers[0] == 'HTTP/1.1 200 OK'



			$opts = array('http' => array(
			  'method' => "GET",
			  'timeout' => 10,
			  'header' => array(
				"user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36",
			  )
			));
			$context = stream_context_create($opts);
			
			//die($image);

            if($imgcnt = @file_get_contents($image,FALSE, $context))
			{
				$ext = pathinfo(
				parse_url($image, PHP_URL_PATH), 
				PATHINFO_EXTENSION
				); 
				
				//die($ext);
				
				
				if($ext == 'gif' || $ext == 'png' || $ext == 'jpg'|| $ext == 'jpeg' )
				{
            		$path = 'assets/front/content/' . time() . 'image.' . $ext;//substr($image, -3);
					
					@file_put_contents($path, $imgcnt);
					
					$tw_image = explode('/content/',$path);
			
					// open file a image resource
					$img = Image::make($path);
					
					//	die($path);

					// crop image
					//$img->crop(120, 120, 25, 25);
					//$img->resize(120, null);

					$img->resize(600, null, function ($constraint) {
						$constraint->aspectRatio();
					});

					//die($tw_image[1]);

					$ext = pathinfo(
						parse_url($tw_image[1], PHP_URL_PATH), 
						PATHINFO_EXTENSION
						); 

					if($ext == 'gif' || $ext == 'png' || $ext == 'jpg'|| $ext == 'jpeg' )
								$img->save('assets/front/content/twitter_'.$tw_image[1] );
					
				
				}
				else
				{
					
					
					$path = $image;
					
					@file_put_contents($path, $imgcnt);
					
					$img = Image::make($path);

				
					$img->resize(600, null, function ($constraint) {
						$constraint->aspectRatio();
					});

					

					$ext = pathinfo(
						parse_url($path, PHP_URL_PATH), 
						PATHINFO_EXTENSION
						); 
					//die($ext);
					//die($path);
					if($ext == 'gif' || $ext == 'png' || $ext == 'jpg'|| $ext == 'jpeg' )
								$img->save('assets/front/content/twitter_'.$path );
					
				}
				
				
				
			}
			else
			{
				$path = $image;
				//die($path);
			}
			
			//die($path);
			
			

				//https://www.sciencedaily.com/releases/2019/04/190410095939.htm
           // if(file_exists($image))
			//if(@is_array(getimagesize($image)))
			//die($image . ' - '.$path);
            	$html .= '<p class="article-img"><a href="/ajaxpage?url=' . $urlLink . '" rel="modal:open"><img src="'.((strstr($path,'https://') || strstr($path,'https://'))?$path:'/' . $path ). '" style="width:100%;"></a></p>';
        }
        $html .= '</div>';
        $html .= '<div >';
        if ($title != '') {
            $html .= '<a href="/ajaxpage?url=' . $urlLink . '" rel="modal:open"><h2>' . $title . '</h2>';
        }
        if ($description != '') {
            $html .= '<p>' . substr($description, 0, 90) . '...</p>';
        }
        $html .= '</a></div>';
        echo $html . '!~' . $urlLink;
        
        return $html;
    }
}
