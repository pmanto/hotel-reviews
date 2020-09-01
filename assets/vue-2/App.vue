<template>
  <div id="app">
    <router-view></router-view>
    <footer>
      Powered by
      <a
        href="https://www.linkedin.com/in/mantonellapalacios/"
        target="_blank"
      >Antonella Palacios</a>
    </footer>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
@Component
export default class App extends Vue {}
</script>