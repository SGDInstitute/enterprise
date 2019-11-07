<template>
  <card class="p-4 h-full">
    <div class="mb-4 border-b border-50 pb-2">
      <h1 class="text-center mb-2 text-sm font-semibold uppercase tracking-wide">Upload Activitites</h1>
      <p class="leading-normal text-center">
        <a
          target="_blank"
          class="text-primary no-underline hover:bg-40 py-1 px-2 rounded"
          href="#"
        >Download Sample File</a>
      </p>
    </div>
    <input type="file" id="file" ref="file" v-on:change="handleFileUpload" />
    <button @click="uploadFile" class="mt-4 btn btn-default btn-primary">
      <span>
        <svg
          v-if="busy"
          xmlns="http://www.w3.org/2000/svg"
          width="15"
          height="15"
          viewBox="0 0 512 512"
          class="spin"
          fill="#ffffff"
        >
          <path
            d="M456.433 371.72l-27.79-16.045c-7.192-4.152-10.052-13.136-6.487-20.636 25.82-54.328 23.566-118.602-6.768-171.03-30.265-52.529-84.802-86.621-144.76-91.424C262.35 71.922 256 64.953 256 56.649V24.56c0-9.31 7.916-16.609 17.204-15.96 81.795 5.717 156.412 51.902 197.611 123.408 41.301 71.385 43.99 159.096 8.042 232.792-4.082 8.369-14.361 11.575-22.424 6.92z"
          />
        </svg>
      </span>
      Upload & Import File
    </button>
    <p class="leading-normal mt-2" v-show="message">{{ message }}</p>
  </card>
</template>

<script>
export default {
  data() {
    return {
      busy: false,
      file: "",
      message: ""
    };
  },

  methods: {
    handleFileUpload() {
      this.file = this.$refs.file.files[0];
    },
    uploadFile(event) {
      this.busy = true;

      let formData = new FormData();
      formData.append("file", this.file);
      let self = this;

      axios
        .post("/nova-vendor/activitity-upload/upload", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(function() {
          self.busy = false;
          self.message =
            "File was successfully uploaded and will begin importing.";
          document.getElementById("file").value = null;
        })
        .catch(function() {
          self.busy = false;
          self.message = "Whoops! There was an issue uploading the file.";
          document.getElementById("file").value = null;
        });
    }
  }
};
</script>

<style>
.spin {
  animation: fa-spin 2s infinite linear;
}

@keyframes fa-spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(1turn);
  }
}
</style>
