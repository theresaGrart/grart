<?php
/**
 * @package		jCart
 * @copyright	Copyright (C) 2009 - 2012 softPHP,http://www.soft-php.com
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class ModelToolImage extends Model {
	public function resize($filename, $width, $height) {
		if(defined("MAIN_HTTP_SERVER")){
			/* if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename) || ($this->filemtime_remote(MAIN_HTTP_SERVER."components/com_opencart/image/" . $filename) > filemtime(DIR_IMAGE . $filename)) || ($this->filemtime_remote(MAIN_HTTP_SERVER."image/" . $filename) > filemtime(DIR_IMAGE . $filename)) ) {
			*/
			if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
				if(!@copy(MAIN_HTTP_SERVER."components/com_opencart/image/" . $filename, DIR_IMAGE . $filename)){
					@copy(MAIN_HTTP_SERVER."image/" . $filename, DIR_IMAGE . $filename);
                                    //@copy(JPATH_SITE."media".DS."uploaded_artwork".DS. $filename, DIR_IMAGE . $filename);
				}
			}
		}
		if (!file_exists(DIR_IMAGE . $filename) || !is_file(DIR_IMAGE . $filename)) {
			return;
		} 
		
		$info = pathinfo($filename);
		$extension = $info['extension'];
		
		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;
		
		if (!file_exists(DIR_IMAGE . $new_image) || (filemtime(DIR_IMAGE . $old_image) > filemtime(DIR_IMAGE . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}		
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}	
	}
	public function filemtime_remote($uri)
	{
		$uri = parse_url($uri);
		$handle = @fsockopen($uri['host'],80);
		if(!$handle)
			return 0;
	
		fputs($handle,"GET $uri[path] HTTP/1.1\r\nHost: $uri[host]\r\n\r\n");
		$result = 0;
		while(!feof($handle))
		{
			$line = fgets($handle,1024);
			if(!trim($line))
				break;
	
			$col = strpos($line,':');
			if($col !== false)
			{
				$header = trim(substr($line,0,$col));
				$value = trim(substr($line,$col+1));
				if(strtolower($header) == 'last-modified')
				{
					$result = strtotime($value);
					break;
				}
			}
		}
		fclose($handle);
		return $result;
	}
}
?>