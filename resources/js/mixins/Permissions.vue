<script>
import { usePage } from '@inertiajs/inertia-vue3'

export default {
    methods: {
        $can(permissionName) {
            return usePage().props.value.auth.permissions.indexOf(permissionName) !== -1;
            //return Permissions.indexOf(permissionName) !== -1;
        },
    },
};
</script>
