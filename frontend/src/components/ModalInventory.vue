<template>
  <div style="position:relative;">

    <div style="font-size:24px;text-align:center;margin-bottom: 60px;">
      <b>Inventory</b>
    </div>

    <h3>Food</h3>
    <br>

  <div class="flex">
    <div class="item-container" v-for="(index, item) in this.$store.state.items.food" v-if="index > 0 && item != 'pills'" :key="item">

      <div class="item-div" style="margin-bottom:-6px">
        <img :src="`/img/food-${item}.png`" class="item" v-bind:id="'i-'+item">
      </div>
      <br>
      <span class="item-name">{{ item }}</span>
      <br>
      <span id="inv_food_count">{{ index }}</span>
      <span v-if="index > 1"> pieces</span>
      <span v-else> piece</span>
      <br>
      <div class="item-use"><span class="a use" @click="useInventory('food', item)">Use</span></div>

    </div>

    <div v-if="this.$store.state.items.food.burger + 
    this.$store.state.items.food.water + 
    this.$store.state.items.food.pepper +
    this.$store.state.items.food.durian +
    this.$store.state.items.food.peyote == 0">
      No items available
    </div>

  </div>

    <div class="clear"></div>
    <br>
    <br>
    <br>
    <h3>Magic</h3>
    <br>
    
    <div class="items-container">
      <div class="item-container" v-for="(index, item) in this.$store.state.items.magic" v-if="index > 0" :key="item">
        <div class="item-div" style="margin-bottom:-6px">
          <img :src="`/img/magic-${item}.png`" class="item" v-bind:id="'i-'+item">
        </div>
        <br>
        <span class="item-name">{{ item }}</span>
        <br>
        <span id="inv_food_count">{{ index }}</span>
        <span v-if="index > 1"> pieces</span>
        <span v-else> piece</span>
        <br>
        <div class="item-use">
          <span v-if="item != 'sunglasses'" class="a" @click="useInventory('magic', item)">Use</span>
          <span v-else class="a use" @click="useInventory('magic', item)">Put on/off</span>
        </div>
      </div>

      <div v-if="this.$store.state.items.magic.resurrection + 
      this.$store.state.items.magic.sunglasses + 
      this.$store.state.items.magic.hibernation == 0">
        No items available
      </div>
      
    </div>   
    <h3 style="margin-top:100px;">Details</h3>
    <div class="div-align-left clear div-details" style="margin-top:20px;">
      <br>
      <b>Burger</b><br>
      Chance to receive it: 73%<br>
      It gives: 1 point<br>
      About: The most common food
      <div class="br"></div>
      <b>Water</b><br>
      Chance: 20%<br>
      Gives: 1 point<br>
      About: Basic water
      <div class="br"></div>
      <b>Pepper (Carolina Reaper)</b><br>
      Chance: 4%<br>
      Gives: 5 points<br>
      About: The hottest pepper in the world. After eating, nimipet has a shock reaction (face change). 
      <!-- Nimipet's face goes back to normal if, after the pepper, it drinks water or eats a burger, or after the first 6 hours. -->
      <div class="br"></div>
      <b>Durian</b><br>
      Chance: 2%<br>
      Gives: 10 points<br>
      About: The smelliest food in the world. Nimipet doesn't like durian, but eat because it gives 10 points.
      <!-- After eating, nimipet is in disgust for the next 24 hours but also didn't need 
      to eat for the first 24 hours. After eating durian, in total nimipet doesn't need to eat for 48 hours. -->
      <div class="br"></div>
      <b>Peyote</b><br>
      Chance: 1%<br>
      Gives: 20 points<br>
      About: The psychodelic cactus from Mexico. Puts nimipet on a CSS spinning trip and gives 20 points.
       <!-- for the next 24 hours and has a distorted face. 
      After eating Peyote, in total nimipet doesn't need to eat for the next 48 hours. -->
      <div class="br"></div>
      <div class="br"></div>
      <b>Resurrection</b><br>
      Received: After 1 month of playing and on some special occasions.<br>
      About: If nimipet has died, it can be resurrected with this item. After the resurrection, nimipet is in zombie mode - it doesn't 
      need to eat food, but also doesn't receive points or airdrops. It goes back to the normal "happy" state after it gets the first 
      piece of food. Resurrection can be used only the same week when nimipet died, before Sunday midnight (GMT time). After that the NIM 
      value is distributed during the airdrop, and resurrection is no longer possible.
      <div class="br"></div>
      <b>Hibernation</b><br>
      Received: On special occasions<br>
      Nimipet hibernates for the next month. It doesn't need food and doesn't die, receives airdrops. You can wake up your 
      nimipet at any time by giving a piece of food.
      <div class="br"></div>
      <b>Sunglasses</b><br>
      Received: When nimipet reaches top 1 position<br>
      About: You can put sunglasses on and off. Sunglasses look cool and are a symbol of status. This item is non-expendable.
      <div class="br"></div>
    </div>

  </div>
