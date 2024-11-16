<template>
    <li class="flex flex-col mb-4 p-2 rounded-r-full transition-all message-line receiver-message-line">
        <!-- Receiver Username -->
        <div class="mb-1 text-start text-sm text-teal-700 font-semibold message-username">
            {{ message.sender.name }}
        </div>
        
        <!-- Message Content -->
        <div class="text-start text-sm text-black p-3 rounded-lg max-w-[80%] message-text bg-white">
            <p v-html="message.content"></p>
        </div>
        
        <!-- Message Time -->
        <div class="text-start mt-2 text-xs text-[#919191] message-time">
            <i class="fas fa-clock"></i>
            {{ message.time_ago }}
        </div>
    </li>
</template>

<script>
export default {
    name: "Receiver",
    props: ["message"]
}
</script>

<style scoped>
/* Styling the message container */
.message-line {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

/* Username styling */
.message-username {
  font-size: 0.875rem; /* 14px */
  color: #075e54;
}

/* Message bubble styling */
.message-text {
  background-color: #e5e5e5; /* WhatsApp gray for received messages */
  border-radius: 16px;
  padding: 12px;
  color: black;
  font-size: 1rem;
  max-width: 75%; /* Maximum width of the message bubble */
  word-wrap: break-word;
}

/* Time display at the bottom of the message */
.message-time {
  font-size: 0.75rem; /* 12px */
  color: #919191;
  margin-top: 5px;
}

.fas.fa-clock {
  margin-right: 5px;
}

/* Adding slight shadow to the bubble for better visibility */
.message-text {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
</style>
