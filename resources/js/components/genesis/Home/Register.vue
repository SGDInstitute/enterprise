<template>
  <div
    class="shadow bg-white rounded border-t-4 border-green-500 p-8 h-full flex flex-col justify-between"
  >
    <div class="mb-4">
      <p
        class="text-lg inline-block bg-transparent hover:bg-green-500 text-green-700 font-semibold py-2 px-4 border-2 border-green-500 rounded"
      >Register</p>
    </div>

    <div class="mb-4">
      <h1 class="text-5xl font-normal mb-8 text-green-900">I Want To Register</h1>

      <p class="text-xl leading-normal text-gray-700">
        Select this option if you need to register and pay now.
        <br />You can pay with a credit card or a check.
      </p>
    </div>

    <div class="flex -mx-4">
      <a
        href="https://apps.sgdinstitute.org/events/mblgtacc-2020"
        target="_blank"
        class="flex-1 mx-4 rounded bg-green-500 px-4 py-6 text-white font-semibold hover:bg-green-700 text-center no-underline"
      >Register Now</a>
    </div>
  </div>
</template>

<script>
export default {
  name: "register",
  data() {
    return {
      text: ""
    };
  }
};
</script>
