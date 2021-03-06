<?php

/**
 * SAMPLE - Displays the standing orders
 */

require '../vendor/autoload.php';

class testLogger extends Psr\Log\AbstractLogger {
	
	public function log($level, $message, array $context = array()): void {
		file_put_contents(__DIR__."/standingOrders.log", file_get_contents(__DIR__."/standingOrders.log")."[". strtoupper(substr($level, 0, 1))."] ".$message."\n");
	}

}
use Fhp\FinTs;

file_put_contents(__DIR__."/standingOrders.log", "");

define('FHP_BANK_URL', '');                # HBCI / FinTS Url can be found here: https://www.hbci-zka.de/institute/institut_auswahl.htm (use the PIN/TAN URL)
define('FHP_BANK_PORT', 443);              # HBCI / FinTS Port can be found here: https://www.hbci-zka.de/institute/institut_auswahl.htm
define('FHP_BANK_CODE', '');               # Your bank code / Bankleitzahl
define('FHP_ONLINE_BANKING_USERNAME', ''); # Your online banking username / alias
define('FHP_ONLINE_BANKING_PIN', '');      # Your online banking PIN (NOT! the pin of your bank card!)

$fints = new FinTs(
    FHP_BANK_URL,
    FHP_BANK_PORT,
    FHP_BANK_CODE,
    FHP_ONLINE_BANKING_USERNAME,
    FHP_ONLINE_BANKING_PIN,
	new testLogger()
);

$accounts = $fints->getSEPAAccounts();

$orders = $fints->getSEPAStandingOrders($accounts[0]);

$fints->end();
var_dump($orders);