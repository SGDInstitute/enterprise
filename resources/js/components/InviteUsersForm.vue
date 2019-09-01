<template>
  <div>
    <button @click.prevent="show = true" :class="classes">Invite users to fill out information</button>

    <portal to="modals" v-if="show">
      <modal :show="show">
        <div slot="header" class="p-6 bg-mint-200 flex justify-between">
          <h1 class="text-xl">Invite users to fill out information</h1>
          <button
            @click="show = false"
            class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
          >
            <i class="fal fa-times fa-fw"></i>
          </button>
        </div>
        <div slot="body" class="p-6 max-h-full overflow-y-scroll">
          <p class="leading-normal mb-6">
            You can fill out the email fields below to invite users to fill out their own information,
            you can fill as many or as little as you would like.
          </p>

          <form action @submit.prevent="submit">
            <div class="mb-4" v-for="ticket in tickets" :key="ticket.id">
              <label :for="ticket.hash" class="form-label">
                Email for
                #{{ ticket.hash }}
              </label>
              <input
                type="email"
                class="form-control"
                :id="ticket.hash"
                placeholder="Email"
                v-model="form.emails[ticket.hash]"
              />
            </div>

            <div class="alert alert-danger" v-if="form.errors.hasErrors()">
              <ul class="mb-0">
                <li v-for="error in form.errors.all()" :key="error">{{ error[0] }}</li>
              </ul>
            </div>

            <div class="mb-4">
              <label for="message" class="form-label">Add a note to email:</label>
              <textarea
                class="form-control"
                id="message"
                name="message"
                rows="3"
                v-model="form.message"
              ></textarea>
            </div>
          </form>
        </div>
        <div slot="footer" class="p-6">
          <button type="button" class="btn btn-link" @click="show = false">Close</button>
          <button
            type="button"
            class="btn btn-mint"
            @click.prevent="submit"
            :disabled="form.busy"
          >Send invitation email</button>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: ["order", "tickets", "classes"],
  data() {
    return {
      form: new SparkForm({
        emails: {},
        message: ""
      }),
      show: false
    };
  },
  mounted() {
    this.formFill();
  },
  methods: {
    submit() {
      Spark.patch("/orders/" + this.order.id + "/tickets", this.form).then(
        response => {
          location.reload();
        }
      );
    },
    formFill() {
      let self = this;
      _.forEach(this.tickets, function(ticket) {
        self.$set(self.form.emails, ticket.hash, "");
      });
    }
  }
};
</script>