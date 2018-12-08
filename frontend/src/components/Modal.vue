<template>
    <div class="modal-window" id="faq" style="display: block">
        <div class="modal-content">

            <div class="modal-close" @click="$store.commit('modal', false);">✕</div>

            	<div v-if="this.$store.state.modal == 'help'">
            		<help/>	
            	</div>

            	<div v-if="this.$store.state.modal == 'leaderboard'"> 
                <leaderboard/>
            	</div>
                
              <div v-if="this.$store.state.modal == 'inventory'"> 
                <inventory/>
              </div>

              <div v-if="this.$store.state.modal == 'referrals'"> 
                <referrals/>
              </div>

              <div v-if="this.$store.state.modal == 'pubLink'"> 
                <pub-link/>
              </div>

              <div v-if="this.$store.state.modal == 'withdrawal'"> 
                <withdrawal/>
              </div>

              <div v-if="this.$store.state.modal == 'managerMarket'"> 
                <manager-market/>
              </div>
          
            <div style="margin:0 auto;text-align:center;margin-top:60px;">
            <span class="modal-close-text" @click="$store.commit('modal', false);">Close</span>
            </div>

        </div>
    </div>
</template>

<script>
import help from './ModalHelp.vue';
import leaderboard from './ModalLeaderboard.vue';
import inventory from './ModalInventory.vue';
import referrals from './ModalReferrals.vue';
import withdrawal from './ModalWithdrawal.vue';
import managerMarket from './ModalManagerMarket.vue';
import pubLink from './ModalPubLink.vue';

export default {
    data: function() {
        return {
            title: ''
        }
    },
    components: {
        help,
        leaderboard,
        inventory,
        referrals,
        withdrawal,
        managerMarket,
        pubLink
    },
    mounted: function () {
        window.scrollTo(0, 0);
    }
}
</script>
<style>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

.modal-window {
    /* max-height: calc(100vh - 210px);
    overflow-y: auto; */
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}


/*  */
</style>