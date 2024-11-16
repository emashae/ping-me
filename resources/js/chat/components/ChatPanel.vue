<template>
    <div class="flex flex-col inline-block relative mx-2.5 w-80 z-99999 ring chat-panel">
        <!-- Header (User Info) -->
        <header class="px-4 py-4 flex flex-row items-center bg-teal-700 shadow-md rounded-t-lg">
            <i class="fas fa-solid fa-times shrink mx-2 text-white cursor-pointer" title="close" @click="$emit('onCloseChat', user)"></i>
            <div class="flex-2 grow basis-1/2 text-white font-semibold">{{ user.name }}</div>
        </header>

        <!-- Chat Content -->
        <section class="px-4 py-4 h-72 overflow-y-scroll chat-panel-content" ref="chatContentRef" @scroll="handleChatScroll">
            <i class="fas fa-circle-notch fa-spin absolute left-36 top-16 text-3xl" v-if="loading"></i>

            <ul class="space-y-4">
                <MessageLine v-for="userMessage in userMessages" :key="userMessage.id" :message="userMessage" />
            </ul>
        </section>

        <!-- Emoji Select Modal -->
        <EmojiSelect v-if="emojiBtnClicked" @onSelect="handleSelectEmoji" @onClose="emojiBtnClicked = false" />

        <!-- Footer (Message Input Area) -->
        <footer class="flex flex-row items-center px-4 py-2 bg-gray-100 rounded-b-lg shadow-md">
            <button class="text-2xl font-bold text-gray-600 mx-2" type="button" title="Add emoji" @click="showEmojiList">
                &#128512;
            </button>
            <textarea name="currentMessage" class="grow p-2 border border-solid border-gray-300 rounded-lg resize-none" v-model="messageContent" placeholder="Type a message..." />
            <a href="#" @click.prevent="submitMessage" class="px-2 py-1 h-full bg-blue-700 text-white rounded-full ml-2 flex items-center justify-center">
                <i class="fas fa-paper-plane mx-1"></i> Send
            </a>
        </footer>
    </div>
</template>

<script>
import { ref, watch } from "vue";
import _ from "lodash";
import MessageLine from "@/chat/components/MessageLine.vue";
import EmojiSelect from "@/chat/components/EmojiSelect.vue";
import axios from "axios"; 

export default {
    name: "ChatPanel",
    components: { EmojiSelect, MessageLine },
    props: ["user", "emittedMessage"],
    emits: ["onCloseChat"],
    setup(props) {
        const { user } = props;
        const chatContentRef = ref(null);
        const messageContent = ref("");
        const userMessages = ref([]);
        const scrollPoint = ref(0);
        const loading = ref(false);
        const emojiBtnClicked = ref(false);

        function handleSelectEmoji(emojiHtml) {
            sendMessage(user.id, emojiHtml);
        }

        function showEmojiList() {
            emojiBtnClicked.value = true;
        }

        function showLoading() {
            loading.value = true;
        }

        function hideLoading() {
            loading.value = false;
        }

        function submitMessage() {
            if (!messageContent.value) {
                return;
            }

            sendMessage(user.id, messageContent.value, () => {
                messageContent.value = "";
            });
        }

        function sendMessage(receiverId, messageContent, cb = null) {
            const payload = {
                receiver_id: receiverId,
                message_content: messageContent
            };

            axios.post("/messages", payload)
                .then((response) => {
                    if (response && response.data.status) {
                        userMessages.value.push(response.data.message);
                        if (cb) cb();
                        scrollToChatBottom();
                    }
                })
                .catch((error) => {
                    console.error("Error sending message:", error.response);
                });
        }

        async function getMessages() {
            try {
                showLoading();
                const result = await axios.get(`/messages?receiver_id=${user.id}`);
                hideLoading();

                if (result.data.messages) {
                    userMessages.value = result.data.messages.reverse();
                    scrollToChatBottom();
                }
            } catch (error) {
                hideLoading();
                console.error("Error fetching messages:", error.response);
            }
        }

        function scrollToChatBottom() {
            setTimeout(() => {
                if (chatContentRef && chatContentRef.value) {
                    chatContentRef.value.scrollTop = chatContentRef.value.scrollHeight;
                    scrollPoint.value = chatContentRef.value.scrollTop;
                }
            }, 300);
        }

        const handleChatScroll = _.debounce((e) => {
            if (e.target.scrollTop - 50 < scrollPoint.value) {
                showLoading();

                const oldMessage = userMessages.value[0];

                axios.get(`/messages?receiver_id=${user.id}&earlier_date=${oldMessage.created_at}`)
                    .then((response) => {
                        if (response && response.data.messages) {
                            const filtered = [];

                            response.data.messages.reverse().forEach((message) => {
                                if (!userMessages.value.find((m) => m.id == message.id)) {
                                    filtered.push(message);
                                }
                            });

                            userMessages.value = [...filtered, ...userMessages.value];
                        }

                        setTimeout(() => {
                            hideLoading();
                        }, 2000);
                    })
                    .catch((error) => {
                        setTimeout(() => {
                            hideLoading();
                        }, 2000);

                        console.error("Error fetching older messages:", error.response);
                    });
            }

            scrollPoint.value = e.target.scrollTop;
        }, 1000);

        getMessages();

        watch(() => props.emittedMessage, (newMessage) => {
            if (newMessage) {
                const isMessageExist = userMessages.value.find((m) => m.id == newMessage.id);
                if (!isMessageExist) {
                    userMessages.value.push(newMessage);
                    scrollToChatBottom();
                }
            }
        });

        return {
            messageContent,
            submitMessage,
            userMessages,
            chatContentRef,
            handleChatScroll,
            loading,
            emojiBtnClicked,
            showEmojiList,
            handleSelectEmoji
        };
    }
};
</script>

<style scoped>
.chat-panel {
    background-color: #f1f1f1;
    border-radius: 15px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
}

header {
    background-color: #128c7e;
    color: white;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.chat-panel-footer {
    background-color: #ffffff;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
}

textarea {
    min-height: 40px;
    max-height: 60px;
    overflow-y: auto;
    resize: none;
    border-radius: 20px;
}

ul {
    padding-left: 0;
    margin-top: 0;
    list-style: none;
}

button {
    background-color: transparent;
    border: none;
    color: #128c7e;
    cursor: pointer;
}

button:focus {
    outline: none;
}

footer a {
    border-radius: 50%;
    padding: 10px;
}

footer .grow {
    flex-grow: 1;
}

i.fas.fa-paper-plane {
    font-size: 18px;
}
</style>
