<template>
  <div>
    <button @click.prevent="show = true" :disabled="processing" :class="classes">
      <i class="fal fa-plus-circle fa-fw mr-4" aria-hidden="true"></i>
      {{ action }} Invoice
    </button>

    <portal to="modals" v-if="show">
      <modal :show="show" width="w-5/6 md:w-1/2">
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
          <div v-show="invoice === ''" class="text-center">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
          </div>
          <div v-html="invoice"></div>
        </div>
        <div slot="footer">
          <button type="button" class="btn btn-link" @click.prevent="edit">Edit Invoice</button>
          <button type="button" class="btn btn-gray" @click.prevent="resend">Resend Email</button>
          <a :href="'/invoices/' + order.invoice.id + '/download'" class="btn btn-mint">Download</a>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: ["order"],
  data() {
    return {
      action: "Create",
      icon: "fa-plus-circle",
      invoice: ""
    };
  },
  created() {
    let self = this;
    axios.get("/invoices/" + self.order.invoice.id).then(function(response) {
      self.invoice = response.data.invoice;
    });

    this.action = this.order.invoice === null ? "Create" : "Download";
    this.icon =
      this.order.invoice === null ? "fa-plus-circle" : "fa-arrow-circle-down";
  },
  methods: {
    show() {
      if (this.order.invoice === null) {
        this.eventHub.$emit("showInvoiceForm", "create");
      } else {
        this.eventHub.$emit("showViewInvoice");
      }
    },
    resend() {
      axios
        .get("/invoices/" + self.order.invoice.id + "/resend")
        .then(function() {
          alert("Email sent!");
        });
    },
    edit() {
      $("#viewInvoiceModal").modal("hide");

      this.eventHub.$emit("showInvoiceForm", "edit");
    }
  }
};
</script>