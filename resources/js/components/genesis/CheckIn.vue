<template>
  <div>
    <router-link
      to="/"
      class="flex items-center block p-2 text-gray-200 no-underline hover:text-white mb-4"
    >
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
        <path
          class="fill-current inline"
          d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"
        />
      </svg>
      <span class="text-lg pl-2">Back</span>
    </router-link>
    <div class="md:flex -mx-4">
      <div class="md:w-1/2 px-4">
        <div class="shadow rounded h-full bg-white p-8 mx-auto mb-4 md:mb-0">
          <h1
            class="text-2xl font-normal mb-8 text-blue-darker"
          >Type Your Confirmation Number or Order Number</h1>
          <div class="flex flex-wrap items-stretch w-full mb-4 relative">
            <input
              type="text"
              class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-r-none px-3 relative"
              v-model="number"
            />
            <div class="flex -mr-px">
              <router-link
                :to="'/orders/' + number"
                class="rounded rounded-l-none no-underline bg-blue-500 px-4 flex items-center h-10 text-white font-semibold hover:bg-blue-dark"
              >Continue</router-link>
            </div>
          </div>
        </div>
      </div>
      <div class="md:w-1/2 px-4">
        <div class="shadow rounded h-full bg-white p-8 mx-auto">
          <h1 class="text-2xl font-normal mb-8 text-blue-darker">Type Your Ticket Number</h1>
          <div class="flex flex-wrap items-stretch w-full mb-4 relative">
            <input
              type="text"
              class="flex-shrink flex-grow flex-auto leading-normal w-px flex-1 border h-10 border-grey-light rounded rounded-r-none px-3 relative"
              v-model="hash"
            />
            <div class="flex -mr-px">
              <router-link
                :to="'/tickets/' + hash"
                class="rounded rounded-l-none no-underline bg-blue-500 px-4 flex items-center h-10 text-white font-semibold hover:bg-blue-dark"
              >Continue</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const Instascan = require("instascan");

export default {
  name: "scan",
  data() {
    return {
      number: "",
      hash: "",
      error: "",
      scanner: {}
    };
  },
  methods: {
    start() {
      this.scanner = new Instascan.Scanner({
        video: document.getElementById("preview")
      });

      let self = this;
      this.scanner.addListener("scan", function(content) {
        self.number = content;
      });
      Instascan.Camera.getCameras()
        .then(function(cameras) {
          if (cameras.length > 0) {
            self.scanner.start(cameras[0]);
          } else {
            self.error = "No cameras found.";
          }
        })
        .catch(function(e) {
          self.error = e;
        });
    },
    stop() {
      this.scanner.stop();
    }
  }
};
</script>
