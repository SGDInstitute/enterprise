<template>
  <form action @submit.prevent="submit">
    <div class="mb-4">
      <label for="old-password" class="form-label">Old Password</label>
      <input
        id="old-password"
        type="password"
        class="form-control"
        :class="{'is-invalid': form.errors.has('old_password')}"
        v-model="form.old_password"
      />
      <span
        class="invalid-feedback"
        v-show="form.errors.has('old_password')"
      >{{ form.errors.get('old_password') }}</span>
    </div>
    <div class="mb-4">
      <label for="password" class="form-label">New Password</label>

      <input
        id="password"
        type="password"
        class="form-control"
        :class="{'is-invalid': form.errors.has('password')}"
        v-model="form.password"
      />
      <span class="text-xs italic">
        Your password must be at least 8 characters in length, with at least 3 of 4 of the following:
        <br />upper case letter, lower case letter, number, or special character.
      </span>
      <span
        class="invalid-feedback"
        :class="{'show': form.errors.has('password')}"
      >{{ form.errors.get('password') }}</span>
    </div>
    <div class="mb-4">
      <label for="password-confirm" class="form-label">Confirm Password</label>

      <input
        id="password-confirm"
        type="password"
        class="form-control"
        name="password_confirmation"
        :class="{'is-invalid': form.errors.has('password_confirmation')}"
        v-model="form.password_confirmation"
      />
      <span
        class="invalid-feedback"
        v-show="form.errors.has('password_confirmation')"
      >{{ form.errors.get('password_confirmation') }}</span>
    </div>

    <button type="submit" class="btn btn-mint">Save Password</button>
  </form>
</template>

<script>
export default {
  data() {
    return {
      form: new SparkForm({
        old_password: "",
        password: "",
        password_confirmation: ""
      })
    };
  },
  methods: {
    submit() {
      Spark.post("/settings/password", this.form)
        .then(response => {
          this.form.old_password = "";
          this.form.password = "";
          this.form.password_confirmation = "";
        })
        .catch(response => {});
    }
  }
};
</script>