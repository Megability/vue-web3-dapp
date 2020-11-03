import Web3 from "web3";
import abi from './CandidateVoting.json'
import ContractAddress from './ContractAddress'

const MyWeb3 ={
    init() {
        /*
        '1': Ethereum Main Network
        '2': Morden Test network
        '3': Ropsten Test Network
        '4': Rinkeby Test Network
        '5': Goerli Test Network
        '42': Kovan Test Network
        */
        return new Promise((resolve, reject) => {
            //let currentChainId = parseInt(window.ethereum.chainId, 16)
            let ethereum = window.ethereum
            //禁止自动刷新，metamask要求写的
            ethereum.autoRefreshOnNetworkChange = false
            //开始调用metamask
            //ethereum.enable().then(function (accounts) {//将要废弃
            ethereum.request({ method: 'eth_requestAccounts' }).then(function (accounts) {
                //初始化provider
                let provider = window['ethereum'] || window.web3.currentProvider
                //初始化Web3
                window.web3 = new Web3(provider)
                //获取到当前以太坊网络id
                window.web3.eth.net.getId().then(function (result) {
                    let currentChainId = result
                    //设置最大监听器数量，否则出现warning
                    window.web3.currentProvider.setMaxListeners(300)
                    //从json获取到当前网络id下的合约地址
                    let currentContractAddress = ContractAddress[currentChainId]
                    if(currentContractAddress !== undefined){
                        //实例化合约
                        window.MyContract = new window.web3.eth.Contract(abi.abi,currentContractAddress)
                        //获取到当前默认的以太坊地址
                        window.defaultAccount = accounts[0].toLowerCase()
                        //that.allEvents(window.MyContract)
                        window.MyContract.events.allEvents({fromBlock: 0, toBlock: 'latest'}, function(error, event){
                            console.log({allEvents:event})
                        }).on("connected", function(subscriptionId){
                           console.log({connected_subscriptionId:subscriptionId})
                        }).on('data', function(event){
                           console.log({event_data:event})
                        }).on('changed', function(event){
                            console.log({event_changed:event})
                        }).on('error', function(error, receipt) { 
                            console.log({event_error:error,receipt:receipt})
                        })
                        resolve(true)
                    }else{
                        reject('Unknow Your ChainId:'+currentChainId)
                    }
                })
            }).catch(function (error) {
                console.log(error)
            })
        })
    },
    //
    getCandidateCount(){
        return new Promise((resolve) => {
            window.MyContract.methods.candidateCount().call().then(function(count) {
                resolve(count)
            })
        })
    },
    //
    getCandidates(id){
        return new Promise((resolve) => {
            window.MyContract.methods.candidates(id).call().then(function(candidate) {
                resolve(candidate)
            })
        })
    },
    //
    candidateVoteTimes(id){
        return new Promise((resolve) => {
            window.MyContract.methods.candidateVoteTimes(id).call().then(function(times) {
                resolve(times)
            })
        })
    },
    //
    vote(id){
        return new Promise((resolve, reject) => {
            console.log(id,window.defaultAccount)
            window.MyContract.methods.vote(id).send({from:window.defaultAccount,value:window.web3.utils.toWei('0.01')})
            .on('transactionHash', function(transactionHash){
                resolve(transactionHash)
            })
            .on('confirmation', function(confirmationNumber, receipt){
                console.log({confirmationNumber:confirmationNumber,receipt:receipt})
            })
            .on('receipt', function(receipt){
                console.log({receipt:receipt})
                window.location.reload()
            })
            .on('error', function(error,receipt){
                console.log({error:error,receipt:receipt})
                reject({error:error,receipt:receipt})
            })
        })
    },
    //获得合约拥有者地址
    owner(){
        return new Promise((resolve) => {
            window.MyContract.methods.owner().call().then(function(owner) {
                resolve(owner.toLowerCase())
            })
        })
    },
    //获得合约名称
    name(){
        return new Promise((resolve) => {
            window.MyContract.methods.name().call().then(function(name) {
                resolve(name)
            })
        })
    },
    //获得合约标识
    symbol(){
        return new Promise((resolve) => {
            window.MyContract.methods.symbol().call().then(function(symbol) {
                resolve(symbol)
            })
        })
    },
    //查询余额
    checkBalance(){
        return new Promise((resolve, reject) => {
            this.owner().then(function (owner) {
                if(window.defaultAccount === owner){
                    window.MyContract.methods.checkBalance().call({from:window.defaultAccount}).then(function(balance) {
                        resolve(window.web3.utils.fromWei(balance,'ether'))
                    })
                }else{
                    reject('You are not contract owner')
                }
            })
        })
    },
    //提款
    withdraw(){
        return new Promise((resolve, reject) => {
            this.owner().then(function (owner) {
                if(window.defaultAccount === owner){
                    window.MyContract.methods.withdraw().send({from:window.defaultAccount}).then(function(res) {
                        resolve(res)
                    })
                }else{
                    reject('You are not contract owner')
                }
            })
        })
    },
    //新候选人事件
    EventNewCandidate(){
        return new Promise((resolve) => {
            window.MyContract.events.NewCandidate({fromBlock: 0, toBlock: 'latest'},function (error, event) {
                resolve(event)
            })
        })
    },
    //所有事件
    allEvents(){
        window.MyContract.events.allEvents({fromBlock: 0, toBlock: 'latest'}, function(error, event){
            console.log({allEvents:event})
        }).on("connected", function(subscriptionId){
           console.log({connected_subscriptionId:subscriptionId})
        }).on('data', function(event){
           console.log({event_data:event})
        }).on('changed', function(event){
            console.log({event_changed:event})
        }).on('error', function(error, receipt) { 
            console.log({event_error:error,receipt:receipt})
        })
    }
}
    
export default MyWeb3;