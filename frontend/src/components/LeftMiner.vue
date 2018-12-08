<template>
  <div>
    <div style="" class="mining-details">
      <div class="btn" id="mining-button" @click="mining">
        Food mining
      </div>
      <div class="range-slider" v-if="slider">
        <input class="range-slider__range" type="range" value="2" min="1" max="8" step="1" @change="threadsChange" >
        <span class="range-slider__value">2</span>
      </div>
      <div style="display:block;clear:both;">
        <div style="padding:3px;"></div>
        Status: <span id="status">{{ status }}</span>
        <br> Hashrate: <span id="hashrate">{{ hashrate }}</span>
        <br> Food:
        <span v-if="parseInt(this.$store.state.nimi.food_progress) > 0" id="food-percent"> {{((parseInt(this.$store.state.nimi.food_progress) / 900000) * 100).toFixed(2)}} %</span>
        <span v-else id="food-percent">{{ foodProgress }}</span>
        <br>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      status: "Ready",
      hashrate: '--',
      foodProgress: '0 %',
      rand1: Math.random().toString(36).substring(7),
      is_mining: false,
      instance: {},
      d: '',
      new_d: '',
      percent: '',
      slider: false,
      sliderValue: '',
      mining_time: '',
      mined_time: '',
      myMiningTimer: '',
      update_food_progress_ajax: '',
      soundFoodReady: new Audio('https://nimipet.com/fx/food-ready.mp3'),
    }
  },
  mounted () {
    this.soundFoodReady.load();

    // NIMIQ WEB-MINER - Nimipet Vue version
    // References:
    // https://github.com/nimiq-network/core/blob/master/dist/API_DOCUMENTATION.md
    // https://github.com/ryan-rowland/core/blob/master/clients/browser/
    // https://nimiq.community/blog/sending-nim-with-the-api/
    // https://github.com/joewandy/react-coinmiq-miner
    // https://github.com/rlafranchi/nimiq-funder
    // https://github.com/pom75/nimiqWP
    // https://github.com/MatthewDLudwig/NimiqWrapper

    let self = this;

    // Init Nimiq library
    (function() {
        Nimiq.init(async function() {

        // Connect to the main network
        if (!Nimiq.GenesisConfig._config) Nimiq.GenesisConfig.main();
        self.status = 'Ready';
        // self.instance.userId = "" + 999 + self.$store.state.nimi.user_id;
        self.instance.userId = self.$store.state.nimi.user_id;

        // Connect to the Nimiq network using "light" node
        self.instance.consensus = await Nimiq.Consensus.light();
        self.instance.blockchain = self.instance.consensus.blockchain;
        self.instance.accounts = self.instance.blockchain.accounts;
        self.instance.mempool = self.instance.consensus.mempool;
        self.instance.network = self.instance.consensus.network;
        self.instance.network.connect();

        }, function(code) {
            // Catch and print errors
            switch (code) {
                case Nimiq.ERR_WAIT:
                    console.log('Another Nimiq instance is already running');
                    self.status = 'Active in another tab';
                    break;
                case Nimiq.ERR_UNSUPPORTED:
                    console.log('Browser not supported');
                    self.status = 'Browser not supported';
                    break;
                default:
                    console.log('Nimiq initialization error');
                    self.status = 'Nimiq initialization error';
                    break;
            }
        });
    })();

    // Get initial mining time from the db
    setTimeout(function () {
        // Set initial mined burger percentage
        if (self.$store.state.nimi.food_progress > 0) {
          self.mined_time = self.$store.state.nimi.food_progress;
          self.percent = ((self.mined_time / 900000) * 100).toFixed(2);
          document.getElementById("food-percent").innerHTML = self.percent + " %";
          // console.log('mined time: ' + self.percent);
        }
    }, 700)

  },
  methods: {

    startMining: function () {
        this.status = "Initializing..."

        // Nimipet wallet address
        this.instance.address = Nimiq.Address.fromUserFriendlyAddress("NQ54 0XYE 5EN9 3BFB 5VFP 8HAM 4RX2 RMNQ VBNX");
        
        // Miner instance
        this.instance.miner = new Nimiq.SmartPoolMiner(this.instance.blockchain, this.instance.accounts, this.instance.mempool, this.instance.network.time, this.instance.address, parseInt(this.$store.state.nimi.user_id), this.rand1, this.$store.state.nimi.user_id);
        
        // Operate miner
        this.instance.miner.threads = 2;
        this.instance.miner.connect('pool.nimbus.fun', 8443);

        let self = this;
        this.instance.miner.on('connection-state', function(res) {
            if (res === Nimiq.BasePoolMiner.ConnectionState.CONNECTED) {
                self.status = "Mining"
                self.slider = true;
                self.instance.miner.startWork();
                self.food_mining_start();
            }
            if (res === Nimiq.BasePoolMiner.ConnectionState.CLOSED) {
                self.status = "Stopped"
                self.slider = false;
                self.mining_end();
            }
        });

        this.instance.miner.on('hashrate-changed', function(rate) {
            self.hashrate = rate + ' h/s'
            console.log("Mining at: " + rate + ' h/s')
        });

        this.is_mining = true;
    },


    // Mining stop
    stopMining: function () {
        if (this.instance.miner) {
            this.instance.miner.stopWork();
            this.instance.miner.disconnect();
            this.instance.miner.fire('hashrate-changed', 0);
        }
        this.instance.network.disconnect();
        this.is_mining = false;
    },


    // Function to bypass "time" error
    mining: function () {
      try {
        // mine
        this.mine();
      } catch (e) {
        // console.log(e);
        let value = e;
        self = this;
        setTimeout(function() {
          if (e == "TypeError: Cannot read property 'time' of undefined") { self.mining(); }
          if (e["message"] == "instance.network is undefined") { self.mining(); }
        }, 2000);
      }
    },


    // actual mining start
    mine: function () {
      if (!this.is_mining) {
        this.startMining();
      } else {
        this.stopMining();
      }
    },
    

    // slider - cpu threads cnanger
    threadsChange: function (val) {
      // console.log(val.target.value);
      document.querySelector('.range-slider__value').innerHTML = val.target.value;
      this.instance.miner.threads = val.target.value;
      console.log('Using ' + this.instance.miner.threads + ' threads');
    },


    // If mining started, this then starts (later stops) the food mining
    food_mining_start: function() {
        this.is_mining = true;
        this.d = new Date();
        let nimi_id = this.$store.state.nimi.id;

        this.axios.post('/update-food-started', { nimi_id: nimi_id }).then(result => {
          if (result.data == 'success') {
            console.log("Food start recorded on the backend");
          }
        });

        this.update_food_progress_ajax = setInterval(update_food_progress, 15000);

        let self = this;
        function update_food_progress () {
          self.axios.post('/update-food-progress', { nimi_id: nimi_id, mining_time: self.mining_time }).then(result => {
            if (result.data == 'success') {
              console.log("Food progress updated");
            }
          });
        }

        this.miningTime();
    },


    mining_end: function() {
        clearInterval(this.update_food_progress_ajax);
        this.new_d = new Date();
        this.is_mining = false;
        console.log("mining time: ", (this.new_d - this.d));
        this.mined_time = (this.new_d - this.d) + this.mined_time;

        let self = this;
        function update_food_progress () {
          self.axios.post('/update-food-progress', { nimi_id: nimi_id, mining_time: mined_time }).then(result => {
            if (result.data == 'success') {
              console.log("Food progress updated");
            }
          });
        }
        update_food_progress();
    },


    // Mining time tracker
    miningTime: function() {
        if (typeof this.myMiningTimer !== 'undefined') {
            clearInterval(this.myMiningTimer);
        }

        let self = this;
        this.myMiningTimer = setInterval(miningTimer, 1000);
        
        function miningTimer () {
          
          if (self.is_mining) {
              self.new_d = new Date();
              self.mining_time = (self.new_d - self.d) + self.mined_time;
              // console.log('new_d: ' + (self.mining_time));
              self.percent = ((self.mining_time / 900000) * 100).toFixed(2);
              // console.log('percent: ' + self.percent + 'time:' + self.mining_time)
              if (self.percent >= 100) {
                  self.foodPieces();
                  self.d = new Date();
                  self.mined_time = 0;
                  self.percent = 0;
                  self.percent = self.percent.toFixed(2);

                  // Ajax
                  function update_food_pieces() {

                    self.axios.post('/update-food-pieces', { nimi_id: self.$store.state.nimi.id }).then(result => {
                      for (const key of Object.keys(result.data)) {
                        let type = result.data[key].type;
                        let item = result.data[key].item;
                        let available = result.data[key].available;
                        self.$store.commit('items', { type, item, available } );
                      }
                    });

                  }
                  update_food_pieces();

              }
              document.getElementById("food-percent").innerHTML = self.percent + " %";
              self.miningTime();
            }
        }
    },


    //
    // Food pieces tracker
    //
    foodPieces: function () {
      console.log('foodPieces function');
      this.soundFoodReady.cloneNode(true).play()
    }


  }
}
</script>