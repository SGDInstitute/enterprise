<template>
    <panel-item :field="field">
        <div slot="value">
            <answers v-bind:value="field.value" :form="field.form" type="detail"></answers>
        </div>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
