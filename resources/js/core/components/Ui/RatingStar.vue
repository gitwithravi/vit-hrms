<template>
    <div class="flex items-center space-x-1">
        <template v-for="star in rating">
            <span class="fa-stack" style="width: 1em">
                <i class="far fa-star fa-lg fa-stack-1x text-yellow-500"></i>
                <i
                    v-if="star == 'full'"
                    class="fas fa-star fa-lg fa-stack-1x text-yellow-500"
                ></i>
                <i
                    v-else-if="star == 'half'"
                    class="fas fa-star-half fa-lg fa-stack-1x text-yellow-500"
                ></i>
            </span>
        </template>
    </div>
</template>

<script>
export default {
    name: "RatingStar",
}
</script>

<script setup>
const props = defineProps({
    rating: {
        type: Array,
        default: [],
    },
})
</script>
