<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <pre>{{ $page }}</pre>
                    <pre>{{ users }}</pre>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script>
export default {
    name: "Index",
    components: {
        AppLayout,
    },
    props: {
        users: {
            type: Array,
            default: ""
        }
    }
}
</script>

<style scoped>

</style>
