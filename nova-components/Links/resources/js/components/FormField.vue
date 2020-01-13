<template>
  <field-wrapper>
    <div class="w-1/5 px-8 py-6">
      <slot>
        <form-label :for="field.name">{{ field.name }}</form-label>

        <help-text>{{ field.helpText }}</help-text>
      </slot>
    </div>
    <div class="w-4/5 px-8 py-6">
      <div class="flex mb-4">
        <div class="w-1/4 inline-block text-80 pt-2 leading-tight pl-3">Icon</div>
        <div class="w-1/3 inline-block text-80 pt-2 leading-tight pl-3">Link</div>
        <div class="w-1/4 inline-block text-80 pt-2 leading-tight pl-3">Order</div>
      </div>
      <div v-for="(link, id) in links" class="mb-2">
        <input
          :id="'icon' + id"
          type="text"
          class="w-1/4 form-control form-input form-input-bordered"
          :class="errorClasses"
          placeholder="Icon"
          v-model="link.icon"
        />
        <input
          :id="'link' + id"
          type="text"
          class="w-1/3 form-control form-input form-input-bordered"
          :class="errorClasses"
          placeholder="Link"
          v-model="link.link"
        />
        <input
          :id="'order' + id"
          type="text"
          class="w-1/4 form-control form-input form-input-bordered"
          :class="errorClasses"
          placeholder="Order"
          v-model="link.order"
        />
        <button class="btn btn-default btn-primary" @click.prevent="removeRow(link)">X</button>
      </div>

      <button class="btn btn-default btn-primary" @click.prevent="addRow">Add Link</button>

      <p v-if="hasError" class="my-2 text-danger">{{ firstError }}</p>
    </div>
  </field-wrapper>
</template>

<script>
import { FormField, HandlesValidationErrors } from "laravel-nova";

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ["resourceName", "resourceId", "field"],

  data() {
    return {
      links: []
    };
  },

  methods: {
    /*
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      this.value = this.field.value || [];
      this.links = this.field.value || [];
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || "");
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value;
    },

    addRow() {
      this.links.push({ icon: "", link: "", order: this.links.length + 1 });
    },

    removeRow(link) {
      this.links.splice(this.links.indexOf(link), 1);
    }
  },

  watch: {
    links: {
      handler() {
        this.value = JSON.stringify(this.links);
      },
      deep: true
    }
  }
};
</script>
