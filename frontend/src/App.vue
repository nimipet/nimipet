<template>
  <div id="app">
    <div v-if="$store.state.modal" id="body-overlay" @click="$store.commit('modal', false);"></div>
    <modal v-if="this.$store.state.modal" />

    <router-view/>
  </div>
</template>

<script>
import modal from './components/Modal.vue';

export default {
  components: {
    modal
  },
  mounted: function () {
   
  }
}
</script>

<style>
#app {
  font-family: 'Work Sans', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
}

#nav a.router-link-exact-active {
  color: #42b983;
}

/*
	Theme Name: Nimipet
	Theme URI: https://github.com/dziungles/Nimipet
*/

select:focus {outline:none;}

/*custom font*/
@import url(https://fonts.googleapis.com/css?family=Work+Sans:400,600);

/*basic reset*/
* {margin: 0; padding: 0;}

/* Change the white to any color ;) */
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0 30px white inset;
}

html, body {
  margin: 0;
  
}


.container {
  padding: 10px;
  position: relative;

}

.wrapper {
  min-height: 100%; 
}

html {
  background: #fff;
}

body {
  font-family: Work Sans, arial, verdana!important;
  font-size:14px;
}

.right-menu {
  position:absolute;
  top:25px;
  right:25px;
  width:40px;
  text-align:center;
}

@media screen and (max-width: 700px) {
  .right-menu {
      right:15px;
  }
}


.btn {
  -webkit-border-radius: 10;
  -moz-border-radius: 10;
  border-radius: 10px;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  background: #ff6a00;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
  border: none;
  cursor: pointer;
}

.btn:hover {
  background: #ff7b1d;
  text-decoration: none;
}

.btn-1 {
  -webkit-border-radius: 7;
  -moz-border-radius: 7;
  border-radius: 7px;
  color: #ffffff;
  font-size: 16px;
  background: #ff6a00;
  padding: 7px 17px 7px 17px;
  text-decoration: none;
  border: none;
  cursor: pointer;
}

.btn-1:hover {
  background: #ff7b1d;
  text-decoration: none;
}

.btn-1-disabled {
  -webkit-border-radius: 7;
  -moz-border-radius: 7;
  border-radius: 7px;
  color: #ffffff;
  font-size: 16px;
  background: #c2c2c2;
  padding: 8px 17px 7px 17px;
  text-decoration: none;
  border: none;
  cursor: default;
}

.btn-2 {
  -webkit-border-radius: 10;
  -moz-border-radius: 10;
  border-radius: 10px;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  background: #57b6c6;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
  border: none;
  cursor: pointer;
  margin: 0 auto;
  display: inline-block;
}

.btn-2:hover {
  background: #60c9db;
  text-decoration: none;
}

.btn-3 {
  -webkit-border-radius: 6;
  -moz-border-radius: 6;
  border-radius: 6px;
  font-family: Arial;
  color: #ffffff;
  font-size: 16px;
  background: #57b6c6;
  padding: 8px 14px 8px 14px;
  text-decoration: none;
  border: none;
  cursor: pointer;
  margin: 0 auto;
  display: inline-block;
  margin-top: 15px;
}

.btn-3:hover {
  background: #60c9db;
  text-decoration: none;
}

a {
  border-bottom: 1px solid #ff6a00;
  text-decoration: none;
  color: black;
}

.a {
  border-bottom: 1px solid #ff6a00;
  text-decoration: none;
  color: black;
  cursor: pointer;
}

.a-bold {
  border-bottom: 1px solid red;
  text-decoration: none;
  color: black;
  cursor: pointer;
  font-weight: bold;
}

.clear {
  clear: both;
}

.leadhref {
  border-bottom: none;
}

.typed-cursor {
  font-size: 28px;
  color:#626262;
}

.footer {
  margin-top: 80px;
  width: 100%;
  text-align: center;
  line-height: 25px;
  margin-bottom: 20px;
}

.sign-up-container {
  width: 250px;
  background-color: #eeeeee;
  border: 1px solid rgb(172, 172, 172);
  border-radius: 5px;
  margin: 0 auto;
  padding: 20px;
  padding-right:10px;
  padding-left: 10px;
}

