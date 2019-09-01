<template>
  <form action @submit.prevent="submit">
    <div class="mb-4">
      <label for="name" class="form-label">
        Name*
        <span class="lowercase">(as you would like it to appear on your name badge)</span>
      </label>
      <input
        type="text"
        class="form-control"
        id="name"
        :class="{'is-invalid': form.errors.has('name')}"
        v-model="form.name"
      />
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('name')"
      >{{ form.errors.get('name') }}</span>
    </div>
    <div class="mb-4">
      <label for="email" class="form-label">Email*</label>
      <input
        type="email"
        class="form-control"
        id="email"
        :class="{'is-invalid': form.errors.has('email')}"
        v-model="form.email"
      />
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('email')"
      >{{ form.errors.get('email') }}</span>
    </div>
    <div class="mb-4">
      <label for="pronouns" class="form-label">Pronouns</label>
      <input
        type="text"
        class="form-control"
        id="pronouns"
        :class="{'is-invalid': form.errors.has('pronouns')}"
        v-model="form.pronouns"
      />
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('pronouns')"
      >{{ form.errors.get('pronouns') }}</span>
    </div>
    <div class="mb-4">
      <label for="sexuality" class="form-label">Sexuality</label>
      <input
        type="text"
        class="form-control"
        id="sexuality"
        :class="{'is-invalid': form.errors.has('sexuality')}"
        v-model="form.sexuality"
      />
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('sexuality')"
      >{{ form.errors.get('sexuality') }}</span>
    </div>
    <div class="mb-4">
      <label for="gender" class="form-label">Gender</label>
      <input
        type="text"
        class="form-control"
        id="gender"
        :class="{'is-invalid': form.errors.has('gender')}"
        v-model="form.gender"
      />
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('gender')"
      >{{ form.errors.get('gender') }}</span>
    </div>
    <div class="mb-4">
      <label for="race" class="form-label">Race</label>
      <input
        type="text"
        class="form-control"
        id="race"
        :class="{'is-invalid': form.errors.has('race')}"
        v-model="form.race"
      />
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('race')"
      >{{ form.errors.get('race') }}</span>
    </div>
    <div class="mb-4">
      <label for="college" class="form-label">College, University, or Group</label>
      <input
        type="text"
        class="form-control"
        id="college"
        :class="{'is-invalid': form.errors.has('college')}"
        v-model="form.college"
      />
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('college')"
      >{{ form.errors.get('college') }}</span>
    </div>
    <div class="mb-4">
      <label for="tshirt" class="form-label">T-Shirt Size</label>
      <div class="relative">
        <select
          name="tshirt"
          id="tshirt"
          class="form-control"
          :class="{'is-invalid': form.errors.has('tshirt')}"
          v-model="form.tshirt"
        >
          <option value="S">S</option>
          <option value="M">M</option>
          <option value="L">L</option>
          <option value="XL">XL</option>
          <option value="2XL">2XL</option>
          <option value="3XL">3XL</option>
          <option value="4XL">4XL</option>
          <option value="5XL">5XL</option>
        </select>
        <div
          class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
        >
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
          </svg>
        </div>
      </div>
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('tshirt')"
      >{{ form.errors.get('tshirt') }}</span>
    </div>

    <div class="mt-6 mb-4">
      <label :class="{'is-invalid': form.errors.has('agreement')}" for="agreement">
        <input
          type="checkbox"
          name="agreement"
          id="agreement"
          :value="true"
          v-model="form.agreement"
        />
        I agree to the
        code for inclusion,
        photo policy, and
        refund policy.
      </label>
      <span
        class="text-red-500 block mt-2 italic"
        :class="{'block': form.errors.has('agreement')}"
        v-show="form.errors.has('agreement')"
      >{{ form.errors.get('agreement') }}</span>
    </div>

    <div class="mt-6 mb-4">
      <label for="program" class="form-label">Would you like printed program?</label>
      <label for="program-yes" class="mr-4">
        <input
          type="radio"
          id="program-yes"
          :class="{'is-invalid': form.errors.has('program')}"
          v-model="form.wants_program"
          value="true"
          checked
        />
        Yes
      </label>
      <label for="program-no">
        <input
          type="radio"
          id="program-no"
          :class="{'is-invalid': form.errors.has('program')}"
          v-model="form.wants_program"
          value="false"
        />
        No, I will use the mobile app
      </label>
      <span
        class="text-red-500 block mt-2 italic"
        v-show="form.errors.has('program')"
      >{{ form.errors.get('program') }}</span>
    </div>

    <div class="mt-6 mb-4">
      <label for="accommodation" class="form-label">Accessibility Accommodation</label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.accessibility" value="22pt-book" /> Printed program with 22pt font
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.accessibility" value="xl-book" /> Printed program with larger than 22pt font
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.accessibility" value="wheelchair" /> Wheelchair
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.accessibility" value="oncampus-transportation" /> Transportation from Plenary to Workshops (approx. ___ mile walking)
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.accessibility" value="hotel-transportation" /> Mechanized wheelchair accessible transportation from Conference hotels to Conference
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.accessibility" value="other" /> Other
      </label>
      <div class="block mb-2 ml-6" v-if="otherAccessibility">
        <label for="language-other" class="form-label">What can we provide?</label>
        <input type="text" class="form-control" v-model="form.other_accessibility" />
      </div>
    </div>
    <div class="mt-6 mb-4">
      <label class="form-label">Language Interpretation Services</label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.language" value="closed-captioning" /> Closed Captioning
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.language" value="asl" /> ASL Interpreter
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.language" value="spanish" /> Spanish Interpreter
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.language" value="arabic" /> Arabic Interpreter
      </label>
      <label class="block mb-2">
        <input type="checkbox" v-model="form.language" value="other" /> Interpreter for Another Language
      </label>
      <div class="block mb-2 ml-6" v-if="otherLanguage">
        <label for="language-other" class="form-label">What language?</label>
        <input type="text" class="form-control" v-model="form.other_language" />
      </div>
    </div>

    <button type="submit" class="btn btn-mint">Save Profile</button>
  </form>
</template>

<script>
export default {
  props: ["user", "profile"],
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
        agreement: false,
        wants_program: true,
        accessibility: [],
        language: [],
        other_language: "",
        other_accessibility: ""
      })
    };
  },
  created() {
    this.form.name = this.user.name;
    this.form.email = this.user.email;
    this.form.pronouns = this.profile.pronouns;
    this.form.sexuality = this.profile.sexuality;
    this.form.gender = this.profile.gender;
    this.form.race = this.profile.race;
    this.form.college = this.profile.college;
    this.form.tshirt = this.profile.tshirt;
    this.form.accommodation = this.profile.accommodation;
    this.form.agreement = this.profile.agreement;
    if (this.profile.accessibility !== null) {
      this.form.accessibility = this.profile.accessibility;
    }
    this.form.other_accessibility = this.profile.other_accessibility;
    if (this.profile.language !== null) {
      this.form.language = this.profile.language;
    }
    this.form.other_language = this.profile.other_language;
  },
  methods: {
    submit() {
      var self = this;

      Spark.patch("/profile", this.form).then(function(response) {
        self.$toasted.show("Successfully updated your profile", {
          duration: 5000,
          type: "success"
        });
      });
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