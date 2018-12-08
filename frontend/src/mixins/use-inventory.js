module.exports = {
    methods: {

        getInventoryHome: function() {
            this.burgers = app.nimi.food_pieces;

            if (app.nimi.food_pieces > 0) {
                if (app.nimi.food_pieces == 1) {
                    this.pieces = " piece";
                } else {
                    this.pieces = " pieces";
                }
            }


            axios.get('/get_inventory_home')
                .then((response) => {
                    this.inventory = response.data;
                    app.inventory = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        useInventory: function(item) {

            //if Item is resurrection
            if (item.item == 'resurrection') {
                if (app.nimi.nim_state == 'dead') {
                    axios.post('/use_resurrection', {
                            itemId: item.item_ID
                        })
                        .then((response) => {
                            if (response.data == 'success') {
                                toastr["success"]("Nimipet has been resurrected and NIM value restored. Refresh your browser window.");
                                this.getNimipet();
                            } else if (response.data == 'too_late') {
                                toastr["error"]("Your nimipet's NIM value was re-distributed during the airdrop. Your nimipet cannot be revived.");
                            }

                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                } else {
                    toastr["error"]("Can't resurrect a nimipet that is not dead.");

                }
            } else {
                //if other item 
                axios.post('/use_inventory', {
                        itemId: item.item_ID,
                        item: item.item
                    })
                    .then((response) => {
                        if (response.data == 'hibernation') {
                            toastr["error"]("Can't feed an hibernated pet");
                        } else if (response.data == 'hibernation activated') {
                            toastr["success"]("Your nimipet is in hibernation for the next 14 days");
                            this.getInventoryHome();
                            this.getNimipet();
                            var audio = new Audio('https://nimipet.com/fx/fed.mp3');
                            audio.play();

                        } else {
                            this.getInventoryHome();
                            this.getNimipet();
                            var audio = new Audio('https://nimipet.com/fx/fed.mp3');
                            audio.play();
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });

            }

        },
        useBurger: function() {
            if (app.nimi.nim_state == 'alive') {
                this.food_requests = this.food_requests+1;
                let i = this.food_requests;
                setTimeout(()=> {
                    if (i === this.food_requests) {
                        app.nimi.food_pieces--;
                        var audio = new Audio('https://nimipet.com/fx/fed.mp3');
                        audio.play();
                        this.burgers -= this.food_requests;

                        axios.post('/update_food_eaten', {
                                amount: this.food_requests
                            })
                            .then((response) => {
                                if (response.data == 'pet in hibernation') {
                                    toastr["error"]("Can't feed a nimi in hibernation");
                                    app.nimiMood = nimi_state_d;
                                } else {
                                    app.nimiMood = 'happy';
                                    // app.nimi.food_pieces--;
                                    // var audio = new Audio('https://nimipet.com/fx/fed.mp3');
                                    // audio.play();
                                    app.nimi = response.data.nimi;
                                    this.burgers = response.data.nimi.food_pieces;
                                    this.food_requests = 0;
                                }

                            })
                            .catch((error)=> {
                                console.log(error);
                                 this.food_requests = 0;
                            });
                    }
                }, 300)
            }
        },
    },
}