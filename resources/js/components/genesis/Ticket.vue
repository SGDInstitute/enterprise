<template>
  <div class="w-full md:w-1/2">
    <router-link
      :to="'/orders/' + orderId"
      class="flex items-center block p-2 text-gray-200 no-underline hover:text-white mb-4"
    >
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
        <path
          class="fill-current inline"
          d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z"
        />
      </svg>
      <span class="text-lg pl-2">Back</span>
    </router-link>
    <div class="shadow bg-white rounded p-8 h-full overflow-hidden">
      <h1 class="text-3xl font-normal mb-8 text-blue-darker">
        Ticket:
        <small>{{ hash }}</small>
      </h1>

      <div class="mb-4">
        <form class="w-full" @submit.prevent="save">
          <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
              <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold"
                for="name"
              >Name</label>
            </div>
            <div class="md:w-3/4">
              <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                id="name"
                type="text"
                v-model="form.name"
              />
            </div>
          </div>
          <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
              <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold"
                for="email"
              >Email</label>
            </div>
            <div class="md:w-3/4">
              <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                id="email"
                type="email"
                v-model="form.email"
              />
            </div>
          </div>
          <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
              <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold"
                for="pronouns"
              >Pronouns</label>
            </div>
            <div class="md:w-3/4">
              <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                id="pronouns"
                type="text"
                v-model="form.pronouns"
              />
            </div>
          </div>
          <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
              <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold"
                for="sexuality"
              >Sexuality</label>
            </div>
            <div class="md:w-3/4">
              <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                id="sexuality"
                type="text"
                v-model="form.sexuality"
              />
            </div>
          </div>
          <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
              <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold"
                for="gender"
              >Gender</label>
            </div>
            <div class="md:w-3/4">
              <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                id="gender"
                type="text"
                v-model="form.gender"
              />
            </div>
          </div>
          <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
              <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold"
                for="race"
              >Race</label>
            </div>
            <div class="md:w-3/4">
              <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                id="race"
                type="text"
                v-model="form.race"
              />
            </div>
          </div>
          <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/4">
              <label
                class="block uppercase tracking-wide text-grey-darker text-xs font-bold"
                for="college"
              >College</label>
            </div>
            <div class="md:w-3/4">
              <input
                class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-grey"
                id="college"
                type="text"
                v-model="form.college"
              />
            </div>
          </div>
          <div class="md:flex md:items-center">
            <div class="md:w-1/4"></div>
            <div class="md:w-3/4">
              <button class="btn btn-mint" type="submit">Save</button>
              <router-link
                v-if="ticket"
                :to="'/orders/' + orderId"
                class="btn btn-link"
              >Back to Order</router-link>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ticket",
  props: ["number", "hash"],
  data() {
    return {
      ticket: {},
      user: {},
      profile: {},
      form: {
        name: "",
        email: "",
        pronouns: "",
        sexuality: "",
        gender: "",
        race: "",
        college: ""
      }
    };
  },
  created() {
    this.$http.get("/api/tickets/" + this.hash).then(response => {
      this.ticket = response.data;

      if (!_.isEmpty(response.data.user)) {
        this.user = response.data.user;
        this.profile = response.data.user.profile;
        this.loadForm();
      }
    });
  },
  methods: {
    loadForm() {
      this.form.name = this.user.name;
      this.form.email = this.user.email;
      this.form.pronouns = this.profile.pronouns;
      this.form.sexuality = this.profile.sexuality;
      this.form.gender = this.profile.gender;
      this.form.race = this.profile.race;
      this.form.college = this.profile.college;
    },
    save() {
      let self = this;
      this.$http
        .patch("/api/tickets/" + this.hash, this.form)
        .then(response => {
          self.$toasted.success(
            "Successfully updated profile! When ready, go back to order to print your name badge.",
            { duration: 2000 }
          );
        })
        .catch(error => {
          self.$toasted.error("Whoops looks like there was an issue!", {
            duration: 2000
          });
        });
    }
  },
  computed: {
    orderId() {
      return this.number || this.ticket.order_id;
    }
  }
};
</script>
