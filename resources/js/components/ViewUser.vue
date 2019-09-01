<template>
  <div>
    <button @click.prevent="show = true" :class="classes">View Details</button>

    <portal to="modals" v-if="show">
      <modal :show="show" width="w-2/3">
        <div slot="header" class="p-6 bg-mint-200 flex justify-between">
          <h1 class="text-xl">View {{ user.name }}'s Information</h1>
          <button
            @click="show = false"
            class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
          >
            <i class="fal fa-times fa-fw"></i>
          </button>
        </div>
        <div slot="body" class="p-6 max-h-112 overflow-y-scroll">
          <p>
            <strong>Name:</strong>
            {{ user.name }}
          </p>
          <p>
            <strong>Email:</strong>
            {{ user.email }}
          </p>
          <p>
            <strong>Pronouns:</strong>
            {{ user.profile.pronouns }}
          </p>
          <p>
            <strong>Sexuality:</strong>
            {{ user.profile.sexuality }}
          </p>
          <p>
            <strong>Gender:</strong>
            {{ user.profile.gender }}
          </p>
          <p>
            <strong>Race:</strong>
            {{ user.profile.race }}
          </p>
          <p>
            <strong>College, University or Group:</strong>
            {{ user.profile.college }}
          </p>
          <p>
            <strong>Tshirt:</strong>
            {{ user.profile.tshirt }}
          </p>
          <p>
            <strong>Printed Program:</strong>
            {{ user.profile.wants_program ? 'Yes' : 'No' }}
          </p>
          <p>
            <strong>Accessibility Accommodation:</strong>
            {{ user.profile.accessibility }}
          </p>
          <p>
            <strong>Language Interpretation Services:</strong>
            {{ user.profile.language }}
          </p>
        </div>
        <div slot="footer" class="p-6">
          <button
            type="button"
            class="btn btn-mint"
            @click.prevent="submit"
            :disabled="form.busy"
          >Save</button>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: ["user", "classes"],
  data() {
    return {
      form: new SparkForm({
        name: "",
        email: "",
        pronouns: "",
        sexuality: "",
        gender: "",
        race: "",
        college: "",
        tshirt: "",
        agreement: true,
        wants_program: true,
        accessibility: [],
        language: [],
        other_language: "",
        other_accessibility: "",
        message: ""
      }),
      show: false
    };
  },
  created() {
    this.fillForm(this.user);
  },
  methods: {
    submit() {
      Spark.patch("/profile/" + this.user.id, this.form).then(response => {
        location.reload();
      });
    },
    fillForm(user) {
      this.form.name = this.user.name;
      this.form.email = this.user.email;
      this.form.pronouns = this.user.profile.pronouns;
      this.form.sexuality = this.user.profile.sexuality;
      this.form.gender = this.user.profile.gender;
      this.form.race = this.user.profile.race;
      this.form.college = this.user.profile.college;
      this.form.tshirt = this.user.profile.tshirt;
      this.form.accommodation = this.user.profile.accommodation;
      if (this.user.profile.accessibility !== null) {
        this.form.accessibility = this.user.profile.accessibility;
      }
      this.form.other_accessibility = this.user.profile.other_accessibility;
      if (this.user.profile.language !== null) {
        this.form.language = this.user.profile.language;
      }
      this.form.other_language = this.user.profile.other_language;
    }
  },
  computed: {
    otherLanguage() {
      return _.includes(this.form.language, "other");
    },
    otherAccessibility() {
      return _.includes(this.form.accessibility, "other");
    }
  }
};
</script>