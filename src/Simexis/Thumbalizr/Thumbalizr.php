<?php namespace Simexis\Thumbalizr;


use Illuminate\Config\Repository;

class Thumbalizr {

	protected $config;

	public function __construct(Repository $config)
    {
        $this->config = $config;

	}


	public function getRequestUrl($url, $config = array()) {
		$config = array_merge($this->config->get('thumbalizr.defaults'), $config);

		$request_url=
			$this->config->get('thumbalizr.service_url')."?".
				"api_key=".$this->config->get('thumbalizr.api_key')."&".
				"quality=".$config['quality']."&".
				"width=".$config['width']."&".
				"encoding=".$config['encoding']."&".
				"delay=".$config['delay']."&".
				"mode=".$config['mode']."&".
				"bwidth=".$config['bwidth']."&".
				"bheight=".$config['bheight']."&".
				"url=".$url;

		return $request_url;
	}

	public function getCacheFileName($url, $config = array()) {
		$config = array_merge($this->config->get('thumbalizr.defaults'), $config);

		$local_cache_file=
			md5($url)."_".
			$config['bwidth']."_".
			$config['bheight']."_".
			$config['delay']."_".
			$config['quality']."_".
			$config['width'].".".
			$config['encoding'];

		return $this->getCacheDir() . $local_cache_file;
	}

	public function getPublicFileName($cache_filename) {
		return str_replace(public_path(), '', $cache_filename);
	}

    public function getCacheDir() {
        return rtrim($this->config->get('thumbalizr.local_cache_dir'), '/') . "/";
    }

	public function getThumbSrc($url, $config = array()) {
		$request_url = $this->getRequestUrl($url, $config);

		$cache_filename = $this->getCacheFileName($url, $config);

		if (file_exists($cache_filename)) {
			$filetime = filemtime($cache_filename);
			$cachetime = time()-$filetime-($this->config->get('thumbalizr.local_cache_expire')*60*60);
		} else {
			$cachetime = -1;
		}

		if (!file_exists($cache_filename) || $cachetime>=0) {
			$image = file_get_contents($request_url);
			$headers="";
			foreach($http_response_header as $tmp) {
		 		if (strpos($tmp,'X-Thumbalizr-')!==false) {
		 			$tmp1=explode('X-Thumbalizr-',$tmp); $tmp2=explode(': ',$tmp1[1]); $headers[$tmp2[0]]=$tmp2[1];
		 		}
			}
			if ($headers['Status']=="OK" && $this->save($image, $cache_filename))
				return $cache_filename;
		} else {
			return $cache_filename;
		}
		return null;
	}

	private function save($image, $filename) {
		if ($image && $this->config->get('thumbalizr.use_local_cache')===TRUE) {
			$dirname = dirname($filename);
			if (!file_exists($dirname)) {
				mkdir($dirname, 0777, true);
			}

            if(@file_put_contents($filename, $image))
                return true;
		}
        return false;
	}


}
