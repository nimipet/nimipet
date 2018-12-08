<template>
    <div style="position:relative;">
        <div style="font-size:24px;text-align:center;margin-bottom: 40px;">
            <b>Put to sleep</b>
        </div>
        You can put to sleep your nimipet and withdraw all NIMs it is worth. Your nimipet will die and you will lose all your points. This cannot be undone.
        <br>
        <br> In order to make it as less painful as possible, we will provide you with the sleeping pills that you need to drag and drop on your nimipet. Your nimipet will not experience any pain.
        <br>
        <br> To receive the pills, please enter your NIMIQ wallet address to which we will transfer the total value this nimipet after you feed the pills to your nimipet.
        <br>
        <br> Total value: <b><span id="nim-withdraw-value">{{nimValue}}</span> NIM</b>
        <div style="margin:0 auto;text-align:center;margin-top:40px;">

          <div v-if="nimValue < 1" id="not-enough-nim" style="color:red;">
            You have not enough NIM. The minimum amount to withdraw is 1 NIM.
          </div>

          <div v-else-if="nimValue > 1">
            <input type="text" id="nimiq-address" placeholder="Your Nimiq wallet address" maxlength="44" v-model="walletAddress"  @change="addressValidation">
            <br>
            <div style="margin-top: 10px;" id="address-feedback">
              <span id="invalid-address" v-if="invalidAddress">The entered address is not valid</span>
            </div>
            <div id="pills-div" v-if="pillsDiv">
              <label>
              <input id="pills-checkbox" @change="changed" type="checkbox">&nbsp;Give me pills</label>
            </div>
            <div v-if="pillsMessage" id="pills-message" style="max-width:370px;margin: 0 auto;margin-top: 30px;">
              Your pills are now ready. Feed them to your nimipet. If you have changed your mind, just un-check the above checkbox.
            </div>
          </div>

        </div>
    </div>
</template>
<script>
export default {
    data: function() {
        return {
            checked: false,
            nimValue: '',
            pillsDiv: false,
            invalidAddress: false,
            walletAddress: '',
            pillsMessage: false,
            pills: '',
            disableInput: false,
        }
    },
    mounted: function() {
        this.nimValue = this.$store.state.nimi.nimi_value;
    },
    methods: {
        addressValidation: function() {
            if (Address.fromString(this.walletAddress)) {
                this.pillsDiv = true;
                this.invalidAddress = false;
                // validAddress = true;
                this.updateAddress(this.walletAddress);
            } else {
                this.invalidAddress = true;
                this.pillsDiv = false;
                // validAddress = false;
            }
        },
        updateAddress: function(address) {
            var address = address.replace(/\s/g, '');
            this.axios.post('/nimiq-address', {
                    address: address,
                })
                .then((response) => {
                    console.log('address updated');
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        changed: function(e) {

            if (e.target.checked) {
                this.disableInput = true;
                this.pillsMessage = true;
                this.pills = true;
                this.givePills();
            } else {
                this.disableInput = false;
                this.pillsMessage = false;
                this.pills = false;
                this.givePills();
            }

        },
        givePills: function() {
            if (this.pills) {
                // console.log('true')
                // app.activatePills = true;
                //  this.$store.commit('items', { type, item, available } );
                let type = 'food';
                let item = 'pills';
                let available = 1;
                this.$store.commit('items', {type, item, available});
            } else {
                // app.activatePills = false;
                // console.log('false')
            }
        }
    },
}
</script>