<template>
  <div class="pb-16 pt-4 mt-16 border-t border-mint-500">
    <h2
      class="text-lg text-mint-600 mb-2 uppercase font-semibold leading-normal"
    >{{ question.question}}</h2>
    <p>{{ question.description }}</p>
  </div>
</template>

<script>
export default {
  props: ["question"]
};
</script>

<style>
.large-text {
  font-size: 16px;
}
</style>