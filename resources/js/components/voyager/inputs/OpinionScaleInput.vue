<template>
  <div class="form-group">
    <div class="btn-group opinion-scale mb-2">
      <label
        class="btn btn-secondary opinion"
        :class="{active: selected === index}"
        v-for="(index, id) in question.max_value"
        :key="index"
      >
        <input type="radio" class="hidden" v-model="selected" :value="index" :disabled="disabled" />
        {{ index }}
      </label>
    </div>
    <div class="clearfix">
      <p class="pull-right">{{ question.negative_label }}</p>
      <p class="pull-left">{{ question.positive_label }}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["question", "disabled"],
  data() {
    return {
      selected: ""
    };
  },
  watch: {
    selected(value) {
      this.$emit("input", value);
    }
  }
};
</script>

<style>
.opinion-scale {
  display: flex;
}

.opinion {
  flex: 1 !important;
}

/* .opinion input[type=radio] {
        display: none;
    } */
</style>
