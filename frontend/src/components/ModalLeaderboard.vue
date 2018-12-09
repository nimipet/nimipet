<template>
  <div>
    <div style="position:relative;">

      <!-- LEADERBOARD -->
      <div style="font-size:24px;text-align:center;"><b>Leaderboard</b></div>
      <div style="position:relative;margin-bottom:120px;">
        <div style="max-width:680px;margin:0 auto;text-align:center;margin-top:20px;" id="leaders">
          <!-- top 1 -->
          <div class="infobox-top1" v-for="(nimi, index) in leaderboard" v-if="index == 0 && loaded">
            <nimipet-character :nimi="nimi" :index="index" :currentTime="currentTime" :height="'180px'" />
            <br>
            <div style="font-size: 16px;margin-top:5px;margin-bottom:3px;"><b>{{index+1}}. <router-link v-bind:to="nimi.nimi_slug" class='a' target="_blank">{{nimi.nimi_name}}</router-link></b></div>NIM value: {{Math.floor(nimi.nimi_value)}}
            <br>Points: {{Math.floor(nimi.nimi_points)}}
          </div>
          <!-- top 2-10 -->
          <div class="infobox-leaders" v-for="(nimi, index) in leaderboard" v-if="index <=9 && index >=1 && loaded">
            <nimipet-character :nimi="nimi" :index="index" :currentTime="currentTime" :height="'140px'" />
            <br>
            <div style="font-size: 14px;margin-top:5px;margin-bottom:3px;"><b>{{index+1}}. <router-link v-bind:to="nimi.nimi_slug" class='a' target="_blank">{{nimi.nimi_name}}</router-link></b></div>NIM value: {{Math.floor(nimi.nimi_value)}}
            <br>Points: {{Math.floor(nimi.nimi_points)}}
          </div>
          <!-- top 11-100 -->
          <table id="leaders-table">
            <tbody>
              <tr>
                <th width="15%">Place</th>
                <th width="45%">Name</th>
                <th widt="30%">NIM value</th>
                <th width="15%"><span id="points-desktop">Points</span><span id="points-mobile">PTS</span></th>
              </tr>
              <tr v-for="(nimi, index) in leaderboard" v-if="index >=10 && index <= 99 && loaded">
                <td>{{index +1}}</td>
                <td><router-link v-bind:to="nimi.nimi_slug" class="a" target="_blank">{{nimi.nimi_name}}</router-link></td>
                <td>{{Math.floor(nimi.nimi_value)}}</td>
                <td>{{Math.floor(nimi.nimi_points)}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- CEMETERY -->
      <div style="font-size:24px;text-align:center;"><b>Cemetery</b></div>
      <div style="position:relative;">
        <div style="max-width:680px;margin:0 auto;text-align:center;margin-top:20px;" id="unborns">
          <table id="cemetery-desktop">
            <tbody>
              <tr>
                <th width="25%">Time of death</th>
                <th width="35%">Name&nbsp;<img src="/img/cross.png" width="8"></th>
                <th width="30%">NIM value</th>
                <th width="15%">Points</th>
              </tr>
              <tr v-for="nimi in deadlist" v-if="loaded">
                <td>{{nimi.timestamp}}</td>
                <td>{{nimi.nimi_name}}</td>
                <td>{{Math.floor(nimi.nimi_value)}}</td>
                <td>{{Math.floor(nimi.nimi_points)}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import nimipetCharacter from "./NimipetCharacter.vue";

export default {
  data: function() {
    return {
      deadlist: '',
      leaderboard: '',
      currentTime: '',
      loaded: false
    }
  },
  mounted: function() {
    this.axios.get('/get-leaderboard').then(result => {
      this.leaderboard = result.data.leaderboard;
      this.deadlist = result.data.deadlist;
      this.currentTime = result.data.current_time;
      this.loaded = true;
    });
  },
  methods: {

  },
  components: {
    nimipetCharacter
  }
}
</script>