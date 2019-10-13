<template>
  <div class="pb-6">
    <div :class="type" v-for="choice in choices" :key="choice">
      <label v-if="type === 'radio'">
        <input
          type="radio"
          :class="question.id"
          :value="choice"
          v-model="selected"
          :disabled="disabled"
        />
        {{ choice }}
      </label>
      <label v-if="type === 'checkbox'">
        <input
          type="checkbox"
          :class="question.id"
          :value="choice"
          v-model="chosen"
          :disabled="disabled"
        />
        {{ choice }}
      </label>
    </div>

    <input
      v-show="showOtherInput"
      type="text"
      class="form-control mt-2"
      v-model="input"
      :id="question.id"
      :disabled="disabled"
    />
  </div>
</template>

<script>
export default {
  props: ["value", "question", "disabled"],
  data() {
    return {
      selected: "",
      chosen: [],
      input: ""
    };
  },
  created() {
    if (typeof this.value === "string") {
      this.selected = this.value;
    } else {
      this.chosen = this.value;
    }
  },
  computed: {
    type() {
      return this.question.multiple ? "checkbox" : "radio";
    },
    showOtherInput() {
      return (
        this.question.other === true &&
        (this.selected === this.otherWording ||
          _.indexOf(this.chosen, this.otherWording) !== -1)
      );
    },
    choices() {
      if (this.question.other) {
        this.question.choices.push(this.otherWording);
        return this.question.choices;
      }

      return this.question.choices;
    },
    otherWording() {
      if (
        typeof this.question.other_wording === "undefined" ||
        this.question.other_wording === null
      ) {
        return "Other";
      }

      return this.question.other_wording;
    }
  },
  watch: {
    selected(value) {
      this.$emit("input", this.selected);
    },
    chosen(value) {
      this.$emit("input", this.chosen);
    }
  }
};
</script>
