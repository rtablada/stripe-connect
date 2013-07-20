<?php namespace Rtablada\StripeConnect;

use Rtablada\SlimPost\SlimPost;
use Illuminate\Config\Repository as Config;

class StripeConnect
{
	protected $config;
	protected $attributes;
	protected $url = 'https://connect.stripe.com/oauth/token';

	public function __construct(Config $config)
	{
		$this->config = $config;
		$this->attributes = array(
			'client_secret' => $this->config->get('stripe.app_client_id'),
			'grant_type' => 'authorization_code',
		);
	}

	public function setCode($code)
	{
		$this->attributes['code'] = $code;
	}

	public function getToken()
	{
		$poster = new SlimPost($url, $this->attributes);

		return json_decode($poster->send(), true);
	}

	public function getTokenWithCode($code)
	{
		$this->setCode($code);
		return $this->getToken();
	}
}
