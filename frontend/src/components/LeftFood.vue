<template>
    <div>
      <div class="food-piece-off" v-if="this.$store.state.items.food.burger == 0">
        <img src="/img/food-off.png" class="food-icon-off burger">
        <span id="inv_food_count">0</span>
      </div>
      <draggable-container>
        <div id="nimipet-food">
          <div class="food-piece" v-for="(index, item) in this.$store.state.items.food" v-if="index > 0" :key="item">

            <div style="margin-bottom:-6px" class="draggable">
              <img :src="`/img/food-${item}.png`" v-bind:title="item.charAt(0).toUpperCase() + item.slice(1)" v-bind:class="'food-icon '+item">
            </div>
            <span id="inv_food_count">{{ index }}</span>

          </div>
        </div>
      </draggable-container>
    </div>
</template>

<script>
import DraggableContainer from './DraggableContainer.vue';

export default {
  data: function() {
    return {

    }
  },
  mounted: function() {
    
  },
  components: {
    DraggableContainer
  }
}
</script>

<style>
  #nimipet-food {
    display:block;
    position: absolute;
    width:42px;
    margin-top:22px;
    left:-3px;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
  }
  #nimipet-food:focus {
    outline: none;
  }

  .food-piece {
    margin-bottom: 17px;
    text-align: center;
    width: 42px;
    font-weight: bold;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
  }

  .food-piece-off {
    margin-top: 22px;
    text-align: center;
    width: 42px;
    margin-bottom: -5px;
    margin-left: -3px;
    font-weight: bold;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -o-user-select: none;
    user-select: none;
  }

  .food-icon-off {
    /* position: absolute; */
    /* margin-left: -2px; */
  }

  .food-icon {
    margin-bottom: 6px;
    z-index: 10;
    cursor: move;
  }

  .burger {
    max-width: 40px;
  }
  .burger.draggable-mirror {
    min-width: 42px;
  }

  .water {
    max-width: 32px;
  }
  .water.draggable-mirror {
    min-width: 34px;
  }

  .durian {
    width: 42px;
  }
  .durian.draggable-mirror {
    min-width: 44px;
  }
  
  .peyote {
    max-width: 40px;
  }
  .peyote.draggable-mirror {
    min-width: 42px;
  }

  .pills {
    max-width: 43px;
  }
  .pills.draggable-mirror {
    min-width: 45px;
  }

  .pepper {
    max-width: 38px;
  }
  .pepper.draggable-mirror {
    min-width: 40px;
  }
</style>