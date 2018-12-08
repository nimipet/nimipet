<template>
    <div style="position:relative;">
        <div style="font-size:24px;text-align:center;margin-bottom: 60px;">
          <b>Get more NIM</b>
        </div>
        Your nimipet's public link: <b><router-link target="_blank" v-bind:to="$store.state.nimi.nimi_slug"><span id="pub-url" v-html="pubLink" style="font-size: 16px;" @click="selectText('pub-url')">Loading...</span></router-link></b>
        <br><br><br>
        Share this link with other people so that they can help you to more NIM. You also can mine with multiple devices.
        <br><br>
        On this public nimipet page, only the mining feature works. NIM and food can be mined for your nimipet by anyone who opens the page. 
        Other features like feeding or changing the name are disabled.
    </div>
</template>
<script>

export default {
    data: function() {
      return {
        pubLink: 'https://nimipet.com/'+this.$store.state.nimi.nimi_slug,
      }
    },
    methods: {
      selectText: function (containerid) {
        if (document.selection) {
          var range = document.body.createTextRange();
          range.moveToElementText(document.getElementById(containerid));
          range.select();
        } else if (window.getSelection) {
          var range = document.createRange();
          range.selectNode(document.getElementById(containerid));
          window.getSelection().removeAllRanges();
          window.getSelection().addRange(range);
        }
      }
    }
}
</script>