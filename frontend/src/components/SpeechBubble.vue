<template>
  <div class="scaled-bubble">
    <div v-if="mod == 'pub' && $store.state.nimi.nimi_msg != null" class="scaled-bubble">
      <div v-if="$store.state.nimi.nimi_msg.length > 80" class="bubble scaled-mod" style="top:130px;">
        {{ $store.state.nimi.nimi_msg }}
      </div>
      <div v-else class="bubble scaled-mod scaled-mod-2">
        <div class="speech-big-name">{{ $store.state.nimi.nimi_msg }}</div>
      </div>
    </div>
    <div v-else-if="mod != 'pub'">
      <div class="bubble" v-if="this.$store.state.speech == 'avatar'" @click="bubbleClickStore">
        My new style is saved 😊 <br><br>You can generate my image to use it as an avatar for social networks.
      </div>
      <div class="bubble" v-else-if="this.$store.state.speech == 'name-change-success'" @click="bubbleClickStore">
        <div class="speech-big-name">Success! My new name is<br> <b>{{ this.$store.state.nimi.nimi_name }}</b></div>
      </div>
      <div class="bubble" v-else-if="this.$store.state.speech == 'name-change-error'" @click="bubbleClickStore">
        <span class='error'>
          ERROR: This name is already in use by another nimipet. Please pick a different one.
        </span>
      </div>
      <div class="bubble" v-else-if="speech != ''" v-html="speech" @click="bubbleClick"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: [ 'mod' ],
  mounted () {
    this.randomSpeech();
  },
  created () {
    this.randomQuotes();
  },
  beforeDestroy () {
    clearInterval(this.interval);
  },
  methods: {
    randomSpeech () {
      let randomSpeech = this.speechList.random[Math.floor(Math.random()*this.speechList.random.length)];
      if (randomSpeech.length < 65) {
        this.speech = '<div class="speech-big">'+randomSpeech+'</div>';
      }
      else {
        this.speech = randomSpeech;
      }
    },
    randomQuotes () {
      var self = this;
      this.interval = setInterval(() => {
        let random = Math.floor(Math.random() * 6) + 1;
        if (random == 1) {
          this.randomSpeech();
        }
        else if (random == 6) {
          this.speech = "";
        }
      }, 10000);
    },
    bubbleClick () {
      let textArray = [1, 2];
      let randomIndex = Math.floor(Math.random() * textArray.length); 
      if (textArray[randomIndex] == 1) {
        this.randomSpeech();
      }
      else {
        this.speech = "";
      }
    },
    bubbleClickStore () {
      this.$store.commit("speech", "");
      let textArray = [1, 2];
      let randomIndex = Math.floor(Math.random() * textArray.length); 
      if (textArray[randomIndex] == 1) {
        this.randomSpeech();
      }
      else {
        this.speech = "";
      }
    },
  },
  data () {
    return {
      speech: '',
      interval: null,
      speechList: {
        random: [
          "Satoshi Nakamoto is a fictitious name of the Bitcoin creator or creators, to this day no one knows who the actual creator is.",
          "As of 2018, Satoshi Nakamoto owns around $16.5 billion in bitcoins. He has the largest wallet in the world.",
          "In 2015, Satoshi Nakamoto was nominated for a Nobel prize in economic sciences.",
          "There will be a maximum of 21 million bitcoin created and in circulation. It is expected that all coins will be mined by the year 2140.",
          "On May 22, 2010, two pizzas were purchased from Papa John's for 10K bitcoin. The current value for those pizzas as of June 2018 is around $80 M.",
          "The number of Bitcoins awarded for mining halves around every 4 years, there will be 64 halvings until all bitcoins are mined.",
          "Bitcoin uses a cryptographic hash algorithm called SHA265 for mining.",
          "Once all bitcoins have been mined, then there will be no more mining rewards, but miners could get transaction fees.",
          "Bitcoin was invented by Satoshi Nakamoto in 2008. It consists of 31,000 lines of computer code.",
          "Every day around 3,600 new bitcoins are created through mining.",
          "The first transfer of Bitcoin took place on January 21, 2009. Satoshi Nakamoto transferred 100 BTC to Harold Thomas Finney.",
          "Lamborghini was the first automotive company in the world to accept Bitcoin.",
          "Bitcoin is the first decentralized digital currency, aka cryptocurrency, that solves the double spending problem.",
          "Bitcoins are created through 'mining'. Mining involves solving complex mathematical problems. Miners are rewarded with Bitcoins.",
          "In November 2013, one Bitcoin became more valuable than an ounce of gold.",
          "In 2010, a year after its launch, Bitcoin was only worth 4 cents.",
          "On November 22, the largest Bitcoin transaction was made, transferring 194,993 BTC.",
          "BTC is the symbol that represents Bitcoin.",
          "There are currently around 28 million bitcoin wallets. However the number of unique users is estimated to be between 2.9 and 5.8 million.",
          "The first Bitcoin transaction took place in outer space when cloud mining provider, Genesis Mining, made a transfer of 1 Bitcoin.",
          "The Bitcoin network is the world's most powerful supercomputer, with a total computing power of 64 exaFLOPS (floating point operations).",
          "$100 invested in Bitcoin in 2010 would now be worth around $72 million.",
          "There are more than around 20,000 computers mining for Bitcoin.",
          "The first Bitcoin ATM was in Vancouver Canada.",
          "There are currently around 16 million Bitcoins in circulation. Out of those it is estimated that 23 percent or 3.8 million of them are lost forever.",
          "Satoshi is the smallest unit of Bitcoin. It represents 0.00000001 (one hundred millionth) of a bitcoin.",
          "On November 29, 2017, John McAfee predicted the value of Bitcoin would be $500,000 by the end of 2020.",
          "Bitcoin can process 7 transactions per second, Nimiq can process 12 transactions per second (we need to confirm if this is correct).",
          "The blockchain is a public ledger that records cryptocurrency transactions, each block containing a hash of the previous block.",
          "The term Altcoin is short for alternative protocol asset and the term used to refer to derivatives of bitcoin.",
          "There are two ways of adding a block to a blockchain, proof-of-work (PoW) and proof-of-stake (PoS).",
          "Proof-of-stake is a method of securing a cryptocurrency network and achieving distributed consensus by showing ownership of currency.",
          "A wallet stores public and private 'keys'. Public keys are shared and used to receive, private keys are never shared.",
          "Jordan Kelley, the founder of Robocoin, launched the first bitcoin ATM in the United States on February 20, 2014.",
          "By September 2017, 1,574 bitcoin ATMs have been installed around the world.",
          "Proof-of-work is the most popular method of securing the blockchain, there are at least 480 implementations, including SHA-256 and Argon2.",
          "In March 2018, the word 'cryptocurrency' was added to the Merriam-Webster Dictionary.",
          "NIM is the token of the Nimiq Blockchain. Nimiq is a browser-based blockchain designed for simplicity and ease of use.",
          "Nimiq mainnet went live on April 14. The first pre-mined 720 blocks were 'burned' to protect against rebranching and forking.",
          "Nimiq is an Inuit word for an object or force that binds things together.",
          "Nimiq will have a total supply or 21 billion tokens divisible by smallest units called satoshi, identical to Bitcoin.",
          "Nimiq is the blockchain designed for simplicity. It is a browser-based blockchain & ecosystem",
          "Nimiq aims to be the best performing and easiest-to-use decentralized payment protocol & ecosystem.",
          "Nimiq has a block reward that starts with 4965 NIM and is reduced in a curved fashion proportional to the block height and remaining supply.",
          "The max block size in Nimiq is 140 kB.",
          "Nimiq was created by Robin Linus, Philipp von Styp-Rekowsky and Elion Chin.",
          "Nimiq uses a very efficient alogrithm called Argon2 for mining. It is ASIC and GPU resistant.",
          "When moon, sir?"
        ]
      }
    }
  }
}
</script>