</template>

<script>
export default {
  data: function() {
    return {
      soundFed: new Audio('https://nimipet.com/fx/fed.mp3'),
      requests: 0,
    }
  },
  mounted: function() {
    this.soundFed.load();
  },
  methods: {
    useInventory: function(type, item) {
      if (item == 'burger' || item == 'water') {
        // do simple feeding

        if (this.$store.state.nimi.nimi_state == 'alive') {
          this.soundFed.cloneNode(true).play();
          let available = this.$store.state.items.food[item] - 1;
          this.$store.commit('items', { type, item, available } );

          this.requests++;
          let i = this.requests;
          let self = this;

          setTimeout(function() {
            if (i == self.requests) {
              function updateFoodEaten () {

                self.axios.post('/food-basic', { amount: self.requests, item: item } )
                .then(result => {
                  if (result.data != 'error' && result.data != 'food_today_limit') {
                    // if (self.$store.state.nimi.nimi_meta.length < 1) {
                      let property = 'nimi_mood';
                      let value = 'happy';
                      self.$store.commit('nimi', { property, value });
                    // }

                    let type = 'food';
                    let available = result.data.items.available;
                    self.$store.commit('items', { type, item, available } );

                    for (const key of Object.keys(result.data.nimi)) {
                      let property = key;
                      let value = result.data.nimi[key];
                      self.$store.commit('nimi', {property, value});
                    }
                  }
                  else if (result.data == 'food_today_limit') {
                    alert ('Daily food limit (200 pieces) reached. The limit will reset at 00:00 UTC time.');
                    let type = 'food';
                    let available = self.$store.state.items.food[item] + 1;
                    self.$store.commit('items', { type, item, available } );
                  }
                })
                .catch(error => { console.log(error); });

              }

              updateFoodEaten();
              this.requests = 0;

            }
            
          }, 1000);

        }
      }
      else if (type == 'food') {
        // do special food feeding
        if (this.$store.state.nimi.nimi_state == 'alive') {
          this.soundFed.cloneNode(true).play();

          this.axios.post('/food-special', { amount: 1, item: item } )
          .then(result => {
            if (result.data != 'error' && result.data != 'food_today_limit') {
              let property = 'nimi_mood';
              let value = item;
              this.$store.commit('nimi', { property, value });

              let type = 'food';
              let available = result.data.items.available;
              this.$store.commit('items', { type, item, available } );

              for (const key of Object.keys(result.data.nimi)) {
                let property = key;
                let value = result.data.nimi[key];
                this.$store.commit('nimi', {property, value});
              }
            }
            else if (result.data == 'food_today_limit') {
              alert ('Daily food limit (200 pieces) reached. The limit will reset at 00:00 UTC time.');
              let type = 'food';
              let available = this.$store.state.items.food[item] + 1;
              this.$store.commit('items', { type, item, available } );
            }
          })
          .catch(error => { console.log(error); });
        }
      }
      else if (item == 'resurrection') {
        // do resurrection
        if (this.$store.state.nimi.nimi_state != 'dead') {
          alert ("Can't resurrect a nimipet that is not dead.");
          return;
        }
        this.soundFed.cloneNode(true).play();

        this.axios.post('/resurrection')
        .then(result => {
          if (result.data == 'resurrected') {
            // Nimipet has been resurrected and NIM value restored. Refresh your browser window.
            setTimeout(function(){ location.reload(); }, 600);
          }
          else if (result.data == 'too_late') {
            alert("Your nimipet's NIM value was re-distributed during the previous airdrop. Your nimipet cannot be resurrected.");
          }
        })
        .catch(error => { console.log(error); });
      }
      else if (item == 'sunglasses') {
        // do sunglasses
        this.soundFed.cloneNode(true).play();

        this.axios.post('/magic', { item: item } )
        .then(result => {
          if (result.data != 'error') {
            if (typeof(result.data[0]) == 'undefined') {
              let property = 'nimi_meta';
              let value = '';
              this.$store.commit('nimi', { property, value });
              property = 'nimi_mood';
              value = 'happy';
              this.$store.commit('nimi', { property, value });
            }
            else {
              let property = 'nimi_mood';
              let value = 'sunglasses';
              this.$store.commit('nimi', { property, value });
            }
          }
        })
        .catch(error => { console.log(error); });
      }
      else if (item == 'hibernation') {
        // do hibernation
        this.soundFed.cloneNode(true).play();

        let available = this.$store.state.items.magic[item] - 1;
        this.$store.commit('items', { type, item, available } );

        this.axios.post('/magic', { item: item } )
        .then(result => {
          if (result.data != 'error') {
            if (typeof(result.data[0]) == 'undefined') {
              let property = 'nimi_meta';
              let value = '';
              this.$store.commit('nimi', { property, value });
              property = 'nimi_mood';
              value = 'happy';
              this.$store.commit('nimi', { property, value });
            }
            else {
              let property = 'nimi_mood';
              let value = 'hibernation';
              this.$store.commit('nimi', { property, value });
            }
          }
        })
        .catch(error => { console.log(error); });
      }
    },
  }
}
</script>

