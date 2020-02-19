<template>
  <div class="pb-6">
    <div class="flex border border-gray-300 rounded mb-2">
      <label
        class="flex-1 text-center block text-mint-800 border-gray-300 px-3 py-2 hover:bg-gray-100"
        :class="{'bg-gray-200': selected === index, 'border-r': index < question.max_value}"
        v-for="index in range"
        :key="index"
        @click="select(index)"
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
  methods: {
    select(value) {
      this.selected = value;
      this.$emit("input", value);
    }
  },
  computed: {
    range() {
      const max = parseInt(this.question.max_value);
      return [...Array(max).keys()].map(i => i + 1);
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
