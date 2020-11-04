<?php
require "vendor/autoload.php";
/*
use Web3\Web3;

$web3 = new Web3('https://rinkeby.infura.io/v3/f6e4a36f88164beb9d5cf86f437a2fe2');
var_dump($web3);
*/

/*
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;

$web3 = new Web3(new HttpProvider(new HttpRequestManager('https://rinkeby.infura.io/v3/f6e4a36f88164beb9d5cf86f437a2fe2', 5.0)));
$web3->clientVersion(function ($err, $version) {
    if ($err !== null) {
        // do something
        var_dump($err);
        return;
    }
    if (isset($version)) {
        echo 'Client version: ' . $version;
    }
});

*/
use Web3\Web3;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Contract;
use Web3\Utils;
use Web3\Formatters\IntegerFormatter;
use phpseclib\Math\BigInteger as BigNumber;
$web3 = new Web3(new HttpProvider(new HttpRequestManager('https://rinkeby.infura.io/v3/xxxxxxxxxxxxxxx', 5.0)));
$bytecode = "0x6080604052662386f26fc100006001556000600281905580546001600160a01b0319163317905561094f806100356000396000f3fe6080604052600436106100a75760003560e01c8063860c851a11610064578063860c851a146102d05780638da5cb5b146102e557806395d89b4114610316578063a9a981a31461032b578063c71daccb14610340578063f2fde38b14610355576100a7565b80630121b93f146100a957806306fdde03146100c6578063100457af146101505780633477ee2e1461018c5780633ccfd60b1461023b578063681f90de14610250575b005b6100a7600480360360208110156100bf57600080fd5b5035610388565b3480156100d257600080fd5b506100db6103c9565b6040805160208082528351818301528351919283929083019185019080838360005b838110156101155781810151838201526020016100fd565b50505050905090810190601f1680156101425780820380516001836020036101000a031916815260200191505b509250505060405180910390f35b34801561015c57600080fd5b5061017a6004803603602081101561017357600080fd5b50356103f4565b60408051918252519081900360200190f35b34801561019857600080fd5b506101b6600480360360208110156101af57600080fd5b5035610406565b60405180806020018360ff1660ff168152602001828103825284818151815260200191508051906020019080838360005b838110156101ff5781810151838201526020016101e7565b50505050905090810190601f16801561022c5780820380516001836020036101000a031916815260200191505b50935050505060405180910390f35b34801561024757600080fd5b506100a76104bc565b34801561025c57600080fd5b506100a76004803603604081101561027357600080fd5b81019060208101813564010000000081111561028e57600080fd5b8201836020820111156102a057600080fd5b803590602001918460018302840111640100000000831117156102c257600080fd5b91935091503560ff1661054e565b3480156102dc57600080fd5b5061017a6106d5565b3480156102f157600080fd5b506102fa6106db565b604080516001600160a01b039092168252519081900360200190f35b34801561032257600080fd5b506100db6106ea565b34801561033757600080fd5b5061017a610709565b34801561034c57600080fd5b5061017a61070f565b34801561036157600080fd5b506100a76004803603602081101561037857600080fd5b50356001600160a01b031661076b565b60015434101561039757600080fd5b6000818152600460205260409020546103b790600163ffffffff61086c16565b60009182526004602052604090912055565b6040518060400160405280600f81526020016e43616e646964617465566f74696e6760881b81525081565b60046020526000908152604090205481565b6003818154811061041357fe5b60009182526020918290206002918202018054604080516001831615610100026000190190921693909304601f8101859004850282018501909352828152909350918391908301828280156104a95780601f1061047e576101008083540402835291602001916104a9565b820191906000526020600020905b81548152906001019060200180831161048c57829003601f168201915b5050506001909301549192505060ff1682565b6000546001600160a01b03163314610511576040805162461bcd60e51b815260206004820152601360248201527226bab9ba1031b7b73a3930b1ba1037bbb732b960691b604482015290519081900360640190fd5b600080546040516001600160a01b03909116914780156108fc02929091818181858888f1935050505015801561054b573d6000803e3d6000fd5b50565b6000546001600160a01b031633146105a3576040805162461bcd60e51b815260206004820152601360248201527226bab9ba1031b7b73a3930b1ba1037bbb732b960691b604482015290519081900360640190fd5b600060016003604051806040016040528087878080601f016020809104026020016040519081016040528093929190818152602001838380828437600092018290525093855250505060ff8716602092830152835460018101808655948252908290208351805160029093029091019261062292849290910190610882565b50602091909101516001918201805460ff191660ff909216919091179055600254929091039250610653919061086c565b6002819055507fae0e51d3e80be2eeb71657a79290203425f4e48ce8ac0e48bbd795710ed405628185858560405180858152602001806020018360ff1660ff1681526020018281038252858582818152602001925080828437600083820152604051601f909101601f191690920182900397509095505050505050a150505050565b60015481565b6000546001600160a01b031681565b6040518060400160405280600381526020016210d59560ea1b81525081565b60025481565b600080546001600160a01b03163314610765576040805162461bcd60e51b815260206004820152601360248201527226bab9ba1031b7b73a3930b1ba1037bbb732b960691b604482015290519081900360640190fd5b50475b90565b6000546001600160a01b031633146107c0576040805162461bcd60e51b815260206004820152601360248201527226bab9ba1031b7b73a3930b1ba1037bbb732b960691b604482015290519081900360640190fd5b6001600160a01b038116610811576040805162461bcd60e51b815260206004820152601360248201527226bab9ba1031b7b73a3930b1ba1037bbb732b960691b604482015290519081900360640190fd5b600080546040516001600160a01b03808516939216917f8be0079c531659141344cd1fd0a4f28419497f9722a3daafe3b4186f6b6457e091a3600080546001600160a01b0319166001600160a01b0392909216919091179055565b60008282018381101561087b57fe5b9392505050565b828054600181600116156101000203166002900490600052602060002090601f016020900481019282601f106108c357805160ff19168380011785556108f0565b828001600101855582156108f0579182015b828111156108f05782518255916020019190600101906108d5565b506108fc929150610900565b5090565b61076891905b808211156108fc576000815560010161090656fea265627a7a72315820899902036feaa75c26a2f37047981da02778c5fab57944419303b58d1893ad8564736f6c63430005110032";
$abi = '[{"anonymous":false,"inputs":[{"indexed":false,"internalType":"uint256","name":"candidateId","type":"uint256"},{"indexed":false,"internalType":"string","name":"name","type":"string"},{"indexed":false,"internalType":"uint8","name":"age","type":"uint8"}],"name":"NewCandidate","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"previousOwner","type":"address"},{"indexed":true,"internalType":"address","name":"newOwner","type":"address"}],"name":"OwnershipTransferred","type":"event"},{"payable":true,"stateMutability":"payable","type":"fallback"},{"constant":true,"inputs":[],"name":"candidateCount","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"internalType":"uint256","name":"","type":"uint256"}],"name":"candidateVoteTimes","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"internalType":"uint256","name":"","type":"uint256"}],"name":"candidates","outputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"uint8","name":"age","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"checkBalance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"string","name":"_name","type":"string"},{"internalType":"uint8","name":"_age","type":"uint8"}],"name":"createCandidate","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"internalType":"address payable","name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"address payable","name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"uint256","name":"_candidateId","type":"uint256"}],"name":"vote","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"constant":true,"inputs":[],"name":"votePrice","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"withdraw","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"}]';
$contract = new Contract($web3->provider, $abi);
//var_dump($contract);die;

