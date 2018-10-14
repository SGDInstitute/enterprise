<template>
    <panel-item :field="field">
        <div slot="value">
            <questions v-bind:value="field.value" :form="field.form" type="detail"></questions>
        </div>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
