<template>
    <div class="message-line-container">
        <!-- Conditionally render the Sender or Receiver message -->
        <Sender :message="message" v-if="auth.id === message.sender_id" />
        <Receiver :message="message" v-else />
    </div>
</template>

<script>
import { inject } from "vue";
import Sender from "@/chat/components/Sender.vue";
import Receiver from "@/chat/components/Receiver.vue";

export default {
    name: "MessageLine",
    components: { Receiver, Sender },
    props: ["message"],
    setup() {
        const auth = inject("auth");
        return { auth };
    },
};
</script>

<style scoped>
.message-line-container {
    margin-bottom: 15px;
    padding-left: 15px;
    padding-right: 15px;
}

/* Ensuring correct margins between sent and received messages */
.message-line-container > *:first-child {
    margin-top: 0; /* Remove extra margin on the first message */
}

.message-line-container > *:last-child {
    margin-bottom: 0; /* Remove extra margin on the last message */
}
</style>
