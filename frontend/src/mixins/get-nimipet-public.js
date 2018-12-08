module.exports = {
    methods: {
        // getNimipet: function() {
        //     var pathArray = window.location.pathname.split('/');
        //     console.log(pathArray[2]);
        //     axios.get(`/get_nimipet_public/${pathArray[2]}`)
        //         .then((response) => {
        //             console.log(response.data);
        //             this.nimi = response.data.nimi;
        //             this.nimiMood = response.data.nimiMood;
        //             this.childDataLoaded = true;
        //         }).then( ()=> {
        //                 let nimbusScript = document.createElement('script');
        //                 nimbusScript.setAttribute('src', '/javascripts/nimipet_nimbusminer.js');
        //                 document.head.appendChild(nimbusScript);

        //                 let nimipetMining = document.createElement('script');
        //                 nimipetMining.setAttribute('src', '/javascripts/nimipet_mining.js');
        //                 document.head.appendChild(nimipetMining);

        //                 let helpersScripts = document.createElement('script');
        //                 helpersScripts.setAttribute('src', '/javascripts/helpers.js');
        //                 document.head.appendChild(helpersScripts);
                
        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        // },
    },
}