.login-form-container {
  width: 250px;
  background-color: #eeeeee;
  border: 1px solid rgb(172, 172, 172);
  border-radius: 5px;
  margin: 0 auto;
  padding: 20px;
  padding-right:10px;
  padding-left: 10px;
}

.cptch_input {
  width: 20px!important;
  height: 16px;
}


#body-overlay {
  position: fixed;
  z-index: 100;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5); /*dim the background*/
}



fieldset {
  position: relative;
  border: none; 
  cursor: text; 
}

#label {
  position: absolute;  
  top: 10px;
  color: rgba(0, 0, 0, 0.3);
  transform-origin: top;
  transition: all 0.3s ease;
  left: 30px;
  font-size:18px;
  cursor: text;
}

#first:focus ~ #label {
  color: #ff7b1d;  
}

#first:focus ~ #label,
#first:valid ~ #label {
  position: absolute;
  top: -8px;
  transform: scale(0.6, 0.6);
  color: #ffffff;
}

#first {
  font-size: 20px;  
  width: 100%;
  border: none;  
  margin-top: 10px;
  text-align: center;
}

#first:focus {
  outline: none;
}

.after {
  width: 100%;
  height: 2px;
  background: linear-gradient(to right, #ff6a00, transparent 50%);
  background-color: rgba(0, 0, 0, 0.3);
  background-size: 200% 100%;
  background-position: 100% 0;
  transition: all 0.6s ease;
}

#first:focus ~ .after {
  background-position: 0 0;
}

/* input[type=text], input[type=password] {
  width: 180px;
  height: 20px;
  padding-left: 2px;
} */



/* GAME */

.game-container {
  max-width:464px;
  margin:0 auto;
  text-align:center;
  margin-top:80px;
}

.info-container {
  max-width:600px;
  margin:0 auto;
  text-align:center;
  margin-top:40px;
}

.infobox {
  height: 105px;
  width: 210px;
  line-height: 18px;
  padding-top: 20px;
  text-align: center;
  background-color: #f3f3f3;
  border: 1px solid #a9a9a9;
  border-radius: 4px;
  display: inline-Block;
  margin: 10px;
}

.infobox-text {
height:50px;
width: 100%;
text-align: center;
margin-bottom:10px;

}

.infobox-h1 {
  font-size: 28px;

}

@media screen and (max-width: 700px) {
  .game-container {
      margin-top:120px;
  }
}

@media screen and (max-width: 600px) {
  .game-container {
      margin-top:160px;
  }
}

@media screen and (max-width: 500px) {
  .game-container {
      margin-top:130px;
  }
}

#nimipet-image {
  -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
  user-drag: none;
}

#home-nim-container {
  margin:0 auto;
  text-align:center;
  margin-top:90px;
}

@media screen and (max-width: 1000px) {
  #home-nim-container {
      margin-top:120px;
  }
}

@media screen and (max-width: 500px) {
  #home-nim-container {
      margin-top:180px;
  }
}

#not-enough-nim {
}

#nimiq-address {
  width: 80%;
  max-width: 400px;
  border: 1px dashed #414141;
  height: 30px;
  font-size: 15px;
  padding-top: 3px;
  padding-left: 4px;
}

#invalid-address {
  color:red;
}

#pills-checkbox {
    /* Double-sized Checkboxes */
    -ms-transform: scale(1.3); /* IE */
    -moz-transform: scale(1.3); /* FF */
    -webkit-transform: scale(1.3); /* Safari and Chrome */
    -o-transform: scale(1.3); /* Opera */
}

#pills-div {
  font-size: 15px;
  padding: 5px;
  padding-top: 10px;
  background-color: #ffe8e8;
  border: 1px solid #df4545;
  color: #df4545;
  border-radius: 5px;
  width: 128px;
  margin: 0 auto;
}



/* MINING */

#mining-button {
  display:inline;
  float:left;
  margin-top:0px;
  margin-bottom:5px;
  cursor:pointer;
  font-size:17px;
  padding-top:6px;
  padding-bottom:5px;
}

#nimipet-food-off {
  -webkit-user-drag: none;
  -khtml-user-drag: none;
  -moz-user-drag: none;
  -o-user-drag: none;
  user-drag: none;
}


/* LEADERBOARD */

.infobox-top1 {
  max-width: 400px;
  max-height: 600px;
  line-height: 18px;
  padding-top: 20px;
  text-align: center;
  border-radius: 5px;
  display: block;
  margin: 0 auto;
  margin-top: 50px;
  margin-bottom: 25px;
}

