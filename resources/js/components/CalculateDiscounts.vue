<template>
  <button @click="submit">
    <slot />
  </button>
</template>

<script>
export default {
  props: ["id"],
  methods: {
    submit() {
      axios.post(`/api/events/${this.id}/discounts`).then(response => {
        window.location.reload();
      });
    }
  }
};
</script>