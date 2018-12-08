<template>
  <input :value="value"
  :id="id"
  class="jscolor-input {hash:true,styleElement:'',onFineChange:'jsColorOnFineChange(this)'}"
  @change="onChange($event.target)"
  @input="onChange($event.target)"
  @focus="showColorPicker"
  @onFineChange="onFineChange"
  ref="color_input"
  maxlength="7"
  />
</template>

<script>
  import jscolor from '../../public/lib/jscolor.min.js';

  export default {
    name: 'jscolor',
    data(){
      return {
        color: ''
      }
    },
    props: [
      'value',
      'id'
    ],
    methods: {
      onChange(target){
        this.color = target.jscolor.toHEXString();
        this.$refs.color_input.style.backgroundColor = this.value;
        this.$emit('input', this.color);
      },
      onFineChange(e){
        this.color = '#' + e.detail.jscolor;
        this.$refs.color_input.style.backgroundColor = this.value;
        this.$emit('input', this.color);
      },
      showColorPicker(){
        this.$refs.color_input.jscolor.show();
      }
    },
    mounted: function () {
      window.jscolor.installByClassName('jscolor-input');
      this.$refs.color_input.style.backgroundColor = this.value;
    },
    updated: function () {
      this.$refs.color_input.style.backgroundColor = this.value;
    }
  }
  window.jsColorOnFineChange = function(thisObj){
    thisObj.valueElement.dispatchEvent(new CustomEvent("onFineChange", {detail: {jscolor: thisObj}}));
  }
</script>