$contractAddress = "0x156be41ce89ba0c82b12bca72527dab1028e7af9";
$fromAccount = "0x07dC45c241CeEd12961d9aBd6aBB83Fe4B53ab27";
/*
// call contract function
$contract->at($contractAddress)->call("candidateCount", null, function($err, $result) {
    if ($err !== null) {
        var_dump($err->getMessage());
    }
    if (isset($result)) {
        var_dump($result[0]->value);die;
        //$bn = Utils::toBn($result);
        //var_dump($bn->toString());
    }
});
*/
/*
// test for estimate gas
$contract->at($contractAddress)->estimateGas("transferOwnership", $fromAccount, [
    'from' => $fromAccount,
    'gas' => '0x200b20'
], function ($err, $result) {
    if ($err !== null) {
        var_dump($err->getMessage());die;
    }
    if (isset($result)) {
        echo "\nEstimate gas: " . $result->toString() . "\n";
        die;
    }
});
die;
*/
/*
//infura是公共节点，不知道你的私钥，无法直接交易，getdata然后sendRawTransaction
//$wei = Utils::toWei('1', 'kwei'); 
//$wei->toString(); // 1000
$contract->at($contractAddress)->send('vote', Utils::toBn(0), [
    'from' => $fromAccount,
    'gas' => '0x200b20'
], function ($err, $result) use ($contract) {
    if ($err !== null) {
        var_dump($err->getMessage());die;
    }
    if ($result) {
        echo "\nTransaction has made:) id: " . $result . "\n";
    }
    $transactionId = $result;
    var_dump((preg_match('/^0x[a-f0-9]{64}$/', $transactionId) === 1));

    $contract->eth->getTransactionReceipt($transactionId, function ($err, $transaction) use ($contract) {
        if ($err !== null) {
            var_dump($err->getMessage());die;
        }
        if ($transaction) {
            $topics = $transaction->logs[0]->topics;
            echo "\nTransaction has mined:) block number: " . $transaction->blockNumber . "\n";

            // validate topics
            var_dump($contract->ethabi->encodeEventSignature($this->contract->events['Transfer']), $topics[0]);
        }
    });
});
*/

