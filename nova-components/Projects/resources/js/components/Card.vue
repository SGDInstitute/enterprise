<template>
  <card class="overflow-scroll">
    <div class="px-3 py-3">
      <h1
        class="text-xs font-normal uppercase tracking-wide text-gray-600 mb-2"
      >Project Names & Descriptions</h1>
      <p class="leading-normal">
        <strong>Dawn:</strong> Donation management
      </p>
      <p class="leading-normal">
        <strong>Enterprise:</strong> Began as registration, but now is the all encompasing app
      </p>
      <p class="leading-normal">
        <strong>Gemini:</strong> Program Guide App
      </p>
      <p class="leading-normal">
        <strong>Genesis:</strong> On-site registration
      </p>
      <p class="leading-normal">
        <strong>Voyager:</strong> Dynamic form builder
      </p>
    </div>
  </card>
</template>

<script>
export default {
  props: [
    "card"

    // The following props are only available on resource detail cards...
    // 'resource',
    // 'resourceId',
    // 'resourceName',
  ],

  mounted() {
    //
  }
};
</script>
