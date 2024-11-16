<template>
    <div class="relative ring-1 ring-gray-300 p-2 m-4 rounded-lg bg-white shadow-lg emoji-list">
        <!-- Close button at the top right -->
        <i class="fas fa-times text-gray-600 absolute top-2 right-2 text-xl cursor-pointer" @click="$emit('onClose')"></i>

        <div class="text-center text-gray-600 mb-2 text-sm">Choose an emoji</div>

        <!-- Emoji list container with horizontal scrolling -->
        <div class="overflow-x-auto whitespace-nowrap">
            <ul class="flex">
                <li 
                    class="inline-block mx-2 cursor-pointer hover:bg-gray-200 rounded-full p-2 transition-all duration-200 ease-in-out" 
                    v-for="(emoji, index) in emojiList" 
                    v-html="emoji" 
                    :key="index" 
                    @click="$emit('onSelect', emoji)">
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "EmojiSelect",
    emits: ['onClose', 'onSelect'],
    data() {
        return {
            emojiList: [
                '&#128512;', '&#128513;', '&#128514;', '&#128515;', '&#128516;', '&#128517;',
                '&#128518;', '&#128519;', '&#128521;', '&#128522;', '&#128523;', '&#128524;',
                '&#128525;', '&#128526;', '&#128527;', '&#128528;', '&#128529;', '&#128530;',
                '&#128531;', '&#128532;',
            ]
        }
    }
}
</script>

<style scoped>
/* Style for the emoji list container */
.emoji-list {
    max-width: 280px; /* Limit width for better look */
    overflow-y: hidden;
    max-height: 100px; /* Limit height */
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
}

/* Close button */
.fas.fa-times {
    cursor: pointer;
}

/* Horizontal scrolling container */
.overflow-x-auto {
    overflow-x: auto;
    padding-bottom: 8px;
}

ul {
    display: flex;
    padding-left: 8px;
}

li {
    display: inline-block;
    padding: 10px;
    font-size: 1.6rem;
    cursor: pointer;
    transition: all 0.2s ease-in-out;
}

li:hover {
    background-color: #f0f0f0;
    border-radius: 50%;
}

li:active {
    transform: scale(0.9);
}
</style>
