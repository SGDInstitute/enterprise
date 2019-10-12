<template>
  <div class="mb-4">
    <label class="form-label">
      {{ question.question }}
      <span v-show="question.required">*</span>
    </label>
    <p v-show="question.description" v-html="question.description" class="mb-2"></p>

    <div class="relative">
      <select
        :id="question.id + '_question'"
        class="form-control"
        multiple="multiple"
        v-if="question.multiple"
        :disabled="disabled"
      >
        <option
          v-for="(choice, index) in question.choices"
          :key="index"
          :value="choice"
        >{{ choice }}</option>
      </select>
      <select class="form-control" v-model="selected" :disabled="disabled" v-else>
        <option
          v-for="(choice, index) in question.choices"
          :key="index"
          :value="choice"
        >{{ choice }}</option>
      </select>
      <div
        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
      >
        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
        </svg>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["question", "disabled"],
  data() {
    return {
      selected: []
    };
  },
  mounted() {
    if (this.question.multiple) {
      let self = this,
        $multiple = $("#" + this.question.id + "_question");

      $multiple.selectWoo({
        tags: true
      });

      $multiple.on("change.selectWoo", function(e) {
        self.selected = _.map($multiple.selectWoo("data"), "text");
      });
    }
  },
  watch: {
    selected(value) {
      this.$emit("input", value);
    }
  }
};
</script>