.infobox-leaders {
  max-width: 160px;
  max-height: 600px;
  line-height: 18px;
  padding-top: 20px;
  text-align: center;
  display: inline-block;
  margin: 30px;
  margin-top: 20px;
  word-break: break-all;
}

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
  margin-top:40px;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
  background-color: #e6e6e6;
}

#cemetery-mobile {
  display: none;
}


/* MODAL */

.modal-close {
  position: fixed;
  top: 12px;
  right: 20px;
  cursor: pointer;
  font-size: 30px;
}

.modal-close-text {
  border-bottom: 1px solid #ff6a00;
  text-decoration: none;
  color: black;
  cursor:pointer;
  margin:0 auto;
}

.modal-window {
  z-index: 100;
  position: absolute;
  top: 20px;
  background-color: white;
  width:900px;
  left: 50%;
  transform:translateX(-50%);
  margin-bottom: 60px;
  border: 1px solid grey;
  display: none;
}

.modal-content {
  margin: 40px;
  margin-top: 60px;
  margin-bottom: 40px;
}

@media screen and (max-width: 1100px) {
  .modal-window {
      max-width:90%;
  }
}

#points-mobile {
  display: none;
}

@media screen and (max-width: 530px) {
  .modal-window {
    max-width: 95%;
  }
  .modal-content {
    margin: 20px;
    margin-top: 40px;
    margin-bottom: 40px;
  }
  #modal-leaderboard {
    margin: 10px;
    margin-top: 60px;
    margin-bottom: 40px;
  }
  #points-mobile {
    display: block;
  }
  #points-desktop {
    display: none;
  }
  #cemetery-desktop {
    display: none;
  }
  #cemetery-mobile {
    display: table;
  }
}


/* Mining threads range slider */

.slider {
  border-radius: 5px;
  background: #d7dcdf;
  height: 8px;
  outline: none;
}

.range-slider {
  left: 0;
  right: 0;
}

.range-slider__range {
  -webkit-appearance: none;
  width: 104px;
  height: 8px;
  border-radius: 5px;
  background: #d7dcdf;
  outline: none;
  padding: 0;
  margin: 0;
}

.range-slider__value {
  display: inline-block;
  position: relative;
  width: 8px;
  color: #5f5f5f;
  line-height: 7px;
  text-align: center;
  border-radius: 3px;
  background: #dedede;
  padding: 5px 7px;
  margin-left: 8px;
  margin-top: 8px;
  margin-bottom: 6px;
  font-size: 13px;
}

.range-slider__value:after {
  position: absolute;
  top: -5px;
  left: -6px;
  width: 0;
  height: 0;
  border-top: 7px solid transparent;
  border-right: 7px solid #dedede;
  border-bottom: 7px solid transparent;
  content: '';
  margin-top: 6.5px;
  margin-bottom: 10px;
}


/* Simple tooltip */

.tooltip .tooltiptext::after {
  content: " ";
  position: absolute;
  top: 50%;
  right: 100%; /* To the left of the tooltip */
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent black transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}

/* Nimipet SVG Element*/


.cls-1 {
  fill: url(#grad2);
  fill-rule: evenodd;
}

.top1 {
  fill: url(#top1);
  fill-rule: evenodd;
}
.top2 {
  fill: url(#top2);
  fill-rule: evenodd;
}
.top3 {
  fill: url(#top3);
  fill-rule: evenodd;
}
.top4 {
  fill: url(#top4);
  fill-rule: evenodd;
}
.top5 {
  fill: url(#top5);
  fill-rule: evenodd;
}
.top6 {
  fill: url(#top6);
  fill-rule: evenodd;
}
.top7 {
  fill: url(#top7);
  fill-rule: evenodd;
}
.top8 {
  fill: url(#top8);
  fill-rule: evenodd;
}
.top9 {
  fill: url(#top9);
  fill-rule: evenodd;
}
.top10 {
  fill: url(#top10);
  fill-rule: evenodd;
}



/* NimiPet SVG And Skins */

.skin {
  margin-top: 1em;
}

.skin p {
  margin-bottom: 1em;
}

.slidersXY input {
  width: 100%;
}

</style>
