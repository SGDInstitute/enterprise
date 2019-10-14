<template>
  <div>
    <button class="btn btn-gray btn-sm mb-4" @click.prevent="add">Add {{ question.name }}</button>

    <div class="accordion" id="accordion">
      <div
        class="bg-gray-100 border rounded px-4 pt-2 pb-4"
        v-for="(repeat, index) in repeated"
        :key="repeat+index"
      >
        <div class="flex justify-between" :id="'heading' + index">
          <button
            class="btn btn-link"
            type="button"
            data-toggle="collapse"
            :data-target="'#collapse' + index"
            aria-expanded="true"
            :aria-controls="'collapse' + index"
          >{{ question.name }} #{{ index + 1 }}</button>
          <a
            role="button"
            class="btn btn-link"
            @click.prevent="remove(index)"
          >Remove {{ question.name }}</a>
        </div>

        <div
          :id="'collapse' + index"
          class="collapse show"
          :aria-labelledby="'heading' + index"
          data-parent="#accordion"
        >
          <div class="card-body">
            <div class="mb-2" v-for="q in question.form" :key="q.id" :id="q.id">
              <label class="form-label">
                {{ q.question }}
                <span v-show="q.required">*</span>
              </label>
              <p v-show="q.description" v-html="q.description"></p>

              <component :is="q.type + '-input'" :question="q" v-model="repeated[index][q.id]"></component>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ListInput from "../inputs/ListInput.vue";
import SectionInput from "../inputs/SectionInput.vue";
import RepeatInput from "../inputs/RepeatInput.vue";
import OpinionScaleInput from "../inputs/OpinionScaleInput.vue";
import TextareaInput from "../inputs/TextareaInput.vue";
import TextInput from "../inputs/TextInput.vue";
import SelectInput from "../inputs/SelectInput.vue";

export default {
  props: ["question", "value"],
  data() {
    return {
      repeated: [],
      init: {}
    };
  },
  created() {
    for (let i = 0, len = this.question.form.length; i < len; i++) {
      let id = this.question.form[i].id;
      this.init[id] = "";
    }

    if (this.value !== "" || this.value !== null) {
      this.repeated = this.value;
    }

    if (this.question.rules === "required") this.add();
  },
  methods: {
    add() {
      this.repeated.push(Object.assign({}, this.init));
    },
    remove(index) {
      this.repeated.splice(this.repeated.indexOf(index), 1);
    }
  },
  watch: {
    repeated(value) {
      this.$emit("input", value);
    }
  },
  components: {
    ListInput,
    SectionInput,
    RepeatInput,
    OpinionScaleInput,
    TextareaInput,
    TextInput,
    SelectInput
  }
};
</script>
