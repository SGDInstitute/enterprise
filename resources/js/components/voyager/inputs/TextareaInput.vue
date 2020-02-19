<template>
  <div class="pb-6">
    <textarea
      :name="question.id"
      :id="question.id"
      class="form-control"
      v-model="text"
      rows="7"
      :disabled="disabled"
    ></textarea>
  </div>
</template>

<script>
export default {
  props: ["value", "question", "disabled"],
  data() {
    return {
      text: ""
    };
  },
  created() {
    this.text = this.value;
  },
  watch: {
    text(value) {
      this.$emit("input", value);
    }
  }
};
</script>
