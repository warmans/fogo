<?php

include '../container.php';

class Ledger {
    var $name;
    function __construct($name){
        $this->name = $name;
    }
}

class Invoice {
	var $ledger;
    var $file;
	
	function __construct(Ledger $ledger, SplFileInfo $file) {
		$this->ledger = $ledger;
        $this->file = $file;
	}
}

/**
 * example2.php
 * 
 * Invoice depends on Ledger. 
 */

$container = new Container();

/*create the ledger*/
$container->addComponent('Ledger')
    ->addConstructor('Ledger #12345');
    
/*a random class*/
$container->addComponent('SplFileInfo')
    ->addConstructor(__FILE__);

/*the invoice*/
$container->addComponent('Invoice')
    ->addSharedConstructor('Ledger')
    ->addSharedConstructor('SplFileInfo');

$invoice = $container->getInstance('Invoice');

print_r($invoice);