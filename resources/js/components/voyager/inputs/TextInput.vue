<template>
  <div class="form-group">
    <input
      v-if="type === 'text'"
      type="text"
      class="form-control"
      v-model="input"
      :id="question.id"
      :disabled="disabled"
    />
    <input
      v-if="type === 'phone'"
      type="tel"
      class="form-control"
      v-model="input"
      :id="question.id"
      :disabled="disabled"
    />
    <input
      v-if="type === 'website'"
      type="url"
      class="form-control"
      v-model="input"
      :id="question.id"
      :disabled="disabled"
    />
    <input
      v-if="type === 'email'"
      type="email"
      class="form-control"
      v-model="input"
      :id="question.id"
      :disabled="disabled"
    />
  </div>
</template>

<script>
export default {
  props: ["question", "disabled"],
  data() {
    return {
      input: ""
    };
  },
  watch: {
    input(value) {
      this.$emit("input", value);
    }
  },
  computed: {
    type() {
      return this.question.attribute !== undefined
        ? this.question.attribute
        : "text";
    }
  }
};
</script>
