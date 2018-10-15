<template>
    <panel-item :field="field">
        <div slot="value">
            <a v-for="link in field.value" :href="link.link" target="_blank"
               class="cursor-pointer dim inline-block text-primary font-bold mr-4">{{ link.icon }}</a>
        </div>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
