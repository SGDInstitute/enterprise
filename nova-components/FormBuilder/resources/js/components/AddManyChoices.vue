<template>
  <div>
    <button
      @click.prevent="show = true"
      type="button"
      class="mt-4 btn btn-default btn-primary"
    >Add Choices</button>

    <div class="modal-mask" v-show="show">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-header">
            <h3 class="text-primary">Add Many Choices</h3>
          </div>

          <div class="modal-body">
            <div class="flex -mx-4">
              <div class="w-1/2 mx-4">
                <p class="text-80 pb-2 leading-tight">Enter choices here</p>
                <textarea
                  v-model="choicesText"
                  class="w-full form-input form-input-bordered p-2"
                  rows="10"
                ></textarea>
              </div>
              <div class="w-1/2 mx-4">
                <p class="text-80 pb-2 leading-tight">Results</p>
                <div class="border border-50 bg-20 rounded p-4">{{ choices }}</div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button @click.prevent="save" class="btn btn-default btn-primary">Save</button>
            <button @click.prevent="show = false" class="btn btn-default btn-secondary">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      choicesText: "",
      choices: []
    };
  },
  methods: {
    save() {
      this.$emit("add-choices", this.choices);
      this.show = false;
    }
  },
  watch: {
    choicesText() {
      this.choices = this.choicesText.split("\n");
    }
  }
};
</script>

<style scoped>
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
  width: 50%;
  margin: 0px auto;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header {
  padding: 20px 30px;
  background: #eef1f4;
}

.modal-body {
  padding: 20px 30px;
}

.modal-footer {
  padding: 20px 30px;
}
</style>