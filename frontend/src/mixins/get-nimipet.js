module.exports = {
    methods: {
        getNimipet: function() {
            axios.get('/get_nimipet')
                .then((response)=> {
                    console.log(response);
                    app.nimi = response.data.nimi;
                    app.nimiMood = response.data.mood;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
    },
}