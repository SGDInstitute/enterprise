<template>
  <div>
    <div v-if="detail">
      <div v-for="(question, key) in questions" :key="key" class="border border-50 overflow-hidden">
        <div class="block bg-30 p-4 cursor-pointer border-b border-50 -mt-px flex justify-between">
          <div>
            <a @click.prevent="open(key)">
              <span v-if="question.question">{{ question.question }}</span>
              <span v-else>Question {{ key + 1 }}</span>
            </a>
            <span
              v-if="question.type"
              class="ml-2 text-sm text-80"
            >{ id: {{ question.id }}, type: {{ question.type }}, rules: {{ question.rules }} }</span>
          </div>
          <div>
            <a @click.prevent="duplicate(key)">
              <i class="fas fa-copy"></i>
            </a>
            <a @click.prevent="remove(key)">
              <i class="fas fa-delete"></i>
            </a>
          </div>
        </div>
        <div class="p-4" :class="[isOpen(key) ? '' : 'hidden']">
          <question-detail :question="question"></question-detail>
        </div>
      </div>
    </div>
    <div v-else>
      <draggable
        v-model="questions"
        :options="{disabled: hasOpenedQuestion}"
        @start="drag=true"
        @end="drag=false"
      >
        <div
          v-for="(question, key) in questions"
          :key="key"
          class="question border border-50 overflow-hidden"
        >
          <div class="block bg-30 p-4 border-b border-50 -mt-px flex justify-between">
            <div>
              <svg
                class="handle fill-current mr-4 h-3 w-3 cursor-pointer"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
              </svg>
              <a
                v-if="question.question"
                @click.prevent="open(key)"
                class="cursor-pointer"
              >{{ question.question }}</a>
              <a @click.prevent="open(key)" class="cursor-pointer" v-else>Question {{ key + 1 }}</a>
              <span
                v-if="question.type"
                class="ml-2 text-sm text-80"
              >{id: {{ question.id }}, type: {{ question.type }}, rules: {{ question.rules }}}</span>
            </div>
            <div>
              <a @click.prevent="duplicate(key)" class="p-1 rounded hover:bg-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4">
                  <path
                    d="M352 96V0H152a24 24 0 00-24 24v368a24 24 0 0024 24h272a24 24 0 0024-24V96z"
                    opacity=".4"
                  />
                  <path
                    d="M96 392V96H24a24 24 0 00-24 24v368a24 24 0 0024 24h272a24 24 0 0024-24v-40H152a56.06 56.06 0 01-56-56zM441 73L375 7a24 24 0 00-17-7h-6v96h96v-6.06A24 24 0 00441 73z"
                    class="fa-primary"
                  />
                </svg>
              </a>
              <a @click.prevent="remove(key)" class="p-1 rounded hover:bg-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-4">
                  <path
                    d="M32 464a48 48 0 0048 48h288a48 48 0 0048-48V96H32zm272-288a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0zm-96 0a16 16 0 0132 0v224a16 16 0 01-32 0z"
                    opacity=".4"
                  />
                  <path
                    d="M432 32H312l-9.4-18.7A24 24 0 00281.1 0H166.8a23.72 23.72 0 00-21.4 13.3L136 32H16A16 16 0 000 48v32a16 16 0 0016 16h416a16 16 0 0016-16V48a16 16 0 00-16-16zM128 160a16 16 0 00-16 16v224a16 16 0 0032 0V176a16 16 0 00-16-16zm96 0a16 16 0 00-16 16v224a16 16 0 0032 0V176a16 16 0 00-16-16zm96 0a16 16 0 00-16 16v224a16 16 0 0032 0V176a16 16 0 00-16-16z"
                    class="fa-primary"
                  />
                </svg>
              </a>
            </div>
          </div>
          <div class="p-4" :class="[isOpen(key) ? '' : 'hidden']">
            <question-form v-model="questions[key]"></question-form>
          </div>
        </div>
      </draggable>
      <button @click.prevent="addQuestion" class="mt-4 btn btn-default btn-primary">Add Question</button>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";

export default {
  props: ["value", "detail", "form"],

  data() {
    return {
      opened: 0,
      questions: this.value
    };
  },

  created() {
    if (_.isEmpty(this.value)) {
      this.questions = [];
    }
  },

  methods: {
    addQuestion() {
      this.questions.push({});
    },
    duplicate(key) {
      this.questions.splice(key, 0, this.questions[key]);
    },
    isOpen(key) {
      return this.opened === key;
    },
    open(key) {
      if (this.opened === key) {
        this.opened = false;
      } else {
        this.opened = key;
      }
    },
    remove(key) {
      this.questions.splice(key, 1);
    }
  },

  computed: {
    hasOpenedQuestion() {
      return this.opened !== false;
    }
  },

  watch: {
    questions() {
      this.$emit("input", this.questions);
    }
  },

  components: {
    draggable
  }
};
</script>
