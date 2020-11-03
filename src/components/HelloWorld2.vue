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
  async mounted() {
    await MyWeb3.init()
    await this.candidates()
  },
  methods:{
    async candidates(){
      let count = await MyWeb3.getCandidateCount()
      if(count > 0){
          for(let i=0;i<count;i++){
            let result2 = await MyWeb3.getCandidates(i)
            result2.times = await MyWeb3.candidateVoteTimes(i)
            this.candidatess.push(result2)
          }
          //console.log(that.candidatess)
      }
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
