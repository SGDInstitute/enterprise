<template>
  <form method="post" @submit.prevent="save">
    <div v-for="(question, index) in dbform.form" :key="question.id" :id="question.id">
      <div v-if="question.id != 'submit'">
        <div class="mb-4" :class="{'has-error': form.errors.has(question.id)}">
          <div v-if="question.type !== 'select'">
            <label :for="question.id" class="form-label">
              {{ question.question }}
              <span v-show="question.required">*</span>
            </label>
            <p v-show="question.description" v-html="question.description" class="mb-2"></p>
          </div>

          <component
            :is="question.type + '-input'"
            :question="question"
            v-model="form[question.id]"
            :disabled="disabled"
          ></component>

          <span
            class="mt-2 block py-2 text-red-600"
            v-show="form.errors.has(question.id)"
          >{{ form.errors.get(question.id) }}</span>
          <a
            :href="nextId(index)"
            class="btn btn-primary smooth"
            v-if="nextIsSection(index) || question.type === 'section'"
          >Next!</a>
        </div>
      </div>
    </div>
    <div :id="finishId">
      <h2 class="text-xl mb-2 font-semibold">All Done!</h2>
      <p class="text-lg mb-4">Don't forget to save your hard work by clicking the button below.</p>
      <div
        class="bg-red-200 border-l-4 border-red-500 p-4 shadow mb-4 rounded overflow-hidden"
        v-show="form.errors.hasErrors()"
      >
        Whoops! Looks like you missed some required fields! Please, scroll up and respond to them.
        <ul>
          <li v-for="(error, key) in form.errors.all()" :key="error">
            <a :href="'#' + key">{{ error[0] }}</a>
          </li>
        </ul>
      </div>
      <button type="submit" class="btn btn-mint btn-lg" :disabled="dbform.busy">{{ buttonText }}</button>
    </div>
  </form>
</template>

<script>
import Welcome from "./Welcome.vue";
import ListInput from "./inputs/ListInput.vue";
import SectionInput from "./inputs/SectionInput.vue";
import RepeatInput from "./inputs/RepeatInput.vue";
import OpinionScaleInput from "./inputs/OpinionScaleInput.vue";
import TextareaInput from "./inputs/TextareaInput.vue";
import TextInput from "./inputs/TextInput.vue";
import SelectInput from "./inputs/SelectInput.vue";
import Finish from "./Finish.vue";

export default {
  props: ["dbform", "disabled", "response"],
  data() {
    return {
      form: new SparkForm({})
    };
  },
  beforeMount() {
    for (var i = 0, len = this.dbform.form.length; i < len; i++) {
      var id = this.dbform.form[i].id;
      this.form[id] = "";
    }

    if (typeof this.response !== "undefined") {
      self = this;
      _.each(this.response.responses, function(response, id) {
        self.form[id] = response;
      });
    }

    this.form["email"] = this.getParameterByName("email");
  },
  methods: {
    save() {
      if (typeof this.response === "undefined") {
        Spark.post("/forms/" + this.dbform.id + "/responses", this.form).then(
          response => {
            if (response.success === true) {
              location.href = response.url;
            }
          }
        );
      } else {
        Spark.patch("/responses/" + this.response.id, this.form).then(
          response => {
            if (response.success === true) {
              this.$toasted.success(
                "Successfully updated your workshop submission.",
                { position: "bottom-right", duration: 2000 }
              );
            }
          }
        );
      }
    },
    nextIsSection(index) {
      return (
        typeof this.dbform.form[index + 1] !== "undefined" &&
        this.dbform.form[index + 1].type === "section"
      );
    },
    nextId(index) {
      if (typeof this.dbform.form[index + 1] !== "undefined") {
        return "#" + this.dbform.form[index + 1].id;
      }
    },
    getParameterByName(name, url) {
      if (!url) {
        url = window.location.href;
      }
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return "";
      return decodeURIComponent(results[2].replace(/\+/g, " "));
    }
  },
  computed: {
    finishId() {
      return "question-" + this.dbform.form.length;
    },
    buttonText() {
      return this.dbform.button_text !== null
        ? this.dbform.button_text
        : "Save Answers";
    }
  },
  components: {
    Welcome,
    ListInput,
    SectionInput,
    RepeatInput,
    OpinionScaleInput,
    TextareaInput,
    TextInput,
    SelectInput,
    Finish
  }
};
</script>

<style>
.form {
  margin-top: -70px;
}

.section {
  height: 100vh;
  display: flex;
  align-items: center;
}

.question {
  padding: 50px 0;
}

.large-text {
  font-size: 16px;
}

.help-block {
  clear: both;
}

.navbar.navbar-default.navbar-fixed-bottom {
  min-height: 0;
}

.progress {
  margin-bottom: 0;
  border-radius: 0;
}
</style>
