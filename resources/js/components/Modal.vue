<template>
  <div class="modal-mask" v-show="show">
    <div class="modal-wrapper">
      <div class="bg-white rounded max-h-screen overflow-scroll mx-auto shadow" :class="[width]">
        <div class="modal-header">
          <slot name="header">
            <button @click="$emit('close')">
              <i class="far fa-times"></i>
            </button>
          </slot>
        </div>

        <slot name="body"></slot>

        <div class="modal-footer">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    show: { required: true },
    preventBackgroundScrolling: { default: true },
    width: { default: "w-5/6 md:w-1/3" }
  },
  created() {
    this.escapeHandler = e => {
      if (e.key === "Escape" && this.show) {
        this.dismiss();
      }
    };

    document.addEventListener("keydown", this.escapeHandler);
  },
  destroyed() {
    document.removeEventListener("keydown", this.escapeHandler);
    this.preventBackgroundScrolling &&
      document.body.style.removeProperty("overflow");
  },
  methods: {
    dismiss() {
      this.$emit("close");
    }
  },
  watch: {
    show: {
      immediate: true,
      handler: function(show) {
        if (show) {
          this.preventBackgroundScrolling &&
            document.body.style.setProperty("overflow", "hidden");
        } else {
          this.preventBackgroundScrolling &&
            document.body.style.removeProperty("overflow");
        }
      }
    }
  }
};
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  transition: all 0.3s ease;
}
</style>