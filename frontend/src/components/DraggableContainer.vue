<script>
  import { Draggable } from '@shopify/draggable'

  export default {
    props: [],
    data: function () {
      return {
        soundGrab: new Audio('https://nimipet.com/fx/grab.mp3'),
        soundFed: new Audio('https://nimipet.com/fx/fed.mp3'),
        over: false,
        eating: false
      }
    },
    render() {
      return this.$slots.default[0]
    },
    mounted() {
      this.soundGrab.load();
      this.soundFed.load();
      var draggable = new Draggable(this.$el, {
        draggable: 'img',
      });
      draggable.on('drag:start', () => 
        this.soundGrab.cloneNode(true).play()
      );
      draggable.on('drag:move', dragMoveEvent => {
        if (dragMoveEvent.sensorEvent.target.id == "nimi-container") {
          if (this.over == false) {
            // console.log('over');
            let property = "nimi_temp";
            let value = "eating";
            this.$store.commit('nimi', {property, value});
            this.over = true;
          }
        }
        else {
          if (this.over == true) {
            // console.log('out');
            this.over = false;
            let property = "nimi_temp";
            let value = "";
            this.$store.commit('nimi', {property, value});
          }
        }
      });
      draggable.on('mirror:destroy', el => {
        if (this.over) {
          let property = "nimi_temp";
          let value = "";
          this.$store.commit('nimi', {property, value});
          this.over = false;

          let type = 'food';
          let item = el.data.mirror.classList[1];

          if (item == 'burger' || item == 'water') {
            if (this.$store.state.nimi.nimi_state == 'alive') {
              this.soundFed.cloneNode(true).play();

              let available = this.$store.state.items.food[item] - 1;
              this.$store.commit('items', { type, item, available } );

              // if (this.$store.state.nimi.nimi_meta.length < 1) {
                let property = 'nimi_mood';
                let value = 'happy';
                this.$store.commit('nimi', { property, value });
              // }

              this.axios.post('/food-basic', { amount: 1, item: item } )
              .then(result => {
                if (result.data != 'error' && result.data != 'food_today_limit') {

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
          else if (item == 'pills') {
            // console.log ('put to sleep');
            this.soundFed.cloneNode(true).play();

            this.$store.commit('reset');
            
            let property = 'nimi_mood';
            let value = 'dead';
            this.$store.commit('nimi', { property, value });

            this.axios.post('/withdrawal')
            .then(result => {

            })
            .catch(error => { console.log(error); });

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

        }
      });
    }
  }
</script>