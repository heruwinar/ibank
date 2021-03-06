<?php
/**
 * This file is part of the IBank library.
 *
 * (c) Edi Septriyanto <me@masedi.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace IBank\IBParser;

use IBank\Utils\HttpRequest as HttpRequest;
use IBank\Utils\HttpHelper as HttpHelper;
use IBank\Utils\HtmlParser as HtmlParser;
use IBank\Utils\Function as Function;

class SampleBankParser extends AbstractIBParser
{
	protected $host = 'ib.samplebank.co.id';

	protected $headers = [];

	protected $options = [];

	public function __construct()
	{
		// init request header (if required)
		$this->headers = [
			"connection: keep-alive",
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
		];

		// init http request (curl) options
		$this->options = [
			CURLOPT_URL => '',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1
		];

		// init http request object
		$this->http = new HttpRequest();

		// init html html parser object
		$this->htmlp = new HtmlParser();
	}

	public function login($username='', $password='', $account='', $corpid='')
	{
		// prevent multiple logged in
		if ($this->loggedin) {
			return true;
		}

		// overwrite credentials
		if ($username != '' && $password != '') {
			$this->setCredentials($username, $password, $account, $corpid);
		}

 		// TO DO: do login process, get cookie session / login status from IB host, api server, etc
		$this->loggedin = true;
		
		// if logged in, add response cookie to _session (if required)
		if ($this->loggedin) {
			$this->_session = $this->http->getResponseCookie();
		}

		return $this->loggedin;
	}
	
	public function getBalance()
	{
		// balance
		$balance = 0;
		
		// retry login if logged in status is false
		if (! $this->loggedin) {
			$this->login();
		}

		// TO DO: get balance data from page scrapping, api, etc

		return (float)$balance;
	}
	
	/**
	 * Get Transactions for date range from $start date to $end date, 
	 * transaction type $type; % (all), credit, debit.
	 * Date format d/m/Y
	 */
	public function getTransactions($start = '1/1/2017', $end = '30/1/2017', $type = '%')
	{
		// retry login if logged in status false
		if (! $this->loggedin) {
			$this->login();
		}

		// transaction list saved as array
		$transactions = [];

		// TO DO: get transactions data from page scrapping, api, etc

		return $transactions;
	}
	
	public function logout()
	{
		// TO DO: do logout process, hit the logout page, clear session, etc

		// reset cookie session (if required)
		$this->_session = '';

		// reset logged in status
		$this->loggedin = false;
	}
}
