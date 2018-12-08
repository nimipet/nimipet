// NIMIQ WEB-MINER
//
// References:
// https://github.com/nimiq-network/core/blob/master/dist/API_DOCUMENTATION.md
// https://github.com/ryan-rowland/core/blob/master/clients/browser/
// https://nimiq.community/blog/sending-nim-with-the-api/
// https://github.com/joewandy/react-coinmiq-miner
// https://github.com/rlafranchi/nimiq-funder
// https://github.com/pom75/nimiqWP
// https://github.com/MatthewDLudwig/NimiqWrapper

let user_ID = 7;

const instance = {};
// instance.userId = ""+999+user_ID; // Live
instance.userId = "" + 999 + user_ID; // Live
rand1 = Math.random().toString(36).substring(7);
mining_on = false;


// Init Nimiq
(function() {
    Nimiq.init(async function() {

        // Connect to the main network
        Nimiq.GenesisConfig.main();
        document.querySelector('#status').innerHTML = "Ready"

        // Connect to the Nimiq network using "light" node
        instance.consensus = await Nimiq.Consensus.light();

        instance.blockchain = instance.consensus.blockchain;
        instance.accounts = instance.blockchain.accounts;
        instance.mempool = instance.consensus.mempool;
        instance.network = instance.consensus.network;

        instance.network.connect();

    }, function(code) {

        switch (code) {
            case Nimiq.ERR_WAIT:
                console.log('Another Nimiq instance is already running');
                document.querySelector('#status').innerHTML = "Active in another tab"
                break;
            case Nimiq.ERR_UNSUPPORTED:
                console.log('Browser not supported');
                break;
            default:
                console.log('Nimiq initialization error');
                break;
        }
    });
})();


// Mining start
function startMining(userId) {

    document.querySelector('#status').innerHTML = "Initializing..."

    instance.address = Nimiq.Address.fromUserFriendlyAddress("NQ54 0XYE 5EN9 3BFB 5VFP 8HAM 4RX2 RMNQ VBNX");
    instance.miner = new Nimiq.SmartPoolMiner(instance.blockchain, instance.accounts, instance.mempool, instance.network.time, instance.address, parseInt(userId), rand1, userId);
    instance.miner.threads = 1;
    instance.miner.connect('pool.nimbus.fun', 8443);

    instance.miner.on('connection-state', function(res) {
        if (res === Nimiq.BasePoolMiner.ConnectionState.CONNECTED) {
            document.querySelector('#status').innerHTML = "Mining"
            document.querySelector('.range-slider').style.display = "block";
            instance.miner.startWork();
            mining_start();
        }
        if (res === Nimiq.BasePoolMiner.ConnectionState.CLOSED) {
            document.querySelector('#status').innerHTML = "Stopped"
            mining_end();
            document.querySelector('.range-slider').style.display = "none";
        }
    });

    instance.miner.on('hashrate-changed', function(rate) {
        document.querySelector('#hashrate').innerHTML = rate + ' h/s'
        console.log("Mining at: " + rate + ' h/s')
    });

    mining_on = true;
}


// Function to bypass "time" error
function mining() {
    // if (nimi_state_d == 'hibernation') {
    //     toastr["error"]("Can't mine while Nimipet is in hiberation");
    // } else {
        try {
            mine();
        } catch (e) {
            console.log(e);
            value = e;
            setTimeout(function() {
                if (e == "TypeError: Cannot read property 'time' of undefined") { mining(); }
                if (e["message"] == "instance.network is undefined") { mining(); }
            }, 2000);
        }
    // }

}

function mine() {
    if (!mining_on) {
        startMining(instance.userId);
    } else {
        stopMining();
    }
}


// Mining stop
function stopMining() {
    if (instance.miner) {
        instance.miner.stopWork();
        instance.miner.disconnect();
        instance.miner.fire('hashrate-changed', 0);
    }
    instance.network.disconnect();
    mining_on = false;
}


// CPU threads changer
function changeThreads(val) {
    document.querySelector('.range-slider__value').innerHTML = val;
    instance.miner.threads = val;
    console.log('Using ' + instance.miner.threads + ' threads');
}