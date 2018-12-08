<template>
  <div style="margin-top:15px;">
    <div class="edit-nimi-pet">
      <div class="slidersXY">
        <div class="slidecontainer">
          <input type="range" min="1" max="360" value="0" class="slider" id="x1" @input="x1Slider">
        </div>
        <div class="slidecontainer" style="margin-top:5px;display:none;">
          <input type="range" min="1" max="100" value="0" class="slider" id="y1">
        </div>
      </div>
      <div class="svg-color-pickers">
        <input class="jscolor" id="jscolor1" :value="color1" autocomplete="off" @change="changeStop1">
        <input class="jscolor" id="jscolor2" :value="color2" autocomplete="off" @change="changeStop2">
        <input class="jscolor" id="jscolor3" :value="color3" autocomplete="off" @change="changeStop3">
      </div>
      <div class="skin" style="margin-bottom:20px;">
        <span style="display:none">
          <p>OR</p>
          <p>Paste img url to use as skin</p>
          <input style="display:block" id="skin" type="text" name="skin" value="" placeholder="chooseSkin" onchange="changeSkin(this.value)">
        </span>
        <button type="submit" class="save-nim-style" @click="updateNimStyle">SAVE</button>
        <br>
        <br>
        <span class="a">Get avatar</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
    }
  },
  mounted() {
    // window.jsColorScript = document.createElement('script');
    // jsColorScript.setAttribute('src', 'https://cdnjs.cloudflare.com/ajax/libs/jscolor/2.0.4/jscolor.js');
    // document.head.appendChild(jsColorScript);
  },
  computed: {
		color1: {
      get () {
        return this.$store.state.nimi.nimi_style.color1;
      },
      set (value) {
				this.$store.commit('color1', value);
      }
    },
    color2: {
      get () {
        return this.$store.state.nimi.nimi_style.color2;
      },
      set (value) {
				console.log('z');
      }
    },
    color3: {
      get () {
        return this.$store.state.nimi.nimi_style.color3;
      },
      set (value) {
        console.log('z');
      }
    },
  },
  methods: {
    x1Slider: function(e) {
      function angleToPoints(angle) {
          var segment = Math.floor(angle / Math.PI * 2) + 2;
          var diagonal = (1 / 2 * segment + 1 / 4) * Math.PI;
          var op = Math.cos(Math.abs(diagonal - angle)) * Math.sqrt(2);
          var x = op * Math.cos(angle);
          var y = op * Math.sin(angle);
          return {
            x1: x < 0 ? 1 : 0,
            y1: y < 0 ? 1 : 0,
            x2: x >= 0 ? x : x + 1,
            y2: y >= 0 ? y : y + 1
          };
        }
        function toRadians(degrees) {
          return degrees / 180 * Math.PI;
        }
        const requestAnimationFrame = (i) => {
          var angle = toRadians(i - 180);
          var pair = angleToPoints(angle);
          this.x1 = pair.x1
          this.y1 = pair.y1
          this.x2 = pair.x2
          this.y2 = pair.y2
        }
        requestAnimationFrame(e.target.value);
      },
      changeStop1: function(e) {
        this.color1 = `#${e.target.value}`;
      },
      changeStop2: function(e) {
        this.color2 = `#${e.target.value}`;
      },
      changeStop3: function(e) {
        this.color3 = `#${e.target.value}`;
      },
      updateNimStyle: function() {

        toastr["success"]("Congrats! your pet has a new style 😊")
        const newNimiStyle = {
          "color1": this.color1,
          "color2": this.color2,
          "color3": this.color3,
          "x1": this.x1,
          "y1": this.y1,
          "x2": this.x2,
          "y2": this.y2,
          "skin_url": 'undefined'
        }

        // axios.post('/update_nimi_style', {
        //       nimStyle: newNimiStyle,
        //   })
        //   .then(function(response) {
        //       toastr["success"]("Congrats! your pet has a new style 😊")

        //   })
        //   .catch(function(error) {
        //       console.log(error);
        //   });
      }
  }
}
</script>

<style>
.jscolor {
  margin: 3px;
  color: rgb(0, 0, 0);
}
</style>