<template>
  <div>
    <button @click.prevent="show = true" :disabled="processing" :class="classes">
      <i class="fal fa-file-pdf fa-fw mr-4" aria-hidden="true"></i> View Invoice
    </button>

    <portal to="modals" v-if="show">
      <modal :show="show" width="w-2/3">
        <div slot="header" class="p-6 bg-mint-200 flex justify-between">
          <h1 class="text-xl">View Invoice</h1>
          <button
            @click="cancel"
            class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
          >
            <i class="fal fa-times fa-fw"></i>
          </button>
        </div>
        <div slot="body">
          <div v-show="receipt === ''" class="text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
          </div>
          <div v-html="receipt" class="max-h-112 overflow-y-scroll"></div>
        </div>
        <div slot="footer" class="p-6">
          <button type="button" class="btn btn-gray" @click.prevent="resend">Resend Email</button>
          <a
            :href="'/orders/' + order.id + '/invoice?print=true'"
            target="_blank"
            class="btn btn-mint"
          >Download</a>
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
      invoice: "",
      show: false
    };
  },
  created() {
    self = this;
    axios.get("/orders/" + self.order.id + "/invoice").then(function(response) {
      self.invoice = response.data.invoice;
    });
  },
  methods: {
    cancel() {
      this.show = false;
    },
    resend() {
      axios
        .get("/invoices/" + self.order.invoice.id + "/resend")
        .then(function() {
          alert("Email sent!");
        });
    }
  }
};
</script>