<template>
  <div class="info-container">

    <div>
      <span v-if="!this.$store.state.nimi.nimi_state">
          Loading...
      </span>
      <span v-if="this.$store.state.nimi.nimi_mood == 'unborn'">
        Tip: Click on the egg to start the game
      </span>
      <span v-else-if="this.$store.state.nimi.nimi_mood == 'dead'">
        Unfortunately, your nimipet has died. You can start again.
      </span>
      <span v-else-if="(this.$store.state.nimi.nimi_name == null) && (this.$store.state.nimi.nimi_state == 'alive')">
        Tip: Give your nimipet a name
      </span>
      <span v-else-if="(this.$store.state.nimi.nimi_state == 'alive') && (this.$store.state.nimi.nimi_points < 3)">
        Tip: Start mining to produce food for your nimipet
      </span>
      <span v-else-if="(this.$store.state.nimi.nimi_state == 'alive') && (this.$store.state.nimi.nimi_points > 2)">
        Tip: Keep growing your nimipet and rise in the leaderboard
      </span>
      <span v-else-if="(this.$store.state.nimi.nimi_state == 'alive') && (this.$store.state.nimi.food_pieces > 0)">
        Tip: Drag and drop a piece of food on your nimipet to feed it
      </span>
    </div>

    <br>
    <br>

    <div class="infobox">
      <div class="infobox-text" style="margin-bottom:14px;">
        {{ $t("message.box_1") }}
      </div>
      <span class="infobox-h1" id="timer" style="font-family:Courier;font-size:24px;font-weight:bold;color:#454545;">
        <span v-if="this.$store.state.timePassed != null && this.$store.state.timePassed != 'Hibernated'">
          {{ this.$store.state.timePassed }}
        </span>
        <span v-else-if="this.$store.state.timePassed == 'Hibernated'">
          <span style="font-family:Work sans;font-weight:normal;font-size:22px;">Hibernated</span>
        </span>
        <span v-else>
          --
        </span>
      </span>
    </div>

    <div class="infobox">
      <div class="infobox-text">
        {{ $t("message.box_2") }}
        <br>
        <span style="font-size:11px;">
          {{ $t("message.box_2_bottom") }}
        </span>
      </div>
      <span class="infobox-h1" id="nim-points">
          {{ Math.floor(this.$store.state.nimi.nimi_points) }}
      </span>
    </div>

    <div class="infobox">
      <div class="infobox-text">
        {{ $t("message.box_3") }}
      <br>
      <span style="font-size:11px;">
        {{ $t("message.box_3_bottom") }}
      </span>
      </div>
      <span class="infobox-h1" id="nim-value">
        {{ Math.floor(this.$store.state.nimi.nimi_value) }}
      </span>
    </div>

    <div class="infobox">
      <div class="infobox-text">
        {{ $t("message.box_4") }}
      </div>
      <span class="infobox-h1" id="nim-position">
        {{ Math.floor(this.$store.state.nimi.nimi_position) }}
      </span>
    </div>

  </div>
</template>

<script>
 
export default {
	data: function() {
		return {

		}
	},
}
</script>