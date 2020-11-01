<template>
  <div id="app">
    <HelloWorld2 />
  </div>
</template>

<script>
import HelloWorld2 from './components/HelloWorld2.vue'

export default {
  name: 'App',
  components: {
    HelloWorld2
  },
  async mounted() {
    await this.initWeb3Account()
  },
  methods:{
    async initWeb3Account(){
        let ethereum = window.ethereum
        if (typeof  ethereum !== 'undefined' || (typeof window.web3 !== 'undefined')) {
            ethereum.on('accountsChanged', function (accounts) {
                console.log("accountsChanged:"+accounts)
                //window.location.reload()
            })
            ethereum.on('chainChanged', function (chainId) {
                console.log("chainChanged:"+chainId)
                //window.location.reload()
            })
        }else {
            alert('You have to install MetaMask !')
        }
    }
  }
}
</script>
