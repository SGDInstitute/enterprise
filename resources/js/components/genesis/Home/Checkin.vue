<template>
  <div
    class="shadow bg-white rounded border-t-4 border-blue-500 p-8 h-full flex flex-col justify-between"
  >
    <div class="mb-4">
      <p
        class="text-lg inline-block bg-transparent text-blue-700 font-semibold py-2 px-4 border-2 border-blue-500 rounded"
      >Check-in</p>
    </div>

    <div class="mb-4">
      <h1 class="text-5xl font-normal mb-8 text-blue-900">Already Registered</h1>

      <p
        class="text-xl leading-normal text-gray-700"
      >Select this option if you've already registered or have been registered for this event. You can check-in yourself or a group.</p>
    </div>

    <div class="flex -mx-4">
      <router-link
        to="/check-in"
        class="no-underline text-center flex-1 mx-4 rounded bg-blue-500 px-4 py-6 text-white font-semibold hover:bg-blue-700"
      >Type Confirmation Number or Ticket Number</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "checkin",
  data() {
    return {
      text: ""
    };
  }
};
</script>
