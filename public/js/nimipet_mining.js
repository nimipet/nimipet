mining_on = false;
d = false;
mined_time = parseInt(app.nimi.food_progress);

//
// If mining started successfuly, the script then starts (later stops) the food mining
//
function mining_start() {
    mining_on = true;
    d = new Date();

    // Ajax
    function update_food_started() {
        axios.post('/update_food_started', {
                userId: app.nimi.user_ID
            })
            .then(function(response) {})
            .catch(function(error) {
                console.log(error);
            });
    }

    update_food_started();

    update_food_progress_ajax = setInterval(update_food_progress, 30000);

    // Ajax
    function update_food_progress() {
        axios.post('/update_food_progress', {
                data: mining_time,
                userId: app.nimi.user_ID
            }).then(function(response) {})
            .catch(function(error) {
                console.log(error);
            });
    };
    miningTime();
}

function mining_end() {
    clearInterval(update_food_progress_ajax);
    new_d = new Date();
    mining_on = false;
    console.log("mining time: ", (new_d - d));
    mined_time = (new_d - d) + mined_time;

    function update_food_progress() {
        axios.post('/update_food_progress', {
                data: mined_time,
                userId: app.nimi.user_ID
            }).then(function(response) {})
            .catch(function(error) {
                console.log(error);
            });
    }

    update_food_progress();
}


//
// Mining time tracker
//
function miningTime() {
    if (typeof myMiningTimer !== 'undefined') {
        clearInterval(myMiningTimer);
    }

    myMiningTimer = setInterval(miningTimer, 1000);

    function miningTimer() {
        if (mining_on) {
            new_d = new Date();
            mining_time = (new_d - d) + mined_time;
            percent = ((mining_time / 900000) * 100).toFixed(2);
            if (percent >= 100) {
                console.log('mined 1 food')
                // foodPieces();
                d = new Date();
                mined_time = 0;
                percent = 0;
                percent = percent.toFixed(2);
                // Ajax
                // function update_food_pieces() {
                var audio = new Audio('https://nimipet.com/fx/food-ready.mp3');
                audio.play();
                app.nimi.food_pieces++

                //reload feedjs 

                // 

                axios.post('/update_food_pieces', {
                        userId: app.nimi.user_ID
                    })
                    .then(function(response) {

                    })
                    .then(() => {
                        axios.get('/get_inventory_home')
                            .then((response) => {
                                app.inventory = response.data;
                            })
                            .then(() => {
                                //reset draggables
                                coffee.destroy();
                                doughnut.destroy();
                                burger.destroy();
                                pills.destroy();

                                // const inventory = [doughnut, coffe, pills];
                                // app.inventory.forEach((i) => {
                                //     if (i.available > 0) {
                                //         inventory.forEach((inv) => {
                                //             var varToString = varObj => Object.keys(varObj)[0]
                                //             var varName = varToString({ inv })
                                //             if (i.item === varName) {
                                //                 console.log(i.item);
                                //                 var item = i.item;
                                //                 item.destroy();
                                //             }
                                //         })

                                //     }
                                // })

                                var script = document.getElementById("feed_script");
                                script.parentElement.removeChild(script);


                                let feed = document.createElement('script');
                                feed.id = "feed_script";
                                feed.setAttribute('src', '/javascripts/feed.js');
                                document.head.appendChild(feed);
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    })
                    .catch(function(error) {
                        console.log(error);
                    });



                // }
                // update_food_pieces();

            }
            document.getElementById("food-percent").innerHTML = percent + " %";
            miningTime();
        }
    }
}