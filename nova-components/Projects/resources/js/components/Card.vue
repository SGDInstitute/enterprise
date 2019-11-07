<template>
  <card>
    <div class="px-3 py-3">
      <p>
        <strong>Dawn:</strong> Donation management
      </p>
      <p>
        <strong>Enterprise:</strong> Began as just registration, but now is the all encompasing app
      </p>
      <p>
        <strong>Gemini:</strong> Program Guide App
      </p>
      <p>
        <strong>Genesis:</strong> On-site registration
      </p>
      <p>
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
