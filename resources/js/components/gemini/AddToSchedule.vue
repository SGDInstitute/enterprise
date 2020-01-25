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
      axios.post(`/api/gemini/me/activities/${this.id}`).then(response => {
        window.location.reload();
      });
    }
  }
};
</script>