<style>
.scaled-bubble {
  max-width:200px;
  height:200px;
  margin:0 auto;
  position:absolute;
}

.error {
  color: #ff3d00;
}

.speech-big {
  padding-top: 8px;
  padding-bottom: 8px;
  font-size: 17px;
  text-align: center;
}

.speech-big-name {
  padding-top: 3px;
  padding-bottom: 3px;
  font-size: 17px;
  text-align: center;
  line-height: 24px;
}

.bubble {
  cursor: default;
  position: absolute;
  top: 101px;
  left: 344px;
  background: #ffffff;
  color: #383838;
  text-align: left;
  width: 255px;
  min-height: 30px;
  border-radius: 5px;
  padding: 5px 7px 6px 7px;
  border: #7d7d7d solid 1px;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -o-user-select: none;
  user-select: none;
}

.scaled-mod {
  top: 143px;
  left: 355px;
}

.scaled-mod-2 {
  top: 130px;
}

.bubble:after {
  content: '';
  position: absolute;
  display: block;
  width: 0;
  z-index: 1;
  border-style: solid;
  border-width: 0 25px 23px 0;
  border-color: transparent #ffffff transparent transparent;
  top: 50%;
  left: -25px;
  margin-top: -11.5px;
}

.bubble:before {
  content: '';
  position: absolute;
  width: 0;
  z-index: 0;
  border-style: solid;
  border-width: 0 26px 24px 0;
  border-color: transparent #7d7d7d transparent transparent;
  top: 50%;
  left: -27px;
  margin-top: -12.5px;
  display: block;
}

@media only screen and (max-width: 1000px)  {
  .bubble {
    display: none;
  }
}

.typing {
  padding-top: 0px;
  padding-left: 20px;
  padding-bottom: 26px;
  font-size: 20px;
  letter-spacing: 13px;
}

.typing span {
  animation-name: blink;
  animation-duration: 1s;
  animation-iteration-count: infinite;
  animation-fill-mode: both;
}

.typing span:nth-child(2) {
    animation-delay: .2s;
}

.typing span:nth-child(3) {
    animation-delay: .4s;
}

@keyframes blink {
    0% {
      opacity: 0;
    }
    20% {
      opacity: 1;
    }
    100% {
      opacity: .2;
    }
}
</style>