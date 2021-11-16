<?php
class Sendinblue {
    
    public $apikey = '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
';

	public function __construct() {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
	}

	function blue_send(){
		require '../vendor/autoload.php';
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->apikey);

		$apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
		    new GuzzleHttp\Client(),
		    $config
		);
		$sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail();
		$sendSmtpEmail['subject'] = 'My {{params.subject}}';
		$sendSmtpEmail['htmlContent'] = '<html><body><h1>This is a transactional email {{params.parameter}}</h1></body></html>';
		$sendSmtpEmail['sender'] = array('name' => 'Matias Basile', 'email' => 'matias.basile@varcreative.com');
		$sendSmtpEmail['to'] = array(
		    array('email' => 'matuschettino@gmail.com', 'name' => 'Matias Schettino')
		);
		$sendSmtpEmail['cc'] = array(
		    array('email' => 'example2@example2.com', 'name' => 'Janice Doe')
		);
		$sendSmtpEmail['bcc'] = array(
		    array('email' => 'example@example.com', 'name' => 'John Doe')
		);
		//$sendSmtpEmail['replyTo'] = array('email' => 'replyto@domain.com', 'name' => 'John Doe');
		//$sendSmtpEmail['headers'] = array('Some-Custom-Name' => 'unique-id-1234');
		$sendSmtpEmail['params'] = array('parameter' => 'My param value', 'subject' => 'New Subject');

		try {
		    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
		    print_r($result);
		} catch (Exception $e) {
		    echo 'Exception when calling TransactionalEmailsApi->sendTransacEmail: ', $e->getMessage(), PHP_EOL;
		}

	}
}
?>