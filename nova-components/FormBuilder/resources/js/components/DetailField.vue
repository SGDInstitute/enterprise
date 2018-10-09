<template>
    <panel-item :field="field">
        <div slot="value">
            <questions :questions="field.value" detail="true"></questions>
        </div>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