<style>
.br {
  height: 25px;
}

.use {
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -o-user-select: none;
  user-select: none;
}

.div-details {
  text-align: left;
  padding: 20px;
  max-width: 560px;
  margin: 0 auto;
  border: 1px solid rgb(185, 185, 185);
  border-radius: 5px;
  background-color: #f7f7f7;
}

.item {
  margin: 0 auto;
}

#i-burger {
  /* width: 53px; */
  margin-top: 2px;
  width: 66px;
}
#i-water {
  /* width: 40px; */
  width: 49px;
}
#i-durian {
  /* width: 52px; */
  width: 66px;
}
#i-peyote {
  /* width: 50px; */
  width: 64px;
}
#i-pepper {
  /* width: 48px; */
  width: 57px;
}
#i-sunglasses {
  margin-top: 14px;
  width: 86px;
  /* margin-top: 10px;
  width: 71px; */
}
#i-resurrection {
  width: 66px;
  margin-top: 6px;
  /* width: 55px; */
  /* margin-top: 6px; */
}
#i-hibernation {
  /* width: 65px; */
  width: 81px;
  margin-top: 2px;
}

.item-name {
  text-transform: capitalize;
  font-weight: bold;
}

.item-use {
  margin-top: 10px;
}

.items-container {
  text-align: center;
}

.item-container {
  width: 135px;
  min-height: 185px;
  text-align: center;
  border: 1px solid rgb(185, 185, 185);
  /* background-color: #eeeeee; */
  border-radius: 5px;
  margin: 5px;
  padding-top: 15px;
  display: inline-block;
}

.item-div {
  display: flex;
  flex-direction: column;
  justify-content: center;
  width: 100px;
  height: 100px;
  background-color: white;
  margin: 0 auto;
  border-radius: 6px;
  margin-bottom: 7px;
}
</style>