<template>
    <div>
        <span v-if="!this.$store.state.nimi.nimi_state">
            Loading...
        </span>
        <span v-if="this.$store.state.nimi.nimi_state == 'unborn'">
          Tip: Click on the egg to start the game
        </span>
        <span v-else-if="this.$store.state.nimi.nimi_state == 'dead'">
          Unfortunately, your nimipet has died. You can start again.
        </span>
        <span v-else-if="(this.$store.state.nimi.nimi_name == null) && (this.$store.state.nimi.nimi_state == 'alive')">
          Tip: Give your nimipet a name
        </span>
        <span v-else-if="(this.$store.state.nimi.nimi_state == 'alive') && (this.$store.state.nimi.nimi_points < 1)">
          Tip: Start mining to produce food for your nimipet
        </span>
        <span v-else-if="(this.$store.state.nimi.nimi_state == 'alive') && (this.$store.state.nimi.nimi_points > 2)">
          Tip: Keep growing your nimipet and rise in the leaderboard
        </span>
        <span v-else-if="(this.$store.state.nimi.nimi_state == 'alive') && (this.$store.state.nimi.food_pieces > 0)">
          Tip: Drag and drop a piece of food on your nimipet to feed it
        </span>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            // tip: 'Loading...'
        }
    },
    methods: {

    },
    mounted: function() {

    }
}
</script>