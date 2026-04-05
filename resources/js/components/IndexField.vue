<template>
    <span class="flex items-center gap-1">
        <template v-for="index in outOf" :key="index">
            <!-- Full filled -->
            <span
                v-if="isFullFilled(index, fieldValue)"
                :class="filledColorClass"
                :style="filledColorStyle"
            >
                <span v-if="hasEmoji" class="text-xs leading-none">{{ field.emoji }}</span>
                <span v-else-if="hasCustomSvg" class="w-3 h-3 block" v-html="field.svg"></span>
                <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                    <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                </svg>
            </span>

            <!-- Half filled -->
            <span
                v-else-if="isHalfFilled(index, fieldValue)"
                class="relative w-3 h-3"
            >
                <!-- Empty icon behind -->
                <span class="absolute inset-0 text-gray-200 dark:text-gray-600">
                    <span v-if="hasEmoji" class="text-xs leading-none opacity-30">{{ field.emoji }}</span>
                    <span v-else-if="hasCustomSvg" class="w-3 h-3 block" v-html="field.svg"></span>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                        <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                    </svg>
                </span>
                <!-- Filled half on top -->
                <span
                    class="absolute inset-0"
                    :class="filledColorClass"
                    :style="{ ...filledColorStyle, clipPath: 'inset(0 50% 0 0)' }"
                >
                    <span v-if="hasEmoji" class="text-xs leading-none">{{ field.emoji }}</span>
                    <span v-else-if="hasCustomSvg" class="w-3 h-3 block" v-html="field.svg"></span>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                        <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                    </svg>
                </span>
            </span>

            <!-- Empty -->
            <span v-else class="text-gray-200 dark:text-gray-600">
                <span v-if="hasEmoji" class="text-xs leading-none opacity-30">{{ field.emoji }}</span>
                <span v-else-if="hasCustomSvg" class="w-3 h-3 block" v-html="field.svg"></span>
                <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                    <path fill-rule="evenodd" :d="defaultStarPath" clip-rule="evenodd" />
                </svg>
            </span>
        </template>
    </span>
</template>

<script>
import RatingIcon from './RatingIcon'

export default {
    mixins: [RatingIcon],

    props: ['resourceName', 'field'],

    computed: {
        fieldValue() {
            const val = this.field.displayedAs ?? this.field.value;
            return (parseFloat(val) || 0) * this.outOf;
        },
    },
}
</script>
