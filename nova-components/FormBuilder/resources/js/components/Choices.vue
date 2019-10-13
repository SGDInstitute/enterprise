<template>
  <div class="flex">
    <div class="w-1/4 px-8 pb-4">
      <label for="id" class="inline-block text-80 pt-2 leading-tight">Choices</label>
    </div>
    <div class="w-2/3 px-8 pb-4">
      <ul>
        <li v-for="(choice, key) in choices" :key="key">
          <input
            :id="'id' + key"
            v-model="choices[key]"
            placeholder="Choice"
            type="text"
            class="appearance-none bg-transparent border-none w-3/4 text-80 py-1 px-2 leading-tight"
          />
          <a @click.prevent="remove(key)" class="p-1 rounded hover:bg-primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-3">
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
        </li>
      </ul>
      <button @click.prevent="addChoice" class="mt-4 btn btn-default btn-primary">Add Single Choice</button>
      <add-many-choices class="inline-block" v-on:add-choices="addManyChoices"></add-many-choices>
    </div>
  </div>
</template>

<script>
export default {
  props: ["value"],

  data() {
    return {
      choices: []
    };
  },
  created() {
    if (!_.isEmpty(this.value)) {
      this.choices = this.value;
    }
  },
  methods: {
    addChoice() {
      this.choices.push("");
    },
    addManyChoices(choices) {
      this.choices = this.choices.concat(choices);
    },
    remove(key) {
      this.choices.splice(key, 1);
    }
  },
  watch: {
    choices() {
      this.$emit("input", this.choices);
    }
  }
};
</script>
