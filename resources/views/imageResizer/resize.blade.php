<?php
// echo  base_path('/public/cache');
// die;
//error_reporting(E_ALL); ini_set('display_errors', '1'); 
function resize($imagePath, $opts = null, $chk = null){
	//echo $imagePath; die;
	$imagePath = urldecode($imagePath);
	if ($chk == null){
		$cacheFolder = base_path('public/cache/');
		//$cacheFolder = '../../../public/cache/';
	}else{
		$cacheFolder = base_path('public/cache/');
		//$cacheFolder = '../../../public/cache/';
	}
	$remoteFolder = $cacheFolder . 'remote/';
	$defaults = array(
		'crop' => false,
		'scale' => 'false',
		'thumbnail' => false,
		'maxOnly' => false,
		'canvas-color' => '#fff',
		'output-filename' => false,
		'cacheFolder' => $cacheFolder,
		'remoteFolder' => $remoteFolder,
		'quality' => 50,
		'cache_http_minutes' => 20
	);
	$opts = array_merge($defaults, $opts);
	$cacheFolder = $opts['cacheFolder'];
	$remoteFolder = $opts['remoteFolder'];
	$path_to_convert = 'convert';
	$purl  = parse_url($imagePath);
	$finfo = pathinfo($imagePath);
	$ext = $finfo['extension'];
	if (isset($purl['scheme']) && ($purl['scheme'] == 'http' || $purl['scheme'] == 'https')):
		list($filename) = explode('?', $finfo['basename']);
		$local_filepath = $remoteFolder . $filename;
		$download_image = true;
		if (file_exists($local_filepath)):
			if (filemtime($local_filepath) < strtotime('+' . $opts['cache_http_minutes'] . ' minutes')):
				$download_image = false;
			endif;
		endif;
		if ($download_image == true):
			$img = file_get_contents($imagePath);
			file_put_contents($local_filepath, $img);
		endif;
		$imagePath = $local_filepath;
	endif;
	if (file_exists($imagePath) == false):
		$imagePath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
		if (file_exists($imagePath) == false):
			return 'image not found';
		endif;
	endif;
	if (isset($opts['w'])):
		$w = $opts['w'];
	endif;
	if (isset($opts['h'])):
		$h = $opts['h'];
	endif;
	$filename = md5_file($imagePath);
	if (false !== $opts['output-filename']):
		$newPath = $opts['output-filename'];
	else:
		if (!empty($w) and !empty($h)):
			$newPath = $cacheFolder . $filename . '_w' . $w . '_h' . $h . (isset($opts['crop']) && $opts['crop'] == true ? '_cp' : '') . (isset($opts['scale']) && $opts['scale'] == true ? '_sc' : '') . '.' . $ext;
		elseif (!empty($w)):
			$newPath = $cacheFolder . $filename . '_w' . $w . '.' . $ext;
		elseif (!empty($h)):
			$newPath = $cacheFolder . $filename . '_h' . $h . '.' . $ext;
		else:
			return false;

		endif;

	endif;

    
	$create = true;

	if (file_exists($newPath) == true):

		$create = false;

		$origFileTime = date('YmdHis', filemtime($imagePath));

		$newFileTime = date('YmdHis', filemtime($newPath));

		if ($newFileTime < $origFileTime):

			$create = true;

		endif;

	endif;


	if ($create == true):

		if (!empty($w) and !empty($h)):

			list($width, $height) = getimagesize($imagePath);

			$resize = $w;

			if ($width > $height):

				$resize = $w;

				if (true === $opts['crop']):

					$resize = 'x' . $h;

				endif;

			else:

				$resize = 'x' . $h;

				if (true === $opts['crop']):

					$resize = $w;

				endif;

			endif;

			if (true === $opts['scale']):

				$cmd = $path_to_convert . ' ' . escapeshellarg($imagePath) . ' -resize ' . escapeshellarg($resize) . ' -quality ' . escapeshellarg($opts['quality']) . ' ' . escapeshellarg($newPath);

			else:

				$cmd = $path_to_convert . ' ' . escapeshellarg($imagePath) . ' -resize ' . escapeshellarg($resize) . ' -size ' . escapeshellarg($w . 'x' . $h) . ' xc:' . escapeshellarg($opts['canvas-color']) . ' +swap -gravity center -composite -quality ' . escapeshellarg($opts['quality']) . ' ' . escapeshellarg($newPath);  

			endif;

		else:

			$cmd = $path_to_convert . ' ' . escapeshellarg($imagePath) . ' -thumbnail ' . (!empty($h) ? 'x' : '') . $w . '' . (isset($opts['maxOnly']) && $opts['maxOnly'] == true ? '\>' : '') . ' -quality ' . escapeshellarg($opts['quality']) . ' ' . escapeshellarg($newPath);

		endif;
			//return $cmd; die;
	$output = ''; $return_code = 0;

		$c = exec($cmd, $output, $return_code);

		if ($return_code != 0)

			{

			error_log('Tried to execute:$cmd,return code:$return_code,output: ' . print_r($output, true));

			return false;

			}

	endif;

	return str_replace($_SERVER['DOCUMENT_ROOT'], '', $newPath);

} 
?>