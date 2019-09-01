<template>
  <div>
    <button :class="classes" @click.prevent="show = true">
      <i class="fal fa-fw fa-usd-circle mr-4"></i> Pay with Check
    </button>

    <portal to="modals" v-if="show">
      <modal :show="show" width="w-2/3">
        <div slot="header" class="p-6 bg-mint-200 flex justify-between">
          <h1 class="text-xl">Pay with Check</h1>
          <button
            @click="show = false"
            class="bg-mint-500 hover:bg-mint-700 rounded-full text-white h-6 w-6 shadow hover:shadow-lg"
          >
            <i class="fal fa-times fa-fw"></i>
          </button>
        </div>
        <div slot="body" class="p-6">
          <p
            class="leading-normal mb-2"
          >Your order total is ${{ order.amount/100 }}. Please create an invoice and make checks payable to the Midwest Institute for Sexuality and Gender Diversity.</p>
          <p class="leading-normal">On the memo line please write: Order {{ order.id }}</p>
        </div>
        <div slot="footer" class="p-6">
          <button type="button" class="btn btn-gray" @click.prevent="show = false">Close</button>
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
      show: false
    };
  }
};
</script>