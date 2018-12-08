<template>
  <div>

    <div v-if="this.$store.state.nimi.nimi_mood == 'unborn' || this.$store.state.nimi.nimi_mood == 'dead'">
      <div v-if="this.$store.state.nimi.nimi_mood == 'unborn'">
        <span v-if="mod != 'pub'">
          <img src="/img/00.png" ref="nimipet-image" id="nimipet-image" width="200" @click="nimipetBirth">
          <div style="margin-top:50px;font-size:18px;margin-bottom:100px;">To start the game, click on the egg</div>
          <span @click="logout" class="a">Log out</span>
        </span>
        <span v-else>
          <img src="/img/00.png" ref="nimipet-image" id="nimipet-image" width="200">
        </span>
      </div>
      <div v-if="this.$store.state.nimi.nimi_mood == 'dead'" style="margin-bottom:-3px;">
        <span v-if="mod != 'pub'">
          <img src="/img/nimipet-dead.gif" ref="nimipet-image" @click="nimipetBirth" id="nimipet-image" width="200" >
        </span>
        <span v-else>
          <img src="/img/nimipet-dead.gif" ref="nimipet-image" id="nimipet-image" width="200" >
        </span>
      </div>
    </div>

    <div v-else id="nimipet-container" class="nimipet-svg">
      
      <!-- <speech-bubble v-if="this.$store.state.nimi.nimi_mood != 'unborn' && this.$store.state.nimi.nimi_mood != 'dead'"/> -->

      <!-- <div class="draggable" id="real-over" style="display:none;position:absolute;width:200px;height:200px;"></div> -->

			<!-- Nimipet SVG -->
      <div id="nimi-svg" class="slot-wrapper">
        <svg id="svg-nimipet" data-name="Layer 1" style="position:absolute;bottom:0;left:0;" viewBox="0 0 54.13 50.57" width="200" heigh="200" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            
          <!-- Nimipet color and gradient -->
          <defs>
            <linearGradient id="grad2" 
            :x1="x1" 
            :y1="y1" 
            :x2="x2" 
            :y2="y2" 
            spreadMethod="reflect">
              <stop offset="0%" :stop-color="color1"></stop>
              <stop offset="50%" :stop-color="color2"></stop>
              <stop offset="100%" :stop-color="color3"></stop>
            </linearGradient>
          </defs>

          <!-- <defs>
            <pattern id="img1" x="1" y="1" height="1" width="1">
              <image xlink:href="undefined" width="100%" height="100%"></image>
            </pattern>
          </defs> -->
          
          <!-- body -->
          <path class="cls-1" d="M304.44,412v8.58a0.51,0.51,0,0,1-.5.5H291.1a0.51,0.51,0,0,1-.5-0.5v-5.81a0.5,0.5,0,0,1,.5-0.5h5.66a0.51,0.51,0,0,0,.5-0.5V412a0.51,0.51,0,0,0-.5-0.5h-2.08a0.49,0.49,0,0,1-.44-0.25l-5.7-9.87-5.7-9.87a0.49,0.49,0,0,1,0-.5l2.89-5a0.51,0.51,0,0,0-.18-0.69l-4.5-2.6a0.5,0.5,0,0,1-.18-0.69l3.09-5.35a0.51,0.51,0,0,1,.69-0.18l4.5,2.6a0.51,0.51,0,0,0,.69-0.18l4.41-7.64a0.49,0.49,0,0,1,.44-0.25h22.79a0.49,0.49,0,0,1,.44.25l4.41,7.64a0.51,0.51,0,0,0,.69.18l4.51-2.6a0.5,0.5,0,0,1,.69.18l3.09,5.35a0.51,0.51,0,0,1-.18.69l-4.5,2.6a0.51,0.51,0,0,0-.18.69l2.89,5a0.49,0.49,0,0,1,0,.5l-5.7,9.87-5.7,9.87a0.49,0.49,0,0,1-.44.25h-2.08a0.51,0.51,0,0,0-.5.5v1.76a0.51,0.51,0,0,0,.5.5H321a0.51,0.51,0,0,1,.5.5v5.81a0.51,0.51,0,0,1-.5.5H308.19a0.51,0.51,0,0,1-.5-0.5V412a0.51,0.51,0,0,0-.5-0.5h-2.24a0.51,0.51,0,0,0-.5.5h0Zm10.64-35.86,4.29,7.44,4.29,7.44a0.49,0.49,0,0,1,0,.5l-4.29,7.44-4.29,7.44a0.49,0.49,0,0,1-.44.25H297.48a0.49,0.49,0,0,1-.44-0.25l-4.29-7.44-4.29-7.44a0.49,0.49,0,0,1,0-.5l4.29-7.44,4.29-7.44a0.49,0.49,0,0,1,.44-0.25h17.17a0.49,0.49,0,0,1,.44.25h0Z" transform="translate(-279 -371)"></path>
          
          <!-- ready to eat state -->
          <g v-if="this.$store.state.nimi.nimi_temp == 'eating'">
            <path class="eating-state" d="M477.07,386.63a7.88,7.88,0,0,1,5.8,2.6,9.22,9.22,0,0,1,0,12.33,7.78,7.78,0,0,1-11.61,0,9.22,9.22,0,0,1,0-12.33,7.88,7.88,0,0,1,5.8-2.6h0Zm4.33,4a5.79,5.79,0,0,0-8.67,0,7.24,7.24,0,0,0,0,9.63,5.79,5.79,0,0,0,8.67,0,7.24,7.24,0,0,0,0-9.63h0Z" transform="translate(-450 -371.01)" style=""></path>
            <polygon class="eating-state" points="30.08 10.2 37.93 10.2 37.93 12.4 30.08 12.4 30.08 10.2 30.08 10.2" style=""></polygon>
            <polygon class="eating-state" points="16.2 10.2 24.06 10.2 24.06 12.4 16.2 12.4 16.2 10.2 16.2 10.2" style=""></polygon>
          </g>

          <!-- happy -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'happy'">
            <path class="happy-state" d="M295,387.22a4.17,4.17,0,0,1,7.12-2.95h0a4.16,4.16,0,0,1,1.22,2.95h-2.2a2,2,0,0,0-.57-1.39h0a2,2,0,0,0-3.36,1.39H295Z" transform="translate(-279 -371)"></path>
            <path class="happy-state" d="M308.83,387.22a4.17,4.17,0,0,1,7.12-2.95h0a4.16,4.16,0,0,1,1.22,2.95H315a2,2,0,0,0-.57-1.39h0a2,2,0,0,0-3.36,1.39h-2.2Z" transform="translate(-279 -371)"></path>
            <path class="happy-state" d="M316.48,395.28a12.71,12.71,0,0,1-20.83,0l1.8-1.25a10.53,10.53,0,0,0,17.24,0l1.8,1.25h0Z" transform="translate(-279 -371)"></path>
          </g>

          <!-- fine -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'fine'">
            <path class="fine-state" d="M211.19,397.91a10.07,10.07,0,0,1-15.44,0l1.68-1.41a7.88,7.88,0,0,0,12.07,0l1.68,1.41h0Z" transform="translate(-176.4 -371.01)" style=""></path>
            <path class="fine-state" d="M196.77,385.21a2.11,2.11,0,1,1-2.11,2.11,2.11,2.11,0,0,1,2.11-2.11h0Z" transform="translate(-176.4 -371.01)" style=""></path>
            <path class="fine-state" d="M210.16,385.21a2.11,2.11,0,1,1-2.11,2.11,2.11,2.11,0,0,1,2.11-2.11h0Z" transform="translate(-176.4 -371.01)" style=""></path>
          </g>
          
          <!-- worried -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'worried'">
            <path class="worried-state" d="M265.18,385.57a2.11,2.11,0,1,1-2.11,2.11,2.11,2.11,0,0,1,2.11-2.11h0Z" transform="translate(-244.8 -371.01)" style=""></path>
            <path class="worried-state" d="M278.56,385.57a2.11,2.11,0,1,1-2.11,2.11,2.11,2.11,0,0,1,2.11-2.11h0Z" transform="translate(-244.8 -371.01)" style=""></path>
            <path class="worried-state" d="M267,401.06A10.08,10.08,0,0,1,281.57,396l-1.13,1.88a7.88,7.88,0,0,0-11.4,4l-2.05-.77h0Z" transform="translate(-244.8 -371.01)" style=""></path>
          </g>

          <!-- terrified -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'terrified'">
            <path class="terrified-state" d="M333.58,387.08a2.11,2.11,0,1,1-2.11,2.11,2.11,2.11,0,0,1,2.11-2.11h0Z" transform="translate(-313.2 -371.01)" style=""></path>
            <path class="terrified-state" d="M347,387.08a2.11,2.11,0,1,1-2.11,2.11,2.11,2.11,0,0,1,2.11-2.11h0Z" transform="translate(-313.2 -371.01)" style=""></path>
            <polygon class="terrified-state" points="32.76 14.29 32.76 9.68 34.76 9.68 34.76 14.29 32.76 14.29 32.76 14.29" style="="></polygon>
            <polygon class="terrified-state" points="19.38 14.29 19.38 9.68 21.38 9.68 21.38 14.29 19.38 14.29 19.38 14.29" style=""></polygon>
            <path class="terrified-state" d="M340.27,392.92a7.88,7.88,0,0,1,5.52,2.73c2,2,3.23,4.84,3.23,6.34,0,1.28-.56,1.76-1.58,1.76a6.74,6.74,0,0,1-2.31-.71,9.87,9.87,0,0,0-9.72,0,6.74,6.74,0,0,1-2.31.71c-1,0-1.58-.48-1.58-1.76,0-1.5,1.26-4.29,3.23-6.34a7.89,7.89,0,0,1,5.52-2.73h0Zm4.09,4.11a5,5,0,0,0-8.17,0,10,10,0,0,0-2.64,4.61c0.29-.1.66-0.26,1.09-0.44a11.72,11.72,0,0,1,11.27,0c0.43,0.18.8,0.34,1.09,0.44a10,10,0,0,0-2.64-4.61h0Z" transform="translate(-313.2 -371.01)" style=""></path>
          </g>

          <!-- zombie -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'zombie'">
            <path xmlns="http://www.w3.org/2000/svg" d="M301.53,384.15a3.26,3.26,0,1,0,1,2.3,3.25,3.25,0,0,0-1-2.3h0Zm8.6,10.63h-0.6v1.79a0.86,0.86,0,0,1-1.72,0v-1.79h-7.26a1,1,0,0,0-1,1v2.76a1,1,0,0,0,1,1h9.59a1,1,0,0,0,1-1v-2.76a1,1,0,0,0-1-1h0Zm-9.84,6.57a0.84,0.84,0,0,1,0-.17,2.7,2.7,0,0,1-2.45-2.68v-2.76a2.69,2.69,0,0,1,2.69-2.69h9.59a2.69,2.69,0,0,1,2.69,2.69v2.76a2.7,2.7,0,0,1-2.69,2.69h-5.9v2.91a0.86,0.86,0,0,1-1.72,0V401.2H302a0.88,0.88,0,0,1,0,.16v1.45a0.86,0.86,0,0,1-1.72,0v-1.45h0Zm11.95-14.08a1.06,1.06,0,0,1-2,0h-1.34a2.47,2.47,0,0,0,4.64,0h-1.33Zm3.12-1.72a4.2,4.2,0,1,1-8.22,0h8.22Zm-16.13-.15a1.06,1.06,0,1,1-1.06,1.06,1.06,1.06,0,0,1,1.06-1.06h0Zm0-3.92a5,5,0,1,1-3.52,1.46,5,5,0,0,1,3.52-1.46h0Z" transform="translate(-278 -371)"/>
          </g>

          <!-- special food -->
          <!-- peyote -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'peyote'">
            <path d="M308.35,383.79a5,5,0,1,1-1.46,3.52,5,5,0,0,1,1.46-3.52h0ZM316,396.56a4.17,4.17,0,0,1-7.11,2.95h0a4.15,4.15,0,0,1-1.22-2.94h2.2a2,2,0,0,0,.57,1.39h0a2,2,0,0,0,3.36-1.39H316Zm-16.73-4.16a4.17,4.17,0,0,1-7.11,2.95h0A4.16,4.16,0,0,1,291,392.4h2.2a2,2,0,0,0,.57,1.39h0a2,2,0,0,0,3.36-1.39h2.2Zm0.34-11.24a12.7,12.7,0,0,1,0,20.81l-1.25-1.79a10.52,10.52,0,0,0,0-17.22l1.25-1.79h0Zm11.48,5.41a1.06,1.06,0,1,1,0,1.5,1.06,1.06,0,0,1,0-1.5h0Zm0.75-2.51a3.26,3.26,0,1,0,2.3,1,3.25,3.25,0,0,0-2.3-1h0Z" transform="translate(-278 -371)" style="fill:#212121"/>
          </g>

          <!-- durian -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'durian'">
            <path d="M295.63,386.87a0.88,0.88,0,0,1,.54-1.67l6.63,2.18a0.88,0.88,0,0,1,0,1.67h0l-6.63,2.18a0.88,0.88,0,1,1-.54-1.67l4.09-1.34-4.09-1.34h0Zm4.21,12.39A0.87,0.87,0,0,1,298.6,398l2.29-2.29,0.62-.62,0.62,0.62,1.67,1.67,1.67-1.67,0.62-.62,0.62,0.62,1.67,1.67,1.67-1.67,0.62-.62,0.62,0.62,2.29,2.29a0.87,0.87,0,1,1-1.24,1.24l-1.67-1.67L309,399.26l-0.62.62-0.62-.62-1.67-1.67-1.67,1.67-0.62.62-0.62-.62-1.67-1.67-1.67,1.67h0ZM316,385.21a0.88,0.88,0,0,1,.54,1.67l-4.09,1.34,4.09,1.34a0.88,0.88,0,1,1-.54,1.67L309.35,389h0a0.88,0.88,0,0,1,0-1.67l6.63-2.18h0Z" transform="translate(-279 -371)" style="fill:#212121"/>
          </g>

          <!-- pepper -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'pepper'">
            <path d="M306.55,391.05l1.85,2.46,4.05-.9a0.6,0.6,0,0,1,.66.85h0l-1.17,2.33,3.52,1.17a0.6,0.6,0,0,1,0,1.13l-3.52,1.17,1.17,2.33a0.6,0.6,0,0,1-.7.85l-4-.89L306.54,404a0.6,0.6,0,0,1-.84.12,0.58,0.58,0,0,1-.12-0.12l-1.85-2.46-4.05.9a0.6,0.6,0,0,1-.66-0.85h0l1.17-2.33-3.52-1.17a0.6,0.6,0,0,1,0-1.13l3.52-1.17L299,393.47a0.6,0.6,0,0,1,.7-0.85l4,0.89,1.85-2.47a0.6,0.6,0,0,1,.84-0.12,0.59,0.59,0,0,1,.12.12h0Zm-9.93-3.85a0.9,0.9,0,1,1,0-1.8h6.15a0.9,0.9,0,1,1,0,1.8h-6.15Zm12.75,0a0.9,0.9,0,1,1,0-1.8h6.15a0.9,0.9,0,1,1,0,1.8h-6.15Zm-1.7,7.34-1.6-2.14-1.6,2.13a0.6,0.6,0,0,1-.62.24l-3.2-.71,0.91,1.82h0l0,0.08a0.6,0.6,0,0,1-.38.75l-2.47.82,2.43,0.81,0.12,0a0.6,0.6,0,0,1,.26.8L300.66,401l3.2-.71a0.6,0.6,0,0,1,.61.23l1.6,2.14,1.6-2.13a0.6,0.6,0,0,1,.62-0.24l3.2,0.71-0.91-1.82h0l0-.08a0.6,0.6,0,0,1,.38-0.75l2.47-.82-2.43-.81-0.12,0a0.6,0.6,0,0,1-.26-0.8l0.91-1.82-3.2.71a0.6,0.6,0,0,1-.61-0.22h0Z" transform="translate(-279 -372)"/>
          </g>

          <!-- extra nimi addons -->
          <!-- sunglasses state -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'sunglasses'">
            <path xmlns="http://www.w3.org/2000/svg" d="M317.74,384.32h-0.47a2.57,2.57,0,0,0-1.5-1.7,4.78,4.78,0,0,0-2.16-.48H296.54a4.79,4.79,0,0,0-2.16.48,2.57,2.57,0,0,0-1.5,1.7h-0.49a0.44,0.44,0,1,0,0,.88h0.44v3.52a3.74,3.74,0,0,0,2.73,3.26,4.18,4.18,0,0,0,1.19.17,4.76,4.76,0,0,0,1.52-.25c2.21-.73,5.92-2.41,5.92-5.34a7.23,7.23,0,0,0,0-1.15,1.51,1.51,0,0,1,1.77,0,7,7,0,0,0,0,1.09c0,3,3.71,4.65,5.92,5.38a4.82,4.82,0,0,0,1.52.25,4.17,4.17,0,0,0,1.19-.17,3.75,3.75,0,0,0,2.73-3.28v-3.5h0.42a0.44,0.44,0,1,0,0-.87h0Zm-22.43,2.06a0.43,0.43,0,0,1-.62,0,0.44,0.44,0,0,1,0-.62l1.75-1.75a0.44,0.44,0,0,1,.62.62l-1.75,1.75h0Zm4.81-1.75-3.06,3.06a0.44,0.44,0,0,1-.62-0.62l3.06-3.06a0.44,0.44,0,0,1,.62.62h0Zm3.93-.15a3.68,3.68,0,0,0-.65-1.47h3.34a3.69,3.69,0,0,0-.65,1.48,2.45,2.45,0,0,0-2,0h0Zm4.07,2a0.43,0.43,0,0,1-.31-0.13,0.44,0.44,0,0,1,0-.62l1.75-1.75a0.44,0.44,0,1,1,.62.62l-1.75,1.75a0.43,0.43,0,0,1-.31.13h0Zm5.12-1.88-3.06,3.06a0.44,0.44,0,0,1-.62-0.62l3.06-3.06a0.44,0.44,0,0,1,.62.62h0Z" transform="translate(-278 -371)" />
            <path class="happy-state" d="M316.48,395.28a12.71,12.71,0,0,1-20.83,0l1.8-1.25a10.53,10.53,0,0,0,17.24,0l1.8,1.25h0Z" transform="translate(-279 -371)" style=""></path>
          </g>

          <!-- hibernation state -->
          <g v-else-if="this.$store.state.nimi.nimi_mood == 'hibernation'">
            <path xmlns="http://www.w3.org/2000/svg" transform="translate(-279 -371)" style="fill:#282828" d="M319.46,386.56l-0.46-.15c0-1-.44-2.76-2.83-4.13-2.23-1.28-5.63-1.94-10.1-1.94s-7.87.65-10.1,1.93c-2.47,1.42-2.83,3.26-2.83,4.22,0,0.15,0,.3,0,0.45H293a1,1,0,0,0,0,2h0.76a5.27,5.27,0,0,0,4.64,2.79,5.74,5.74,0,0,0,3.16-1.38,6.61,6.61,0,0,1,9,0,5.74,5.74,0,0,0,3.16,1.38h0a5.27,5.27,0,0,0,4.9-3.34l0.18,0.06a1,1,0,1,0,.64-1.93h0Z" />
            <path class="happy-state" d="M316.48,395.28a12.71,12.71,0,0,1-20.83,0l1.8-1.25a10.53,10.53,0,0,0,17.24,0l1.8,1.25h0Z" transform="translate(-279 -371)" style=""></path>
          </g>

        </svg>
      </div>

      <!-- ground -->
      <svg id="svg-nimipet-ground" data-name="Layer 1" v-if="this.$store.state.nimi.nimi_mood != 'unborn'" style="position:absolute;bottom:0;left:0;" viewBox="0 0 54.13 50.57" width="200" heigh="200" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <polygon class="" points="0 50.07 54.13 50.07 54.13 50.57 0 50.57 0 50.07 0 50.07"></polygon>
      </svg>

			<!-- container for draggable -->
      <div v-if="this.$store.state.nimi.nimi_mood != 'unborn' && this.$store.state.nimi.nimi_mood != 'dead'" id="nimi-container" style="width:200px;height:200px;position:absolute;top:0;" class="" ></div>
  
		</div>


    <div style="margin:0 auto;text-align:center;width:200px;margin-top:15px;margin-bottom:5px;padding-bottom:5px;">

      <div style="margin-top:15px;">
        <div class="edit-nimi-pet" v-show="this.$store.state.styleChange">
          <div class="slidersXY">
            <div class="slidecontainer">
            <input type="range" min="1" max="360" value="0" class="slider" id="x1" @input="x1Slider">
            </div>
            <div class="slidecontainer" style="margin-top:5px;display:none;">
            <input type="range" min="1" max="100" value="0" class="slider" id="y1">
            </div>
          </div>
          <div class="svg-color-pickers">
            <jscolor id="colorThemeTextColor" v-model="color1"></jscolor>
            <jscolor id="colorThemeTextColor" v-model="color2"></jscolor>
            <jscolor id="colorThemeTextColor" v-model="color3"></jscolor>
          </div>
          <button type="submit" class="save-nim-style" @click="updateNimStyle">SAVE</button>
          <br>
          <br>
          <span class="a" @click="generateAvatar">Generate avatar</span>
        </div>
      </div>

      <fieldset v-if="!this.$store.state.styleChange && this.$store.state.nimi.nimi_mood != 'unborn' && mod != 'pub'">
        <input id="first" type="text" name="first" v-model.lazy="nimiName" required="" class="">
        <label id="label" for="first" class="">Nimipet's name</label>
        <div class="after"></div>
      </fieldset>

      <div class="pub-name" v-show="mod == 'pub'">
        {{ nimiName }}
      </div>

    </div>

  </div>
