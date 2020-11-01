<template>
  <div>
    <h1>投票</h1>
    <select v-model="selected">
      <option
        v-for="(item, index) in candidatess"
        :key="index"
        :value="index"
      >
      {{ item.name }},年龄:{{ item.age }},票数:{{ item.times }}
      </option>
    </select>
    <button v-on:click="vote">投票</button>
    <br>
    <button v-on:click="withdraw" v-show="false">提现</button>
  </div>
</template>

<script>
import MyWeb3 from '../MyWeb3'
export default {
  name: 'HelloWorld2',
  data: () => ({
    candidatess:[],
    selected:0
  }),
  computed: {

  },
  created() {

  },
  mounted() {
    let that = this
    let ethereum = window.ethereum
    if (typeof  ethereum !== 'undefined' || (typeof window.web3 !== 'undefined')) {
        MyWeb3.init().then(function(res){
          console.log(res)
          that.candidates()
        })
    }else {
        alert('You have to install MetaMask !')
    }
  },
  methods:{
    candidates(){
        let that = this
        MyWeb3.getCandidateCount().then(function(count){
            if(count > 0){
                for(let i=0;i<count;i++){
                    MyWeb3.getCandidates(i).then(function (result) {
                        let result2 = result
                        MyWeb3.candidateVoteTimes(i).then(function (times) {
                          result2.times = times
                          that.candidatess.push(result2);
                        })
                    })
                }
                //console.log(that.candidatess)
            }
        })
    },
    vote(){
      //let that = this
      //console.log(this.selected)
      MyWeb3.vote(this.selected).then(function (result) {
        console.log(result)
      })
    },
    withdraw(){
      MyWeb3.withdraw().then(function (result) {
        console.log(result)
      })
    }
  }
}
</script>
