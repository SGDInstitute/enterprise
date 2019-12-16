<template>
  <div>
    <button @click.prevent="open()" :class="classes">Add Ticket</button>

    <portal to="modals" v-if="show">
        <modal :show="show">
            <div slot="header" class="p-6 bg-mint-200 flex justify-between">
                <h1 class="text-xl">Add Ticket</h1>
                <button
                    @click="show = false"
                    class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
                >
                    <i class="fal fa-times fa-fw"></i>
                </button>
            </div>
            <div slot="body" class="p-6 max-h-full overflow-y-scroll">
                <form action @submit.prevent="submit">
                    <div class="mb-4">
                        <label class="form-label">
                            Select Ticket Type
                        </label>
                        <div>
                            <select name="ticket-type" id="ticket-type">
                                <option value=""></option>
                            </select>
                        </div>
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
                >Add Ticket</button>
            </div>
        </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: ["order", "classes"],
  data() {
    return {
      form: new SparkForm({
        'ticket_type_id': ''
      }),
      show: false,
      ticketTypes: [],
    };
  },
  mounted() {
    this.getTicketTypes();
  },
  methods: {
    getTicketTypes() {
      const self = this;
      axios.get("/api/events/" + this.order.event_id + "/ticket-types?select=available")
          .then(response => {
              self.ticketTypes = response.data.data;
          });
    },
    open() {
      if(this.ticketTypes.length > 1) {
        this.show = true;
      }
      else {
        this.form.ticket_type_id = this.ticketTypes[0].id;
        this.submit();
      }
    },
    submit() {
      Spark.post('/api/orders/' + this.order.id + '/tickets', this.form)
        .then(response => {
            location.reload();
        })
    }
  }
};
</script>