</template>

<script>
  import jscolor from './JsColor.vue';
  import speechBubble from './SpeechBubble.vue'

  export default {
    components: {
      jscolor,
      speechBubble
    },
    data: function() {
      return {
        color1: this.$store.state.nimi.nimi_style.color1,
        color2: this.$store.state.nimi.nimi_style.color2,
        color3: this.$store.state.nimi.nimi_style.color3,
        x1: this.$store.state.nimi.nimi_style.x1,
        y1: this.$store.state.nimi.nimi_style.y1,
        x2: this.$store.state.nimi.nimi_style.x2,
        y2: this.$store.state.nimi.nimi_style.y2,
        soundBorn: new Audio('https://nimipet.com/fx/born.mp3'),
      }
    },
    mounted() {
      this.soundBorn.load();
    },
    created () {
      this.$store.watch(
        (state)=>{
          return this.$store.state.nimi.nimi_style;
        },
        (newValue, oldValue)=>{
          this.color1 = newValue.color1;
          this.color2 = newValue.color2;
          this.color3 = newValue.color3;
          this.x1 = newValue.x1;
          this.x2 = newValue.x2;
          this.y1 = newValue.y1;
          this.y2 = newValue.y2;
        },
      ),
      this.$store.watch(
        (state)=>{
          return this.$store.state.nimi.nimi_lastfed;
          // CHANGE TO .current_time
        },
        (newValue, oldValue)=>{
          let property = 'nimi_mood';
          let timePassed = Date.parse(this.$store.state.nimi.current_time) - Date.parse(this.$store.state.nimi.nimi_lastfed);

          if (this.$store.state.nimi.nimi_mood == '') {
            if (isNaN(timePassed) && this.$store.state.nimi.nimi_mood != 'dead') {
              let value = 'happy';
              this.$store.commit('nimi', {property, value});
            }
            else if (timePassed < 21600000) {
              let value = 'happy';
              this.$store.commit('nimi', {property, value});
            }
            else if (timePassed < 43200000) {
              let value = 'fine';
              this.$store.commit('nimi', {property, value});
            }
            else if (timePassed < 64800000) {
              let value = 'worried';
              this.$store.commit('nimi', {property, value});
            }
            else if (timePassed < 86400000) {
              let value = 'terrified';
              this.$store.commit('nimi', {property, value});
            }
          }
        },
      )
    },
    computed: {
      nimiName: {
        get () {
          return this.$store.state.nimi.nimi_name;
        },
        set (value) {
          this.axios.post('/nimi-name', { name: value } )
          .then(result => {
            if (result.data == 'success') {
              let property = 'nimi_name';
              this.$store.commit('nimi', {property, value})
              this.$store.commit('speech', 'name-change-success');
            }
            else if (result.data == 'name-taken') {
              this.$store.commit('speech', 'name-change-error');
            }
          })
          .catch(error => { console.log(error); });
        }
      },
    },
    methods: {
      logout: function () {
        this.$auth.logout();
      },
      generateAvatar: function () {
        this.saveSvgAsPng.saveSvgAsPng(
          document.getElementById("svg-nimipet"), "nimipet.png", 
          {scale: 1, backgroundColor: 'white', scale: 10, width: 63, height: 63, left:-4.45, top: -6.6}
        );
      },
      nimipetBirth: function () {
        this.$el.querySelector('#nimipet-image').src = `/img/nimipet-birth.gif`;
        this.soundBorn.cloneNode(true).play();

        this.axios.post('/nimi-birth')
        .then((result)=> {
          setTimeout(()=> {
            if (typeof(result.data[0].nimi_style) != 'undefined') {
              result.data[0].nimi_style = JSON.parse(result.data[0].nimi_style.replace(/\\/g, ''));
            }
            for (const key of Object.keys(result.data[0])) {
            let property = key;
            let value = result.data[0][key];
            this.$store.commit('nimi', {property, value});
            }
            let property = 'nimi_mood';
            let value = 'happy';
            this.$store.commit('nimi', {property, value});
            this.$store.commit('loaded', true);
          }, 1000)
        })
        .catch(function(error) {
          console.log(error);
        });
      },

      x1Slider: function(e) {
        function angleToPoints(angle) {
          var segment = Math.floor(angle / Math.PI * 2) + 2;
          var diagonal = (1 / 2 * segment + 1 / 4) * Math.PI;
          var op = Math.cos(Math.abs(diagonal - angle)) * Math.sqrt(2);
          var x = op * Math.cos(angle);
          var y = op * Math.sin(angle);
          return {
            x1: x < 0 ? 1 : 0,
            y1: y < 0 ? 1 : 0,
            x2: x >= 0 ? x : x + 1,
            y2: y >= 0 ? y : y + 1
          };
        }
        function toRadians(degrees) {
          return degrees / 180 * Math.PI;
        }
        const requestAnimationFrame = (i) => {
          var angle = toRadians(i - 180);
          var pair = angleToPoints(angle);
          this.x1 = pair.x1
          this.y1 = pair.y1
          this.x2 = pair.x2
          this.y2 = pair.y2
        }
        requestAnimationFrame(e.target.value);
      },

      updateNimStyle: function() {
        this.$store.commit('color1', this.color1);
        this.$store.commit('color2', this.color2);
        this.$store.commit('color3', this.color3);
        this.$store.commit('x1', this.x1);
        this.$store.commit('x2', this.x2);
        this.$store.commit('y1', this.y1);
        this.$store.commit('y2', this.y2);

        this.axios.post('/nimi-style', { style: this.$store.state.nimi.nimi_style } )
        .then(result => {
          if (result.data == 'success') {
            this.$store.commit('speech', 'avatar');
          }
        })
        .catch(error => { console.log(error); });
      }
    },
    props: [ 'mod' ]
  }
</script>

<style>

  .pub-name {
    font-size: 22px;
    margin-top: -4px;
  }

  .nimipet-svg {
    width: 200px;
    height: 200px;
    vertical-align: bottom;
    margin: 0 auto;
    margin-bottom: 5px;
    position: relative;
  }

  .svg-color-pickers {
    display: flex;
    width: 200px;
    justify-content: space-between;
  }

  .jscolor-input {
    width: 59px;
    height: 25px;
    margin-top: 15px;
    color: rgb(0, 0, 0);
    text-transform: uppercase;
    font-size: 12px;
    text-align: center;
  }

  .save-nim-style {
    margin-top: 1em;
    color: #444444;
    padding: 3px 45px 1px 45px;
  }

</style>